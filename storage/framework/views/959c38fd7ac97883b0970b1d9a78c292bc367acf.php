<?php
    $description = $product->title.', '.$product->content;    
?>  
<?php $__env->startSection('title'); ?>
    <title><?php echo e($product->title); ?> | VietnamAds</title>  
    <meta property="og:title" content="<?php echo e($product->title); ?>" />
    <meta property="og:type" content="product" />
    <meta property="og:url" content="<?php echo e(\Illuminate\Support\Facades\Request::url()); ?>" />
    <meta property="og:image" content="<?php echo e($product->thumb_url); ?>" />
    <meta property="og:site_name" content="VietnamAds | Kênh thông tin quảng cáo và marketing của Việt Nam" />
    <meta property="og:description" content="<?php echo e(str_limit($description,149)); ?>" />
    <meta property="og:image:secure_url" content="<?php echo e($product->thumb_url); ?>" />
    <meta name="twitter:card" content="summary" />
    <meta name="twitter:title" content="<?php echo e($product->title); ?>" />
    <meta name="twitter:description" content="<?php echo e(str_limit($description,149)); ?>" />
    <meta name="twitter:image" content="<?php echo e($product->thumb_url); ?>" />    
<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <?php echo e(Breadcrumbs::render('product_detail', $product)); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('meta-tags'); ?>  
    <meta name="description" content="<?php echo e(str_limit($description,149)); ?>">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('main'); ?>

<div class="row product-detail">
    <div class="col-12">
        <div class="box-search-text">
            <form class="form-inline form-search" method="GET" action="<?php echo e(route('search')); ?>">
                <img src="/imgs/icons/icon_search.png" class="icon-search">
                <input type="text" class="form-control" placeholder="<?php echo e(__('msg.enter_keyword')); ?>" name="s">
                <button type="submit" class="btn btn-primary"><?php echo e(__('msg.search')); ?></button>
            </form>
        </div>
    </div>
    <div class="col-12">
        <div class="card card-post">
            <?php                
                $c = \App\Lib\Location::getCity($product->city);
                $d = \App\Lib\Location::getDistrict($product->district);
                $header_slug = $product->cat()['slug'].'/'.$product->subCat->slug.'/'.str_slug($c['name']).'/'.str_slug($d['name']);                
                $header = $product->cat()['name'];
                $header .=  strtolower(' ' . $product->subCat->name);
                $header .= ' tại '.$d['name'].', '. $product->cityText();
                $header = trim($header);
            ?>
            <div class="card-header"><h1 class="text-left"><?php echo e($product->title); ?></h1></div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <div class="product-cat">
                            <span>Khu vực:</span>
                            <h2><a href="/<?php echo e($header_slug); ?>"><?php echo e($header); ?></a></h2>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="img-thumb">
                            <img src="<?php echo e($product->thumbImage()); ?>" class="img-fluid rounded">
                        </div>
                    </div>
                    <?php if($product->category_parent == 1): ?>
                    <div class="col-md-4">
                        <ul class="meta">
                            <li style="color: <?php echo e($product->price_color); ?>;"><img src="/imgs/icons/ic_giatien.svg" class="meta-icon"> <?php echo e($product->priceText()); ?></li>
                            <li style="color: <?php echo e($product->parameter_color); ?>;"><img src="/imgs/icons/ic_diachi.svg" class="meta-icon"> <?php echo e($product->locationText()); ?></li>
                            <li style="color: <?php echo e($product->parameter_color); ?>;"><img src="/imgs/icons/ic_hinhthuc.svg" class="meta-icon"> <?php echo e($product->getTextAttr('pano_type')); ?></li>
                            <?php if($product->user && $product->user->verified_by_admin): ?>
                                <li><span class="badge-success badge">Đã xác minh người đăng</span></li>
                            <?php endif; ?>
                        </ul>
                    </div>
                    <div class="col-md-4">
                        <ul class="meta">
                            <li style="color: <?php echo e($product->parameter_color); ?>;"><img src="/imgs/icons/ic_date.svg" class="meta-icon"> <?php echo e($product->created_at->format('d/m/Y')); ?></li>
                            <li style="color: <?php echo e($product->parameter_color); ?>;"><img src="/imgs/icons/ic_ten.svg" class="meta-icon"> <?php echo e($product->subCat->name); ?></li>
                            <li style="color: <?php echo e($product->parameter_color); ?>;"><img src="/imgs/icons/ic_hinhthuc.svg" class="meta-icon"> <?php echo e($product->getTextAttr('pano_size')); ?></li>
                        </ul>
                    </div>
                    <?php endif; ?>
                    <?php if($product->category_parent == 2 || $product->category_parent == 3 || $product->category_parent == 4): ?>
                    <div class="col-md-4">
                        <ul class="meta">
                            <li style="color: <?php echo e($product->price_color); ?>;"><img src="/imgs/icons/ic_giatien.svg" class="meta-icon"> <?php echo e($product->priceText()); ?></li>
                            <li style="color: <?php echo e($product->parameter_color); ?>;"><img src="/imgs/icons/ic_diachi.svg" class="meta-icon"> <?php echo e($product->locationText()); ?></li>
                            <li style="color: <?php echo e($product->parameter_color); ?>;"><img src="/imgs/icons/ic_hinhthuc.svg" class="meta-icon"> <?php echo e($product->link); ?></li>
                            <?php if($product->user && $product->user->verified_by_admin): ?>
                                <li><span class="badge-success badge">Đã xác minh người đăng</span></li>
                            <?php endif; ?>
                        </ul>
                    </div>
                    <div class="col-md-4">
                        <ul class="meta">
                            <li style="color: <?php echo e($product->parameter_color); ?>;"><img src="/imgs/icons/ic_date.svg" class="meta-icon"> <?php echo e($product->created_at->format('d/m/Y')); ?></li>
                            <li style="color: <?php echo e($product->parameter_color); ?>;"><img src="/imgs/icons/ic_hinhthuc.svg" class="meta-icon"> <?php echo e($product->subCat->name); ?></li>
                        </ul>
                    </div>
                    <?php endif; ?>
                    <?php if($product->category_parent == 5 || $product->category_parent == 6): ?>
                    <div class="col-md-4">
                        <ul class="meta">
                            <li style="color: <?php echo e($product->price_color); ?>;"><img src="/imgs/icons/ic_giatien.svg" class="meta-icon"> <?php echo e($product->priceText()); ?></li>
                            <li style="color: <?php echo e($product->parameter_color); ?>;"><img src="/imgs/icons/ic_diachi.svg" class="meta-icon"> <?php echo e($product->locationText()); ?></li>
                            <?php if($product->user && $product->user->verified_by_admin): ?>
                                <li><span class="badge-success badge">Đã xác minh người đăng</span></li>
                            <?php endif; ?>
                        </ul>
                    </div>
                    <div class="col-md-4">
                        <ul class="meta">
                            <li style="color: <?php echo e($product->parameter_color); ?>;"><img src="/imgs/icons/ic_date.svg" class="meta-icon"> <?php echo e($product->created_at->format('d/m/Y')); ?></li>
                            <li style="color: <?php echo e($product->parameter_color); ?>;"><img src="/imgs/icons/ic_hinhthuc.svg" class="meta-icon"> <?php echo e($product->subCat->name); ?></li>
                        </ul>
                    </div>
                    <?php endif; ?>

                </div>
                <div class="content">
                    <?php if($product->tags && count($product->tags) > 0): ?>
                    <p>Từ khóa tìm kiếm:
                        <?php $__currentLoopData = $product->tags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <a href="<?php echo e(route('tag', ['slug' => str_slug($tag->name), 'id' => $tag->id])); ?>"><?php echo e($tag->name); ?></a><?php if($index < count($product->tags) - 1): ?> , <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </p>
                    <?php endif; ?>
                    <?php echo nl2br($product->content); ?>


                </div>           
                <?php if($product->direct_link): ?>                    
                    <div class="content">
                        <label>Links: </label><br/>
                        <?php $__currentLoopData = $product->direct_link; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $link): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($link): ?>
                                <p class="">
                                    <?php if($product->allow_direct_link): ?>
                                    <a href="<?php echo e($link); ?>" rel="nofollow" target="_blank">
                                       <i class="fa fa-angle-double-right"></i> <?php echo e($link); ?>

                                    </a>
                                    <?php else: ?>
                                        <i class="fa fa-angle-double-right"></i> <?php echo e($link); ?>

                                    <?php endif; ?>
                                </p>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php endif; ?>
                <?php if($product->youtube_link): ?>
                    <div class="row text-center youtube-link">
                        <div style="margin: auto">
                            <?php echo Youtube::iFrame($product->youtube_link);; ?>

                        </div>
                    </div>
                <?php endif; ?>
                <div class="mb-3 share">
                    <div class="addthis_inline_share_toolbox_t3om"></div>
                </div>                  
                <?php if(count($product->getImageURLs()) > 0): ?>
                <div class="product-image">
                    <br/>
                    <h6><?php echo e(__('msg.product_images')); ?></h6>
                    <div class="slider slider-for">
                        <?php $__currentLoopData = $product->getImageURLs(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="product-img-box">
                            <img src="<?php echo e($img); ?>" class="rounded">
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <div class="slider slider-nav">
                        <?php $__currentLoopData = $product->getThumbURLs(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="product-thumb-box">
                            <img src="<?php echo e($img); ?>" class="rounded">
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
                <?php endif; ?>   
            </div>
        </div>
    </div>
    <?php if($product->hasPosition()): ?>
    <div class="col-12">
        <div class="card card-muted">
            <div class="card-header"><h2><?php echo e(__('msg.view_on_map')); ?></h2></div>
            <div class="card-body">
                <div id="map-detail-product" v-cloak data-lat="<?php echo e($product->lat); ?>" data-lng="<?php echo e($product->long); ?>">
                    <gmap-map
                        :center="position"
                        :zoom="14"
                        map-type-id="roadmap"
                        style="width: 100%; height: 440px"
                    >
                        <gmap-marker :position="position" />
                    </gmap-map>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
    <div class="col-md-6">
        <div class="card card-muted">
            <div class="card-header"><h2><?php echo e(__('msg.base_info')); ?></h2></div>
            <div class="card-body">
                <table class="table table-striped">
                    <tbody>
                        <tr>
                            <th scope="row"><?php echo e(__('msg.product_category')); ?>:</th>
                            <td class="text-right"><?php echo e($product->cat()['name']); ?></td>
                        </tr>
                        <tr>
                            <th scope="row"><?php echo e(__('msg.product_sub_cat')); ?>:</th>
                            <td class="text-right"><?php echo e($product->subCat->name); ?></td>
                        </tr>
                        <tr>
                            <th scope="row">Địa chỉ:</th>
                            <td class="text-right"><?php echo e($product->fullLocationText()); ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card card-muted">
            <div class="card-header"><h2><?php echo e(__('msg.misc')); ?></h2></div>
            <div class="card-body">
                <?php if($product->category_parent == 1): ?>
                <table class="table table-striped">
                    <tbody>
                        <tr>
                            <th scope="row"><?php echo e(__('msg.product_provider')); ?>:</th>
                            <td class="text-right"><?php echo e($product->provider_text); ?></td>
                        </tr>
                        <tr>
                            <th scope="row"><?php echo e(__('msg.frame')); ?>:</th>
                            <td class="text-right"><?php echo e($product->getTextAttr('pano_border')); ?></td>
                        </tr>
                        <tr>
                            <th scope="row"><?php echo e(__('msg.light')); ?>:</th>
                            <td class="text-right"><?php echo e($product->getTextAttr('pano_light')); ?></td>
                        </tr>
                    </tbody>
                </table>
                <?php endif; ?>
                <?php if($product->category_parent == 2): ?>
                <table class="table table-striped">
                    <tbody>
                        <tr>
                            <th scope="row"><?php echo e(__('msg.product_provider')); ?>:</th>
                            <td class="text-right"><?php echo e($product->provider_text); ?></td>
                        </tr>
                        
                            
                            
                        
                        
                            
                            
                        
                        
                            
                            
                        
                    </tbody>
                </table>
                <?php endif; ?>
                <?php if($product->category_parent == 3): ?>
                <table class="table table-striped">
                    <tbody>
                        <tr>
                            <th scope="row"><?php echo e(__('msg.product_provider')); ?>:</th>
                            <td class="text-right"><?php echo e($product->provider_text); ?></td>
                        </tr>
                        
                            
                            
                        
                        
                            
                            
                        
                    </tbody>
                </table>
                <?php endif; ?>
                <?php if($product->category_parent == 4): ?>
                <table class="table table-striped">
                    <tbody>
                        <tr>
                            <th scope="row"><?php echo e(__('msg.product_provider')); ?>:</th>
                            <td class="text-right"><?php echo e($product->provider_text); ?></td>
                        </tr>
                        <tr>
                            <th scope="row"><?php echo e(__('msg.page_type')); ?>:</th>
                            <td class="text-right"><?php echo e($product->getTextAttr('web_type')); ?></td>
                        </tr>
                        <tr>
                            <th scope="row"><?php echo e(__('msg.page_type')); ?>:</th>
                            <td class="text-right"><?php echo e($product->getTextAttr('web_position')); ?></td>
                        </tr>
                    </tbody>
                </table>
                <?php endif; ?>
                <?php if($product->category_parent == 5 || $product->category_parent == 6): ?>
                <table class="table table-striped">
                    <tbody>
                        <tr>
                            <th scope="row"><?php echo e(__('msg.product_provider')); ?>:</th>
                            <td class="text-right"><?php echo e($product->provider_text); ?></td>
                        </tr>
                    </tbody>
                </table>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card card-muted contact-box">
            <div class="card-header"><h2><?php echo e(__('msg.contact')); ?></h2></div>
            <div class="card-body">
                <table class="table table-striped">
                    <tbody>
                        <tr>
                            <th scope="row"><?php echo e(__('msg.fullname')); ?>:</th>
                            <td class="text-right">
                                <?php echo e($product->contact_name); ?>

                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><?php echo e(__('msg.phone_number')); ?>:</th>
                            <td class="text-right"><?php echo e($product->contact_phone); ?></td>
                        </tr>
                        <tr>
                            <th scope="row"><?php echo e(__('msg.email')); ?>:</th>
                            <td class="text-right"><?php echo e($product->contact_email); ?></td>
                        </tr>
                        <tr>
                            <th scope="row"><?php echo e(__('msg.address')); ?>:</th>
                            <td class="text-right"><?php echo e($product->contact_address); ?></td>
                        </tr>
                    </tbody>
                </table>
                <div class="text-center">
                    <?php if(\Illuminate\Support\Facades\Auth::user()): ?>
                        <?php if($product->user_id && $product->user_id != \Illuminate\Support\Facades\Auth::user()->id): ?>
                            <a href="#" class="btn btn-danger btn-send-message mb-4"
                               data-toggle="modal" data-target="#modal-send-message"
                               data-to-user="<?php echo e($product->user_id); ?>"
                               data-from-product="<?php echo e($product->id); ?>"
                               title="Gửi tin cho người đăng"><?php echo e(__('msg.send_mess_to_author')); ?></a>
                        <?php endif; ?>
                    <?php endif; ?>
                    <?php if($product->user_id != 0): ?>
                    <a href="<?php echo e(route('user-product', ['id' => $product->user_id])); ?>" class="btn btn-success mb-4"><?php echo e(__('msg.view_product_by_author')); ?></a>
                    <?php endif; ?>
                    <a href="#" class="btn btn-primary mb-4"><?php echo e(__('msg.view_same_kind')); ?></a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 text-muted">
        <strong><?php echo e(__('msg.product_id')); ?>:</strong> <?php echo e($product->id); ?>

    </div>
    <div class="col-md-3 text-muted">
        <strong><?php echo e(__('msg.product_post_type')); ?>:</strong> <?php echo e($product->levelText()); ?>

    </div>
    <div class="col-md-3 text-muted">
        <strong><?php echo e(__('msg.product_created')); ?>:</strong> <?php echo e($product->from_date_text); ?>

    </div>
    <div class="col-md-3 text-muted">
        <strong><?php echo e(__('msg.product_expired')); ?>:</strong> <?php echo e($product->to_date_text); ?>

    </div>
    <div class="col-md-12 mt-3">
        <h6 class="text-muted"><?php echo e(__('msg.note')); ?>:</h6>
        <p class="text-muted">
            <?php echo __('msg.product_detail_note', ['title' => $product->title]); ?>

        </p>
    </div>
    <div class="col-12">
        <?php echo $__env->make('partials.related-products', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('advanced_search'); ?>
    <?php echo $__env->make('partials.advanced-search', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->make('partials.class-category', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>