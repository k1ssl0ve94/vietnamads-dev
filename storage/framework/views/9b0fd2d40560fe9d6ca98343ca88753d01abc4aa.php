<header>
    <div id="topbar">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <ul class="social-links">
                        <li class="separator"></li>
                        <li><a href="https://www.facebook.com/Vietnamadsvn-322884915019527/" target="_blank"><i class="fa fa-facebook-official" aria-hidden="true"></i></a></li>
                        <li><a href="https://twitter.com/vietnamadsvn" target="_blank"><i class="fa fa-twitter-square" aria-hidden="true"></i></a></li>
                        <li><a href="https://www.youtube.com/channel/UCvL6h2DavCAzBNqQfrEB6dw" target="_blank"><i class="fa fa-youtube-play" aria-hidden="true"></i></a></li>
                        <li class="separator"></li>
                        <li><a href="#subscribe-bar" class="show-modal-subscribe"><?php echo e(__('msg.subscribe_newsletter')); ?></a></li>
                    </ul>
                </div>
                <div class="col-md-9 text-right">
                    <ul>
                        <li><a href="/gioi-thieu"><?php echo e(__('msg.about')); ?></a></li>
                        <li><a href="/huong-dan/dang-ky-tai-khoan-thanh-vien"><?php echo e(__('msg.guide')); ?></a></li>
                        <li><a href="/bao-gia"><?php echo e(__('msg.pricing')); ?></a></li>
                        <li><a href="<?php echo e(route('contact')); ?>"><?php echo e(__('msg.contact')); ?></a></li>
                        <li><a href="tel:02439992996"><i class="fa fa-phone-square" aria-hidden="true"></i> <?php echo e(__('msg.tel_bussiness')); ?></a></li>
                        <li><a href="tel:02439992997"><i class="fa fa-phone-square" aria-hidden="true"></i> <?php echo e(__('msg.tel_vip')); ?></a></li>
                        
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div id="header-content">
        <div class="container">
            <div class="row">
                <div class="col-4 col-md-2">
                    <?php if(request()->route()->getName() == 'home'): ?>
                    <h1>
                    <?php endif; ?>                        
                        <a href="<?php echo e(route('home')); ?>" class="logo" alt="vietnamads.vn">
                            <img src="/imgs/logo.png" alt="kênh thông tin dịch vụ quảng cáo số 1">
                        </a>
                    <?php if(request()->route()->getName() == 'home'): ?>
                    </h1>                
                    <?php endif; ?>   
                </div>
                <div class="d-none col-md-5 col-lg-7  d-sm-block">
                    <?php if(!empty($banners['banner_top'])): ?>
                    <a href="<?php echo e($banners['banner_top']['url']); ?>" class="banner-img">
                        <img src="<?php echo e($banners['banner_top']['image_url']); ?>" alt="logo">
                    </a>
                    <?php endif; ?>
                </div>
                <div class="col-8 col-md-5 col-lg-3 text-right user-profile-block">
                    <?php if(auth()->check()): ?>
                        <?php
                            $user = auth()->user();
                            $isActivated = !!$user->activated;
                        ?>
                        <div class="mb-1">
                            <a class="" href="<?php echo e(route('message-box')); ?>"
                               aria-label="Bạn có <?php echo e(number_format($user->unread_message)); ?> tin mới">
                                <?php if($user->unread_message): ?>
                                    <span class="badge badge-danger">
                                        <i class="fa fa-envelope" aria-hidden="true"
                                           title="Bạn có <?php echo e(number_format($user->unread_message)); ?> tin mới"></i></span>
                                <?php else: ?>
                                    <span class="badge badge-info"><i class="fa fa-envelope"
                                       aria-hidden="true"></i></span>
                                <?php endif; ?>
                            </a>
                            <a href="<?php echo e(route('profile')); ?>"><?php echo e($user->name); ?>

                                <span class="wrap-avatar">
                                    <img class="user-avatar avatar-blue img-circle" src="<?php echo e($user->getAvatarUrl()); ?>">
                                    <?php if($user->type == \App\User::TYPE_AGENCY): ?>
                                        <span class="badge badge-primary badge-avatar">Agency</span>
                                    <?php elseif($user->type == \App\User::TYPE_NORMAL): ?>
                                        <?php if($user->level == \App\User::LEVEL_VIP): ?>
                                            <span class="badge badge-danger badge-avatar">VIP</span>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </span>
                            </a>
                            <a href="<?php echo e(route('logout')); ?>" class="fa fa-sign-out" title="Đăng xuất"></a>
                            <br>
                            <span class="badge badge-success" title="Tiền khả dụng"><?php echo e(number_format($user->remain_point)); ?> vnđ</span>
                            <span class="badge badge-primary" title="Tiền khuyến mại">KM: <?php echo e(number_format($user->promotion_point)); ?> vnđ</span>
                        </div>
                        <?php if($isActivated): ?>
                        <a class="btn btn-primary btn-sm fa fa-plus-circle" data-toggle="modal" href="#" style="display: inline-flex;"
                                <?php if($user->isVerifiedPhone()): ?>
                                data-target="#modal-ask-post-type"
                                <?php else: ?>
                                data-target="#modal-verify-phone"
                                <?php endif; ?>
                        > &nbsp;Đăng tin rao</a>
                        <a href="<?php echo e(route('pointGuide')); ?>" class="btn btn-warning btn-sm
                                fa fa-plus-circle"> Nạp tiền</a>
                        <?php else: ?>
                        <div>Bạn chưa kích hoạt tài khoản</div>
                        <?php endif; ?>
                    <?php else: ?>
                        <p><button class="btn btn-primary" data-toggle="modal" data-target="#modal-login"><?php echo e(__('msg.login')); ?></button></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark" id="main-menu" data-toggle="sticky-onscroll">
        <div class="container">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link home-link" href="<?php echo e(route('home')); ?>"><i class="fa fa-home" aria-hidden="true"></i></a>
                    </li>
                    <?php
                        $cat = $productConfig['category'][0];
                        $catSlug = $cat['slug'];
                    ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link" href="<?php echo e(route('category', ['slug'=> $catSlug])); ?>" id="navbarDropdown1" role="button" aria-haspopup="true" aria-expanded="false">
                            <?php echo e($cat['name']); ?>

                            <i class="fa fa-chevron-circle-down" aria-hidden="true"></i>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown1">
                            <div class="row">
                                <div class="col-sm-5 sub-info">
                                    <img src="/imgs/menu/img_menu1.png" alt="">
                                    <h5><?php echo e($cat['name']); ?></h5>
                                    <div><?php echo e($cat['description']); ?></div>
                                </div>
                                <div class="col-sm-7 sub-menu">
                                    <h4><?php echo e(__('msg.category')); ?> <?php echo e($cat['name']); ?></h4>
                                    <?php $__currentLoopData = $catData[1]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <a class="dropdown-item" href="<?php echo e(route('subcat', ['catSlug'=> $catSlug, 'slug' => $c['slug']])); ?>">
                                        <?php echo e($c['name']); ?>

                                    </a>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                        </div>
                    </li>
                    <?php
                        $cat = $productConfig['category'][1];
                        $catSlug = $cat['slug'];
                    ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link" href="<?php echo e(route('category', ['slug'=> $catSlug])); ?>" id="navbarDropdown2" role="button" aria-haspopup="true" aria-expanded="false">
                            <?php echo e($cat['name']); ?>

                            <i class="fa fa-chevron-circle-down" aria-hidden="true"></i>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown2">
                            <div class="row">
                                <div class="col-sm-5 sub-info">
                                    <img src="/imgs/menu/img_menu2.png" alt="">
                                    <h5><?php echo e($cat['name']); ?></h5>
                                    <div><?php echo e($cat['description']); ?></div>
                                </div>
                                <div class="col-sm-7 sub-menu">
                                    <h4><?php echo e(__('msg.category')); ?> <?php echo e($cat['name']); ?></h4>
                                    <?php $__currentLoopData = $catData[2]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <a class="dropdown-item" href="<?php echo e(route('subcat', ['catSlug'=> $catSlug, 'slug' => $c['slug']])); ?>">
                                        <?php echo e($c['name']); ?>

                                    </a>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                        </div>
                    </li>
                    <?php
                        $cat = $productConfig['category'][2];
                        $catSlug = $cat['slug'];
                    ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link" href="<?php echo e(route('category', ['slug'=> $catSlug])); ?>" id="navbarDropdown3" role="button" aria-haspopup="true" aria-expanded="false">
                            <?php echo e($cat['name']); ?>

                            <i class="fa fa-chevron-circle-down" aria-hidden="true"></i>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown3">
                            <div class="row">
                                <div class="col-sm-5 sub-info">
                                    <img src="/imgs/menu/img_menu3.png" alt="">
                                    <h5><?php echo e($cat['name']); ?></h5>
                                    <div><?php echo e($cat['description']); ?></div>
                                </div>
                                <div class="col-sm-7 sub-menu">
                                    <h4><?php echo e(__('msg.category')); ?> <?php echo e($cat['name']); ?></h4>
                                    <?php $__currentLoopData = $catData[3]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <a class="dropdown-item" href="<?php echo e(route('subcat', ['catSlug'=> $catSlug, 'slug' => $c['slug']])); ?>">
                                        <?php echo e($c['name']); ?>

                                    </a>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                        </div>
                    </li>
                    <?php
                        $cat = $productConfig['category'][3];
                        $catSlug = $cat['slug'];
                    ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link" href="<?php echo e(route('category', ['slug'=> $catSlug])); ?>" id="navbarDropdown5" role="button" aria-haspopup="true" aria-expanded="false">
                            <?php echo e($cat['name']); ?>

                            <i class="fa fa-chevron-circle-down" aria-hidden="true"></i>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown5">
                            <div class="row">
                                <div class="col-sm-5 sub-info">
                                    <img src="/imgs/menu/img_menu4.png" alt="">
                                    <h5><?php echo e($cat['name']); ?></h5>
                                    <div><?php echo e($cat['description']); ?></div>
                                </div>
                                <div class="col-sm-7 sub-menu">
                                    <h4><?php echo e(__('msg.category')); ?> <?php echo e($cat['name']); ?></h4>
                                    <?php $__currentLoopData = $catData[4]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <a class="dropdown-item" href="<?php echo e(route('subcat', ['catSlug'=> $catSlug, 'slug' => $c['slug']])); ?>">
                                        <?php echo e($c['name']); ?>

                                    </a>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                        </div>
                    </li>
                    <?php
                        $cat = $productConfig['category'][4];
                        $catSlug = $cat['slug'];
                    ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link" href="<?php echo e(route('category', ['slug'=> $catSlug])); ?>" id="navbarDropdown5" role="button" aria-haspopup="true" aria-expanded="false">
                            <?php echo e($cat['name']); ?>

                            <i class="fa fa-chevron-circle-down" aria-hidden="true"></i>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown5">
                            <div class="row">
                                <div class="col-sm-5 sub-info">
                                    <img src="/imgs/menu/img_menu5.png" alt="">
                                    <h5><?php echo e($cat['name']); ?></h5>
                                    <div><?php echo e($cat['description']); ?></div>
                                </div>
                                <div class="col-sm-7 sub-menu">
                                    <h4><?php echo e(__('msg.category')); ?> <?php echo e($cat['name']); ?></h4>
                                    <?php $__currentLoopData = $catData[5]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <a class="dropdown-item" href="<?php echo e(route('subcat', ['catSlug'=> $catSlug, 'slug' => $c['slug']])); ?>">
                                        <?php echo e($c['name']); ?>

                                    </a>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                        </div>
                    </li>
                    <?php
                        $cat = $productConfig['category'][5];
                        $catSlug = $cat['slug'];
                    ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link" href="<?php echo e(route('category', ['slug'=> $catSlug])); ?>" id="navbarDropdown5" role="button" aria-haspopup="true" aria-expanded="false">
                            <?php echo e($cat['name']); ?>

                            <i class="fa fa-chevron-circle-down" aria-hidden="true"></i>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown5">
                            <div class="row">
                                <div class="col-sm-5 sub-info">
                                    <img src="/imgs/menu/img_menu6.png" alt="">
                                    <h5><?php echo e($cat['name']); ?></h5>
                                    <div><?php echo e($cat['description']); ?></div>
                                </div>
                                <div class="col-sm-7 sub-menu">
                                    <h4><?php echo e(__('msg.category')); ?> <?php echo e($cat['name']); ?></h4>
                                    <?php $__currentLoopData = $catData[6]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <a class="dropdown-item" href="<?php echo e(route('subcat', ['catSlug'=> $catSlug, 'slug' => $c['slug']])); ?>">
                                        <?php echo e($c['name']); ?>

                                    </a>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link" href="<?php echo e(route('news')); ?>" id="navbarDropdown6" role="button" aria-haspopup="true" aria-expanded="false">
                            <?php echo e(__('msg.news')); ?>

                            <i class="fa fa-chevron-circle-down" aria-hidden="true"></i>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown6">
                            <div class="row">
                                <div class="col-sm-5 sub-info">
                                    <img src="/imgs/menu/img_menu6.png" alt="">
                                    <h5><?php echo e(__('msg.news')); ?></h5>
                                    <div></div>
                                </div>
                                <div class="col-sm-7 sub-menu">
                                    <h4><?php echo e(__('msg.news')); ?></h4>
                                    <a class="dropdown-item" href="<?php echo e(route('phan-tich')); ?>"><?php echo e(__('msg.news_phan_tich')); ?></a>
                                    <a class="dropdown-item" href="<?php echo e(route('su-kien')); ?>"><?php echo e(__('msg.news_su_kien')); ?></a>
                                    <a class="dropdown-item" href="<?php echo e(route('kinh-nghiem')); ?>"><?php echo e(__('msg.news_chia_se')); ?></a>
                                    <a class="dropdown-item" href="<?php echo e(route('thuong-hieu')); ?>"><?php echo e(__('msg.news_thuong_hieu')); ?></a>
                                    <a class="dropdown-item" href="<?php echo e(route('chinh-sach')); ?>"><?php echo e(__('msg.news_chinh_sach')); ?></a>
                                    <a class="dropdown-item" href="<?php echo e(route('thong-bao')); ?>"><?php echo e(__('msg.news_thong_bao')); ?></a>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>