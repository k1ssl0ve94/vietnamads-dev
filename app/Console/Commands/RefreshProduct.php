<?php

namespace App\Console\Commands;


use App\Product;
use App\Repositories\ProductRepository;
use App\Repositories\SettingRepository;
use App\Repositories\UserRepository;
use Illuminate\Console\Command;

class RefreshProduct extends Command
{
    protected $signature = 'product:auto_refresh {page?}';

    protected $description = 'Auto refresh product';

    protected $productRepository;
    protected $userRepository;
    protected $settingRepository;

    public function __construct(ProductRepository $productRepository,
            UserRepository $userRepository,
            SettingRepository $settingRepository)
    {
        parent::__construct();
        $this->productRepository = $productRepository;
        $this->userRepository = $userRepository;
        $this->settingRepository = $settingRepository;
    }

    public function handle()
    {
        $page = $this->argument('page');
        $page = $page ? : 1;
//        $refreshTimeSetting = $this->settingRepository->getByKeyAndGroup('refresh_time', 'all');
        $refreshTime = 8 ; //$refreshTimeSetting ? $refreshTimeSetting->value : 8;
        $items = $this->productRepository->getRefreshableList($page, $refreshTime);

        if ($items){
            $userArray = [];
            foreach ($items as $item) {
                /** @var $item Product */
                if (!isset($userArray[$item->user_id])) {
                    $user = $this->userRepository->findFrontEndUserById($item->user_id);
                } else {
                    $user = $userArray[$item->user_id];
                }
                if ($user) {
                    $userArray[$user->id] = $user;
                    //
                    if ($item->canAutoRefresh($user, true, $refreshTime)) {
                        $this->productRepository->refresh($item, $user, true);
                    }
                }
            }

            if($items->hasMorePages()){
                $this->call('product:auto_refresh', [
                   'page' => $page + 1,
                ]);
            }
        }
    }

}