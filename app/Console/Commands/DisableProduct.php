<?php

namespace App\Console\Commands;


use App\Repositories\ProductRepository;
use Illuminate\Console\Command;

class DisableProduct extends Command
{
    protected $signature = 'product:disable';

    protected $description = 'Auto disable product when it is expired.';

    protected $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        parent::__construct();
        $this->productRepository = $productRepository;
    }

    public function handle()
    {
        $this->productRepository->disableExpiredProducts();
    }
}