<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use Carbon\Carbon;
use App\Repositories\CategoryRepository;

class GenerateSiteMap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate sitemap';

    protected $catRepo;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(CategoryRepository $catRepo)
    {
        parent::__construct();
        $this->catRepo = $catRepo;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $now = Carbon::now();
        $path = public_path('sitemap.xml');

        $subCatData = $this->catRepo->all();

        $sitemap = Sitemap::create();
        $sitemap->add(Url::create(route('home'))
            ->setLastModificationDate(Carbon::yesterday())
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_YEARLY)
            ->setPriority(0.1)
        );

        foreach (config('product.category') as $cat) {
            $url = route('category', ['catSlug' => $cat['slug']]);
            $sitemap->add(Url::create($url)
                ->setLastModificationDate(Carbon::yesterday())
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_YEARLY)
                ->setPriority(0.1)
            );

            $subCats = $subCatData->where('parent_id', $cat['id']);
            foreach ($subCats as $c) {
                $url = route('subcat', ['catSlug' => $cat['slug'], 'slug' => $c->slug]);
                $sitemap->add(Url::create($url)
                    ->setLastModificationDate(Carbon::yesterday())
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_YEARLY)
                    ->setPriority(0.1)
                );
            }
        }

        $sitemap->writeToFile($path);
    }
}
