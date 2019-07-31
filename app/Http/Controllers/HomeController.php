<?php

namespace App\Http\Controllers;

use App\Repositories\ServiceRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Repositories\ProductRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\PostRepository;
use Illuminate\Support\Facades\Auth;
use App;
use Illuminate\Support\Facades\URL;
use Laravelium\Sitemap\Sitemap;

class HomeController extends Controller
{

    protected $productRepo;
    protected $catRepo;
    protected $postRepo;
    protected $sericeRepository;

    public function __construct(ProductRepository $productRepo, CategoryRepository $catRepo,
                                PostRepository $postRepo, ServiceRepository $serviceRepository)
    {
        $this->middleware('auth')->only(['upload-image']);

        $this->productRepo = $productRepo;
        $this->catRepo = $catRepo;
        $this->postRepo = $postRepo;
        $this->sericeRepository = $serviceRepository;
    }

    public function index()
    {
        $panoProducts = $this->productRepo->getByParams([
            'category_parent' => config('product.category')[0]['id'],
            'lang' => $this->getLang(),
            'status' => [
                config('product.status.active'),
                config('product.status.disabled'),
            ],
        ], 4);
        $adProducts = $this->productRepo->getByParams([
            'category_parent' => config('product.category')[1]['id'],
            'lang' => $this->getLang(),
            'status' => [
                config('product.status.active'),
                config('product.status.disabled'),
            ],
        ], 4);
        $socialProducts = $this->productRepo->getByParams([
            'category_parent' => config('product.category')[2]['id'],
            'lang' => $this->getLang(),
            'status' => [
                config('product.status.active'),
                config('product.status.disabled'),
            ],
        ], 4);
        $webProducts = $this->productRepo->getByParams([
            'category_parent' => config('product.category')[3]['id'],
            'lang' => $this->getLang(),
            'status' => [
                config('product.status.active'),
                config('product.status.disabled'),
            ],
        ], 4);
        $otherProducts = $this->productRepo->getByParams([
            'category_parent' => config('product.category')[4]['id'],
            'lang' => $this->getLang(),
            'status' => [
                config('product.status.active'),
                config('product.status.disabled'),
            ],
        ], 4);
        $findProducts = $this->productRepo->getByParams([
            'category_parent' => config('product.category')[5]['id'],
            'lang' => $this->getLang(),
            'status' => [
                config('product.status.active'),
                config('product.status.disabled'),
            ],
        ], 4);
        // Post
        $phanTich = $this->postRepo->getByOption([
            'cat' => config('post.category.phan_tich'),
            'status' => config('post.status.active'),
            'lang' => $this->getLang(),
        ], 9);
        $suKien = $this->postRepo->getByOption([
            'cat' => config('post.category.su_kien'),
            'status' => config('post.status.active'),
            'lang' => $this->getLang(),
        ], 8);
        $kinhNghiem = $this->postRepo->getByOption([
            'cat' => config('post.category.kinh_nghiem'),
            'status' => config('post.status.active'),
            'lang' => $this->getLang(),
        ], 9);
        $thuongHieu = $this->postRepo->getByOption([
            'cat' => config('post.category.thuong_hieu_san_pham'),
            'status' => config('post.status.active'),
            'lang' => $this->getLang(),
        ], 8);
        $breadcrumb = 'home';

        return view('home', compact(
            'panoProducts',
            'adProducts',
            'socialProducts',
            'otherProducts',
            'findProducts',
            'webProducts',
            'suKien',
            'phanTich',
            'kinhNghiem',
            'thuongHieu',
            'breadcrumb'
        ));
    }

    public function search()
    {
        $keyword = request()->input('s', '');

        $params = [
            'keyword' => $keyword,
        ];
        $products = $this->productRepo->paginate($params, 16);

        return view('pages.category', [
            'products' => $products,
            'keyword' => $keyword
        ]);
    }

    protected $pages = [
        '' => 'Hướng dẫn về vietnamads.vn',
        'banner-phien-ban-desktop' => 'Banner phiên bản desktop',
        'banner-phien-ban-mobile' => 'Banner phiên bản mobile',
        'bao-gia' => 'Báo giá tin rao',
        'dich-vu-sms' => 'Dịch vụ sms',
        'dich-vu-le' => 'Dịch vụ lẻ',
        'ho-tro' => 'Hỗ trợ',
        'dang-ky-tai-khoan-thanh-vien' => 'Đăng ký tài khoản thành viên',
        'quy-dinh-dang-tin' => 'Quy định đăng tin',
        'dang-tin-va-sua-tin' => 'Đăng tin và sửa tin',
        'thanh-toan' => 'Thanh toán',
        'day-tin-len-top' => 'Đẩy tin lên top',
        'cac-thu-muc-dang-tin' => 'Các thư mục đăng tin',
        'nhan-tin-qua-email' => 'Nhận tin qua email',
        'tai-khoan-vip' => 'Tài khoản VIP',
        'huong-dan-trang-quan-tri' => 'Hướng dẫn trang quản trị',
        'cac-cau-hoi-thuong-gap' => 'Các câu hỏi thường gặp',
        'hieu-qua-tu-vietnamads' => 'Hiệu quả từ vietnamads.vn',
        'dieu-khoan-thoa-thuan' => 'Điều khoản thỏa thuận',
        'quy-che-hoat-dong' => 'Quy chế hoạt động',
        'giai-quyet-khieu-nai' => 'Giải quyết khiếu nại',
        'chinh-sach-bao-mat' => 'Chính sách bảo mật',
        'tuyen-dung' => 'Tuyển dụng',
        'gioi-thieu' => 'Giới thiệu về VietNamAds.vn',
        'banner-quang-cao' => 'Banner quảng cáo',
        'nhom-tin-noi-bat' => 'Nhóm tin nổi bật',
        'bai-viet-tin-tuc' => 'Bài viết về tin tức',
        'lien-ket-tai-tro' => 'Liên kết và tài trợ',
        'ho-tro' => 'Hỗ trợ',
    ];

    public function about($page = '')
    {
        $page = 'gioi-thieu';
        $slug = 'gioi-thieu';
        if (isset($this->pages[$page])) {
            $page = $this->pages[$page];
        } else {
            $page = 'Giới thiệu';
        }
        return view('pages.about', compact('page', 'slug'));
    }

    public function baoMat()
    {
        return view('pages.bao-mat');
    }

    public function tranhChap()
    {
        return view('pages.tranh-chap');
    }

    public function hoatDong()
    {
        return view('pages.hoat-dong');
    }

    public function pricing($page = '')
    {
        $servicePackages = $this->sericeRepository->getAllServicePackages(false, Auth::user());
        return view('pages.pricing', [
            'servicePackages' => $servicePackages,
        ]);
    }

    public function guide($page = '')
    {
        $slug  = $page;
        if (isset($this->pages[$page])) {
            $page = $this->pages[$page];
        } else {
            $page = 'Hướng dẫn';
        }
        $viewFile = str_replace('-', '_', $slug);
        if (!view()->exists('pages.'.$viewFile)) {
            $viewFile = 'guide'; //
        }
        return view('pages.'.$viewFile, compact('page', 'slug'));
    }

    public function contact()
    {
        return view('pages.contact');
    }

    public function demoProduct()
    {
        return view('pages.demo-products');
    }

    public function productData(Request $request)
    {
        $product = null;
        if ($request->input('currentId')) {
            $product = $this->productRepo->getById($request->input('currentId'));
        }
        if ($product) {
            $product->direct_link = explode(',', $product->direct_link) + [
                    '', '', '', ''
                ];
            $product->direct_link = array_slice($product->direct_link, 0, 4);
            foreach ($product->direct_link as $index => $link) {
                $_tmp = 'direct_link'.($index + 1);
                $product->$_tmp = $link;
            }
        }

        $categories = $this->catRepo->allByOrder();
        $servicePackages = $this->sericeRepository->getAllServicePackages(true, Auth::user());
        return response()->json([
            'product' => config('product'),
            'category' => $categories,
            'servicePackages' => $servicePackages,
            'currentProduct' => $product,
        ]);
    }

    public function consult()
    {
        $products = $this->productRepo->paginate([], 16);
        return view('pages.consult', compact('products'));
    }

    public function changeLocale(Request $request, $locale)
    {
        if (!in_array($locale, ['en', 'vi'])) {
            $locale = 'en';
        }
        $request->session()->put('locale', $locale);
        return redirect()->route('home');
    }

    public function sitemap(Request $request) {
        $sitemap = \Illuminate\Support\Facades\App::make('sitemap');
        /** @var Sitemap $sitemap */
        $sitemap->add(URL::to('/'), Carbon::now(), '1.0', 'daily');
        $sitemap->add(route('pricing'), Carbon::now(), '0.8', 'monthly');
        $sitemap->add(route('guide'), Carbon::now(), '0.8', 'monthly');
        $sitemap->add(route('baoMat'), Carbon::now(), '0.8', 'monthly');
        $sitemap->add(route('hoatDong'), Carbon::now(), '0.8', 'monthly');
        $sitemap->add(route('tranhChap'), Carbon::now(), '0.8', 'monthly');
        $sitemap->add(route('about'), Carbon::now(), '0.8', 'monthly');
        // Product
        $productArray = $this->productRepo->paginate([
            'status' => config('product.status.active'),
        ], 400);
        // Main cate
        $cateList = config('product.category');
        foreach ($cateList as $cat) {
            $url = route('category', [
                'catSlug' => $cat['slug'],
            ]);
            $sitemap->add($url, Carbon::now(), '0.8', 'daily');
        }
        // Cate in english
        $cateList = config('product_en.category');
        foreach ($cateList as $cat) {
            $url = route('category', [
                'catSlug' => $cat['slug'],
            ]);
            $sitemap->add($url, Carbon::now(), '0.8', 'daily');
        }
        // Sub category
        $categories = $this->catRepo->paginate([], 500);
        foreach ($categories as $category) {
            /** @var $category App\Category */
            $url = route('subcat', [
                'catSlug' => $category->cat()['slug'],
                'slug' => $category->slug,
            ]);
            $sitemap->add($url, Carbon::now(), '0.8', 'daily');
        }
        // Class category
        $classCategories = $this->catRepo->getClassCategoryPagination([
            'type' => App\ClassCategory::TYPE_ADVISER,
        ], 1, 200);
        foreach ($classCategories as $classCategory) {
            /** @var  App\ClassCategory $classCategory */
            $url = route('class-category', [
                'slug' => str_slug($classCategory->name),
                'id' => $classCategory->id,
            ]);
            $sitemap->add($url, Carbon::now(), '0.8', 'daily');
        }

        if ($productArray && count($productArray)) {
            foreach ($productArray as $product) {
                /** @var $item App\Product */
                $url = route('product-detail', [
                    'catSlug' => $product->cat()['slug'],
                    'slug' => $product->subCat->slug,
                    'id' => $product->id,
                ]);
                $sitemap->add($url, Carbon::now(), '0.6', 'daily');
            }
        }
        // News
        $postList = $this->postRepo->paginate([
            'status' => config('post.status.active')
        ], 200);
        foreach ($postList as $post) {
            /** @var App\Post $post */
            $url = route('post-detail', [
                'slug' => $post->slug ? : str_slug($post->title),
                'id' => $post->id,
            ]);
            $sitemap->add($url, Carbon::now(), '0.6', 'daily');
        }
        return $sitemap->render('xml');
    }
}
