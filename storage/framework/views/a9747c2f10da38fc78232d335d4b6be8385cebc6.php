<?php
    $p_r = $products[0];    
    $img_cat_link ='';
    if($p_r){
        $img_cat_link = $p_r->thumb_url;
    }    
    $title = '';
    $meta_title = '';
    $description = '';
    $metaTitle = 'VietnamAds';
    $metaKeys = 'VietnamAds';
    $metaDescription = 'VietnamAds';
    $metaCanonical = \Illuminate\Support\Facades\Request::url();
    $topdescription = '';
    $bottomdescription = '';
    $isClassCategory = false;
    if (!empty($subCat) && !empty($subCat->name)){
        $topdescription = $subCat->description;
        $bottomdescription = $subCat->content;  
    }else{
        $topdescription = $cat['topdescription'];
        $bottomdescription = $cat['bottomdescription']; 

    }

    if (!empty($subCat)){
        $meta_title = $subCat->meta_title;    
    }
    if ($cat && isset($cat['name'])) {
        $title .= $cat['name'];
        $description = $cat['description'];
        $metaDescription = $description;
        $metaKeys = $cat['keywords'];          
    }
    if (!empty($subCat) && !empty($subCat->name)){

 
        $title .=  strtolower(' ' . $subCat->name);
        if ($subCat->description) {
            $description = $subCat->description;
        }
        $metaKeys = $subCat->meta_keywords ? : $metaKeys;
        $metaDescription = $subCat->meta_description ? : $metaDescription;
        $metaCanonical = $subCat->meta_canonical ? : $metaCanonical;
        $topdescription = $subCat->description;
        $bottomdescription = $subCat->content;                
    } else {
        $subCat = null;
    }   
    
    if(!$_GET){    
        if ($city !='null' && $district =='null' && $check !='Yes') {
            $scity = json_decode($city);           
            $title .= ' tại '.$scity->name;
            $metaDescription .= ' tại '.$scity->name;
            $metaKeys .= ' tại '.$scity->name;          
          
        }
        if ($district !='null' && $check !='Yes') {
            $scity = json_decode($city);           
            $sdistrict = json_decode($district);
            $title .= ' tại '.$sdistrict->name.', '.$scity->name;
            $metaDescription .= ' tại '.$sdistrict->name.', '.$scity->name;
            $metaKeys .= ' tại '.$sdistrict->name.', '.$scity->name;         
          
        }  
    }else{
        if(!empty($_GET['district'])){
            $c = \App\Lib\Location::getCity($_GET['city']);
            $d = \App\Lib\Location::getDistrict($_GET['district']);
            if ($c && isset($cat['name'])) {
                $title .= ' tại ' . $d['name'].', '.$c['name'];
            }
        }
       if(!empty($_GET['city']) && empty($_GET['district'])){
            $c = \App\Lib\Location::getCity($_GET['city']);
            if ($c && isset($cat['name'])) {
                $title .= ' tại ' . $c['name'];
            }
        }        
    }  
      
    if(!empty($classCategory) && $classCategory) {        
        $title = $classCategory->name;
        $isClassCategory = true;
        if ($classCategory->description) {
            $description = $classCategory->description;
        }
        $metaKeys = $classCategory->meta_keywors ? : $metaKeys;
        $metaDescription = $classCategory->meta_description ? : $metaDescription;
        $metaCanonical = $classCategory->meta_canonical ? : $metaCanonical;
    }  
    
    $title = trim($title);
    $heading = trim($title);

    if (!empty($subCat->meta_title) && empty($subCat)){
        $title = $cat['title'];    
    }elseif(!empty($meta_title)){
       $title = $meta_title;
    } else{
       $title = trim($title);  
    }    
?>
<?php $__env->startSection('meta-tags'); ?>    
    <meta name="keywords" content="<?php echo e($metaKeys); ?>">
    <meta name="description" content="<?php echo e($metaDescription); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('meta-canonical'); ?>
    <link rel="canonical"  href="<?php echo e($metaCanonical); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <?php if(isset($classCategory)): ?>
        <?php echo e(Breadcrumbs::render('class_category', $cat, $subCat, $classCategory)); ?>

    <?php elseif(!empty($subCat)): ?>
        <?php echo e(Breadcrumbs::render('subcategory', $cat, $subCat)); ?>

    <?php elseif($cat): ?>
        <?php echo e(Breadcrumbs::render('category', $cat)); ?>

    <?php endif; ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('title'); ?>
    <?php if(!empty($cat)): ?>
    <title><?php echo e($title); ?> | VietnamAds</title>
    <?php else: ?>
    <title>Tin rao | VietnamAds</title>
    <?php endif; ?>
    <meta property="og:title" content="<?php echo e($title); ?>" />
    <meta property="og:type" content="article" />
    <meta property="og:url" content="<?php echo e(\Illuminate\Support\Facades\Request::url()); ?>" />
    <meta property="og:image" content="<?php echo e($img_cat_link); ?>" />
    <meta property="og:site_name" content="VietnamAds | Kênh thông tin quảng cáo và marketing của Việt Nam" />
    <meta property="og:description" content="<?php echo e($metaDescription); ?>" />
    <meta property="og:image:secure_url" content="<?php echo e($img_cat_link); ?>" />
    <meta name="twitter:card" content="summary" />
    <meta name="twitter:title" content="<?php echo e($title); ?>" />
    <meta name="twitter:description" content="<?php echo e($metaDescription); ?>" />
    <meta name="twitter:image" content="<?php echo e($img_cat_link); ?>" />        
<?php $__env->stopSection(); ?>

<?php $__env->startSection('main'); ?>
<div class="row">
    <div class="col-12">
        <div class="box-search-text">
            
            <form class="form-inline form-search" method="GET" action="<?php echo e(URL::current()); ?>">
            
            
            
                <img src="/imgs/icons/icon_search.png" class="icon-search">
                <input type="text" class="form-control" placeholder="Nhập từ khóa" name="s" value="<?php echo e($keyword); ?>">
                <button type="submit" class="btn btn-primary"><?php echo e(__('search')); ?></button>
                <input type="hidden" name="order" value="<?php echo e($order); ?>">
                <input type="hidden" name="has_image" value="<?php echo e($has_image); ?>">
                <input type="hidden" name="has_video" value="<?php echo e($has_video); ?>">
                <input type="hidden" name="city" value="<?php echo e($city); ?>">
                <input type="hidden" name="district" value="<?php echo e($district); ?>">
                <input type="hidden" name="ward" value="<?php echo e($ward); ?>">
                <input type="hidden" name="street" value="<?php echo e($street); ?>">
                <input type="hidden" name="provider" value="<?php echo e($provider); ?>">
                <input type="hidden" name="price_range" value="<?php echo e($price_range); ?>">
                <input type="hidden" name="sub_cat" value="<?php echo e(isset($subCat) && isset($subCat['id']) ? $subCat['id'] : ''); ?>">
                
                    
                        <input type="hidden" name="pano_type" value="<?php echo e(isset($pano_type)  ? $pano_type  : ''); ?>" >
                        <input type="hidden" name="pano_size" value="<?php echo e(isset($pano_size) ? $pano_size : ''); ?>">
                        <input type="hidden" name="pano_border" value="<?php echo e(isset($pano_border) ? $pano_border : ''); ?>">
                        <input type="hidden" name="pano_light" value="<?php echo e(isset($pano_light) ? $pano_light : ''); ?>">
                    
                        <input type="hidden" name="social_type" value="<?php echo e(isset($social_type) ? $social_type : ''); ?>">
                        <input type="hidden" name="social_follow" value="<?php echo e(isset($social_follow) ? $social_follow : ''); ?>">
                    
                        <input type="hidden" name="web_type" value="<?php echo e(isset($web_type) ? $web_type : ''); ?>">
                        <input type="hidden" name="web_position" value="<?php echo e(isset($web_position) ? $web_position : ''); ?>">
                    
                
            </form>
        </div>
        
        <div class="card card-primary">
            <?php if(!empty($cat)): ?>
            <div class="card-header"><h1><?php echo e($heading); ?></h1></div>
            <?php else: ?>
            <div class="card-header"><h2>Kết quả tìm kiếm</h2></div>            
            <?php endif; ?>
            <?php if(!empty($topdescription)): ?>
                <div class="alert alert-light">
                    <?php echo $topdescription; ?>

                </div>
            <?php endif; ?>
            <div class="card-body">
                <?php if(!empty($cat)): ?>
                <div class="product-filter">
                    <form action="" class="form-inline">
                        <span>Sắp xếp theo: </span>
                        <select class="form-control" name="order">
                            <option value="" <?php if($order == 'default' || $order == ''): ?> selected <?php endif; ?>>Thông thường</option>
                            <option value="newest" <?php if($order == 'newest'): ?> selected <?php endif; ?>>Tin mới nhất</option>
                            <option value="no_price" <?php if($order=='no_price' ): ?> selected <?php endif; ?>>Giá thỏa thuận</option>
                            <option value="lowest_price" <?php if($order == 'lowest_price'): ?> selected <?php endif; ?>>Giá thấp nhất</option>
                            <option value="highest_price" <?php if($order=='highest_price' ): ?> selected <?php endif; ?>>Giá cao nhất</option>
                        </select>
                        <div class="form-check ml-3">
                            <input type="checkbox" class="form-check-input" name="has_image" id="productHasImage" <?php if($has_image): ?> checked <?php endif; ?>>
                            <label class="form-check-label" for="productHasImage">Tin rao có ảnh</label>
                        </div>
                        <div class="form-check ml-3">
                            <input type="checkbox" class="form-check-input" name="has_video" id="productHasVideo" <?php if($has_video): ?> checked <?php endif; ?>>
                            <label class="form-check-label" for="productHasVideo">Tin rao có video</label>
                        </div>
                        <?php if(!$isClassCategory): ?>
                        <a href="<?php echo e($viewMapUrl); ?>" class="btn btn-link">Xem trên bản đồ</a>
                        <?php endif; ?>
                    </form>
                </div>
                <?php endif; ?>
                <div class="total-item">Có <?php echo e($products->total()); ?> tin đang rao</div>

                <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php $__env->startComponent('components.product_category', ['p' => $p]); ?>
                    <?php echo $__env->renderComponent(); ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php if(count($products) == 0): ?>
                <p class="text-center">Không tìm thấy kết quả nào</p>
                <?php endif; ?>        
            </div>
        </div>
        <?php echo $products->appends(Illuminate\Support\Facades\Input::except('page'))->links(); ?>

        <?php if(empty($_GET['page']) || $_GET['page'] <= 1): ?>
        <?php if(!empty($bottomdescription)): ?>
        <div class="card card-primary">
            <div class="alert alert-light">
                <?php echo $bottomdescription; ?>                        
            </div>
        </div>
        <?php endif; ?>            
        <?php endif; ?>            
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('advanced_search'); ?>
    <?php echo $__env->make('partials.advanced-search', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->make('partials.class-category', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>