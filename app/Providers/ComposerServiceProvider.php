<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Repositories\SettingRepository;
use App\Repositories\BrandRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\ProductRepository;
use Storage;
use App\Lib\Location;
use App;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    

    public function boot(SettingRepository $settingRepo, BrandRepository $brandRepo, CategoryRepository $catRepo, ProductRepository $prodRepo)
    {
        View::composer(
            'partials.box-top-content',
            'App\Http\ViewComposers\LatestNewsComposer'
        );
        View::composer(
            'partials.hot-news',
            'App\Http\ViewComposers\HotNewsComposer'
        );

        View::composer(
            'partials.header',
            'App\Http\ViewComposers\HeaderComposer'
        );

        View::composer('*', function ($view) use ($settingRepo, $brandRepo, $catRepo, $prodRepo) {
            if (App::isLocale('en')) {
                $view->with('productConfig', config('product_en'));
            } else {
                $view->with('productConfig', config('product'));
            }

            $banners = [];
            $settings = $settingRepo->getByGroup('banner');
            foreach ($settings as $setting) {
                $data = json_decode($setting->value, true);
                $data['image_url'] = '';
                if (!empty($data['image'])) {
                    $data['image_url'] = Storage::disk('public')->url('uploads/banners/' . $data['image']);
                }
                $banners[$setting->key] = $data;
            }
            $view->with('banners', $banners);


            $seos = [];
            $settings = $settingRepo->getByGroup('seo');
            foreach ($settings as $setting) {
                $seos[$setting->key] = $setting->value;                 
                if($setting->key == 'fb_image'){
                    $seos['fb_image_url'] = Storage::disk('public')->url('uploads/banners/' . $setting->value);
                }
            }
            $view->with('seos', $seos);


            $settings = $settingRepo->getByGroup('all');
            $allSettings = [];
            foreach ($settings as $setting) {
                if (is_int($setting->value)) {
                    $allSettings[$setting->key] = intval($setting->value);
                } else if (is_float($setting->value)) {
                    $allSettings[$setting->key] = floatval($setting->value);
                } else {
                    $allSettings[$setting->key] = $setting->value;
                }
            }

            $view->with('allSettings', $allSettings);

            $brands = $brandRepo->all();
            $view->with('brands', $brands);


            /**
             * keywords suggestion
             */
            $catID = session()->get('search.category_parent');
            $subCatID = session()->get('search.category');
            $cityID = session()->get('search.city');
            $districtID = session()->get('search.district');
            $subCatData = $catRepo->all();
            // HN, HCM, DN
            $cityIDs = [24, 29, 15];
            $keywordData = [];
            $defaultKeywordData = [];
            if (App::isLocale('en')) {
                $cats = array_slice(config('product_en.category'), 0, 5);
            } else {
                $cats = array_slice(config('product.category'), 0, 5);
            }

            foreach ($cats as $cat) {
                $box = [
                    'title' => $cat['name'],
                    'url' => route('category', ['slug' => $cat['slug']]),
                    'keywords' => [],
                ];

                $cityData = $prodRepo->getCountActiveProductByCity($cat['id']);
                $cityData = $cityData->slice(0, 15);                
                foreach ($cityData as $data) {
                    $city = Location::getCity($data['city']);
                    $slugCity = str_slug($city['name']);   
                    $box['keywords'][] = [
                        'text' => $cat['name'] . ' ở ' . $city['name'] . ' (' . $data['count'] . ')',
                        'url' => route('category', [
                            'catSlug' => $cat['slug'],
                            'city' => $slugCity,
                        ]),
                    ];
                }
                $defaultKeywordData[] = $box;
            }

            // dd($cityID, $catID, $subCatID, $districtID);
            $city = $cityID ? Location::getCity($cityID) : null;
            $cat = $catID ? $catRepo->getParentCategoryByID($catID) : null;
            $subCat = $subCatID ? $catRepo->getById($subCatID) : null;
            $district = $districtID ? Location::getDistrict($districtID) : null;
            $slugCity = str_slug($city['name']);            
            if ($city && $cat && $subCat && $district) {
                $box = [
                    'title' => $subCat->name . ' ở ' . $city['name'],
                    'keywords' => [],
                ];
                foreach ($city['district'] as $d) {
                    $count = $prodRepo->getCountBySubCatAndDistrict($subCat->id, $d['id']);
                    $slugDistrict = str_slug($d['name']);
                    if ($count == 0) {
                        continue;
                    }
                    $box['keywords'][] = [
                        'text' => $subCat->name . ' ở ' . $d['name'] . ' (' . $count . ')',
                        'url' => route('subcatdistrict', [
                            'slug' => $subCat->slug,
                            'catSlug' => $cat['slug'],
                            'city' => $slugCity,
                            'district' => $slugDistrict,
                        ]),
                    ];
                }
                $keywordData[] = $box;
            } else if ($cat && $subCat && !$city) {

                $box = [
                    'title' => $cat['name'] . ' ' . $subCat->name,
                    'keywords' => [],
                ];
		
                $cityData = $prodRepo->getCountActiveProductByCity($cat['id'], $subCat->id);
                $cityData = $cityData->slice(0, 15);
                foreach ($cityData as $data) {
                    if ($data['count'] == 0) {
                        continue;
                    }
                    $city = Location::getCity($data['city']);

                    $slugCity = str_slug($city['name']);

                  
                    $box['keywords'][] = [
                        'text' => $city['name'] . ' (' . $data['count'] . ')',
                        'url' => route('subcatcity', [
                            'slug' => $subCat->slug,
                            'catSlug' => $cat['slug'],
                            'city' => $slugCity,
                        ]),
                    ];
                }

                $keywordData[] = $box;
            } else if ($cat && $subCat && $city) {

                $box = [
                    'title' => $cat['name'] . ' ở ' . $city['name'],
                    'keywords' => [],
                ];
		
                $subCats = $subCatData->where('parent_id', $cat['id']);
                $slugCity = str_slug($city['name']);
                foreach ($subCats as $subCat) {
                    $count = $prodRepo->getCountBySubCatAndCity($subCat->id, $cityID);
                    if ($count == 0) {
                        continue;
                    }
                    $box['keywords'][] = [
                        'text' => $subCat->name . ' ở ' . $city['name'] . ' (' . $count . ')',
                        'url' => route('subcat', [
                            'slug' => $subCat->slug,
                            'catSlug' => $cat['slug'],
                            'city' => $slugCity,
                        ]),
                    ];
                }
                $keywordData[] = $box;
            } else if ($city && $cat) {
                $box = [
                    'title' => $cat['name'] . ' ở ' . $city['name'],
                    'keywords' => [],
                ];
	
                $subCats = $subCatData->where('parent_id', $cat['id']);
                $slugCity = str_slug($city['name']);
                foreach ($subCats as $subCat) {
                    $count = $prodRepo->getCountBySubCatAndCity($subCat->id, $cityID);
                    if ($count == 0) {
                        continue;
                    }
                    $box['keywords'][] = [
                        'text' => $subCat->name . ' ở ' . $city['name'] . ' (' . $count . ')',
                        'url' => route('subcat', [
                            'slug' => $subCat->slug,
                            'catSlug' => $cat['slug'],
                            'city' => $slugCity,
                        ]),
                    ];
                }
                $keywordData[] = $box;
            } elseif ($cat) {
                $box = [
                    'title' => $cat['name'],
                    'keywords' => [],
                ];

                $cityData = $prodRepo->getCountActiveProductByCity($cat['id']);
                $cityData = $cityData->slice(0, 15);                
                foreach ($cityData as $data) {
                    if ($data['count'] == 0) {
                        continue;
                    }
                    $city = Location::getCity($data['city']);
                    $slugCity = str_slug($city['name']);
                    $box['keywords'][] = [
                        'text' => $cat['name'] . ' ở ' . $city['name'] . ' (' . $data['count'] . ')',
                        'url' => route('subcat', [
                            'catSlug' => $cat['slug'],
                            'city' => $slugCity,
                        ]),
                    ];
                }
		
                $keywordData[] = $box;
            } else {
                $keywordData = $defaultKeywordData;
		
            }
             // dd($keywordData);
		
				
                	foreach($keywordData as $data){
                    		foreach ($data['keywords'] as $row) {
                        		$row['url'] = str_replace("?city=", "/", $row['url']);
					// echo($row['url']);
                    		}
                	}
            	

            $view->with('defaultKeywordData', $defaultKeywordData);
            $view->with('keywordData', $keywordData);
        });
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
