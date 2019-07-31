<div class="row">
    <div class="col-md-6">
        <?php echo $__env->make('partials.box-search', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    </div>
    <div class="col-md-6">
        <div class="box-search-text">
            <form class="form-inline" action="<?php echo e(route('search')); ?>" method="GET">
                <img src="/imgs/icons/icon_search.png" class="icon-search">
                <input type="text" class="form-control" placeholder="<?php echo e(__('msg.enter_keyword')); ?>" name="s">
                <button type="submit" class="btn btn-primary"><?php echo e(__('msg.search')); ?></button>
            </form>
        </div>
        <?php echo $__env->make('partials.box-top-content', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    </div>
    <div class="col-12">
        <?php if(!empty($banners['banner_1'])): ?>
        <a href="<?php echo e($banners['banner_1']['url']); ?>" class="banner-box" target="_blank">
            <img src="<?php echo e($banners['banner_1']['image_url']); ?>" alt="">
        </a>
        <?php endif; ?>
    </div>
    <div class="col-md-6">
        <?php
            $cat = $productConfig['category'][0]
        ?>
        <div class="card card-primary">
            <div class="card-header"><h2><a href="<?php echo e(route('category', ['slug'=> $cat['slug']])); ?>"><?php echo e($cat['name']); ?></a></h2></div>
            <div class="card-body">
                <?php $__currentLoopData = $panoProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php $__env->startComponent('components.product_home', ['p' => $p, 'cat' => $cat, 'badge' => $cat['name']]); ?>
                    <?php echo $__env->renderComponent(); ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li class="page-item active"><a class="page-link" href="<?php echo e(route('category', ['slug'=> $cat['slug'], 'page' => 1])); ?>">1</a></li>
                <li class="page-item"><a class="page-link" href="<?php echo e(route('category', ['slug'=> $cat['slug'], 'page' => 2])); ?>">2</a></li>
                <li class="page-item"><a class="page-link" href="<?php echo e(route('category', ['slug'=> $cat['slug'], 'page' => 3])); ?>">3 ...</a></li>
            </ul>
        </nav>
    </div>
    <div class="col-md-6">
        <?php
        $cat = $productConfig['category'][1]
        ?>
        <div class="card card-primary">
            <div class="card-header"><h2><a href="<?php echo e(route('category', ['slug'=> $cat['slug']])); ?>"><?php echo e($cat['name']); ?></a></h2></div>
            <div class="card-body">
                <?php $__currentLoopData = $adProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php $__env->startComponent('components.product_home', ['p' => $p, 'cat' => $cat, 'badge' => $cat['name']]); ?>
                    <?php echo $__env->renderComponent(); ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li class="page-item active"><a class="page-link" href="<?php echo e(route('category', ['slug'=> $cat['slug'], 'page' => 1])); ?>">1</a></li>
                <li class="page-item"><a class="page-link" href="<?php echo e(route('category', ['slug'=> $cat['slug'], 'page' => 2])); ?>">2</a></li>
                <li class="page-item"><a class="page-link" href="<?php echo e(route('category', ['slug'=> $cat['slug'], 'page' => 3])); ?>">3 ...</a></li>
            </ul>
        </nav>
    </div>
    <div class="col-12">
        <?php if(!empty($banners['banner_2'])): ?>
        <a href="<?php echo e($banners['banner_2']['url']); ?>" class="banner-box" target="_blank">
            <img src="<?php echo e($banners['banner_2']['image_url']); ?>" alt="">
        </a>
        <?php endif; ?>
    </div>
    <div class="col-md-6">
        <?php
            $cat = $productConfig['category'][2]
        ?>
        <div class="card card-primary">
            <div class="card-header"><h2><a href="<?php echo e(route('category', ['slug'=> $cat['slug']])); ?>"><?php echo e($cat['name']); ?></a></h2></div>
            <div class="card-body">
                <?php $__currentLoopData = $socialProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php $__env->startComponent('components.product_home', ['p' => $p, 'cat' => $cat, 'badge' => $cat['name']]); ?>
                    <?php echo $__env->renderComponent(); ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li class="page-item active"><a class="page-link" href="<?php echo e(route('category', ['slug'=> $cat['slug'], 'page' => 1])); ?>">1</a></li>
                <li class="page-item"><a class="page-link" href="<?php echo e(route('category', ['slug'=> $cat['slug'], 'page' => 2])); ?>">2</a></li>
                <li class="page-item"><a class="page-link" href="<?php echo e(route('category', ['slug'=> $cat['slug'], 'page' => 3])); ?>">3 ...</a></li>
            </ul>
        </nav>
    </div>
    <div class="col-md-6">
        <div class="card card-primary">
            <div class="card-header"><h2><a href="<?php echo e(route('phan-tich')); ?>"><?php echo e(__('msg.news_phan_tich')); ?></a></h2></div>
            <div class="card-body p-0">
                <ul class="link-list pb-0 mb-0">
                    <?php $__currentLoopData = $phanTich; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><h3><a href="<?php echo e($p->getPostURL()); ?>"><?php echo e(str_limit($p->title, 60)); ?></a></h3></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <li><a href="<?php echo e(route('phan-tich')); ?>"><?php echo e(__('msg.view_more')); ?>...</a></li>
                </ul>
            </div>
        </div>
        <div class="card card-primary">
            <div class="card-header"><h2><a href="<?php echo e(route('su-kien')); ?>"><?php echo e(__('msg.news_su_kien')); ?></a></h2></div>
            <div class="card-body p-0">
                <ul class="link-list  pb-0 mb-0">
                    <?php $__currentLoopData = $suKien; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><h3><a href="<?php echo e($p->getPostURL()); ?>"><?php echo e(str_limit($p->title, 60)); ?></a></h3></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <li><a href="<?php echo e(route('su-kien')); ?>"><?php echo e(__('msg.view_more')); ?>...</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-12">
        <?php if(!empty($banners['banner_3'])): ?>
        <a href="<?php echo e($banners['banner_3']['url']); ?>" class="banner-box" target="_blank">
            <img src="<?php echo e($banners['banner_3']['image_url']); ?>" alt="">
        </a>
        <?php endif; ?>
    </div>
    <div class="col-md-6">
        <?php
            $cat = $productConfig['category'][3]
        ?>
        <div class="card card-primary">
            <div class="card-header"><h2><a href="<?php echo e(route('category', ['slug'=> $cat['slug']])); ?>"><?php echo e($cat['name']); ?></a></h2></div>
            <div class="card-body">
                <?php $__currentLoopData = $webProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php $__env->startComponent('components.product_home', ['p' => $p, 'cat' => $cat, 'badge' => $cat['name']]); ?>
                    <?php echo $__env->renderComponent(); ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li class="page-item active"><a class="page-link" href="<?php echo e(route('category', ['slug'=> $cat['slug'], 'page' => 1])); ?>">1</a></li>
                <li class="page-item"><a class="page-link" href="<?php echo e(route('category', ['slug'=> $cat['slug'], 'page' => 2])); ?>">2</a></li>
                <li class="page-item"><a class="page-link" href="<?php echo e(route('category', ['slug'=> $cat['slug'], 'page' => 3])); ?>">3</a></li>
                
                
            </ul>
        </nav>
    </div>
    <div class="col-md-6">
        <div class="card card-primary">
            <div class="card-header"><h2><a href="<?php echo e(route('kinh-nghiem')); ?>"><?php echo e(__('msg.news_chia_se')); ?></a></h2></div>
            <div class="card-body p-0">
                <ul class="link-list  pb-0 mb-0">
                    <?php $__currentLoopData = $kinhNghiem; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><h3><a href="<?php echo e($p->getPostURL()); ?>"><?php echo e(str_limit($p->title, 60)); ?></a></h3></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <li><a href="<?php echo e(route('kinh-nghiem')); ?>"><?php echo e(__('msg.view_more')); ?>...</a></li>
                </ul>
            </div>
        </div>
        <div class="card card-primary">
            <div class="card-header"><h2><a href="<?php echo e(route('thuong-hieu')); ?>"><?php echo e(__('msg.news_thuong_hieu')); ?></a></h2></div>
            <div class="card-body p-0">
                <ul class="link-list  pb-0 mb-0">
                    <?php $__currentLoopData = $thuongHieu; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><h3><a href="<?php echo e($p->getPostURL()); ?>"><?php echo e(str_limit($p->title, 60)); ?></a></h3></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <li><a href="<?php echo e(route('thuong-hieu')); ?>"><?php echo e(__('msg.view_more')); ?>...</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-12">
        <?php if(!empty($banners['banner_4'])): ?>
        <a href="<?php echo e($banners['banner_4']['url']); ?>" class="banner-box" target="_blank">
            <img src="<?php echo e($banners['banner_4']['image_url']); ?>" alt="">
        </a>
        <?php endif; ?>
    </div>
    <div class="col-md-6">
        <?php
            $cat = $productConfig['category'][4]
        ?>
        <div class="card card-primary">
            <div class="card-header"><h2><a href="<?php echo e(route('category', ['slug'=> $cat['slug']])); ?>"><?php echo e($cat['name']); ?></a></h2></div>
            <div class="card-body">
                <?php $__currentLoopData = $otherProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php $__env->startComponent('components.product_home', ['p' => $p, 'cat' => $cat, 'badge' => $cat['name']]); ?>
                    <?php echo $__env->renderComponent(); ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li class="page-item active"><a class="page-link" href="<?php echo e(route('category', ['slug'=> $cat['slug'], 'page' => 1])); ?>">1</a></li>
                <li class="page-item"><a class="page-link" href="<?php echo e(route('category', ['slug'=> $cat['slug'], 'page' => 2])); ?>">2</a></li>
                <li class="page-item"><a class="page-link" href="<?php echo e(route('category', ['slug'=> $cat['slug'], 'page' => 3])); ?>">3 ...</a></li>
            </ul>
        </nav>
    </div>
    <div class="col-md-6">
        <?php
            $cat = $productConfig['category'][5]
        ?>
        <div class="card card-primary">
            <div class="card-header"><h2><a href="<?php echo e(route('category', ['slug'=> $cat['slug']])); ?>"><?php echo e($cat['name']); ?></a></h2></div>
            <div class="card-body">
                <?php $__currentLoopData = $findProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php $__env->startComponent('components.product_home', ['p' => $p, 'cat' => $cat, 'badge' => $cat['name']]); ?>
                    <?php echo $__env->renderComponent(); ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li class="page-item active"><a class="page-link" href="<?php echo e(route('category', ['slug'=> $cat['slug'], 'page' => 1])); ?>">1</a></li>
                <li class="page-item"><a class="page-link" href="<?php echo e(route('category', ['slug'=> $cat['slug'], 'page' => 2])); ?>">2</a></li>
                <li class="page-item"><a class="page-link" href="<?php echo e(route('category', ['slug'=> $cat['slug'], 'page' => 3])); ?>">3 ...</a></li>
            </ul>
        </nav>
    </div>
</div>