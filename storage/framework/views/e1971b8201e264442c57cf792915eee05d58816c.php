<?php
    $metaCanonical = \Illuminate\Support\Facades\Request::url();
    if ($post->meta_canonical) {
        $metaCanonical = $post->meta_canonical;
    }
?>

<?php $__env->startSection('meta-tags'); ?>
    <meta name="keywords" content="<?php echo e($post->meta_keywords); ?>">
    <meta name="description" content="<?php echo e($post->meta_description); ?>">
    <link rel="canonical"  href="<?php echo e($post->meta_canonical); ?>">

    <meta property="fb:app_id" content="<?php echo e(config('services.facebook.client_id')); ?>" />
    <meta property="og:url" content="<?php echo e($post->getPostURL()); ?>" />
    <meta property="og:type" content="article" />
    <meta property="og:image" content="<?php echo e($post->getImageUrlFull()); ?>" />
    <meta property="og:image:alt" content="<?php echo e($post->title); ?>" />

    <?php if($post->meta_description): ?>
    <meta property="og:description" content="<?php echo e($post->meta_description); ?>" />
    <?php else: ?>
    <meta property="og:description" content="<?php echo e($post->meta_description); ?>" />
    <?php endif; ?>

    <?php if($post->meta_title): ?>
    <meta property="og:title" content="<?php echo e($post->meta_title); ?>" />
    <?php else: ?>
    <meta property="og:title" content="<?php echo e($post->title); ?>" />
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('meta-canonical'); ?>
    <link rel="canonical"  href="<?php echo e($metaCanonical); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('title'); ?>
    <?php if($post->meta_title): ?>
        <title><?php echo e($post->meta_title); ?> | VietnamAds</title>
    <?php else: ?>
        <title><?php echo e($post->title); ?> | VietnamAds</title>
    <?php endif; ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <?php echo e(Breadcrumbs::render('news_detail', $post)); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('main'); ?>
<div class="row">
    <div class="col-12">
        <div class="box-search-text">
            <form class="form-inline">
                <img src="/imgs/icons/icon_search.png" class="icon-search">
                <input type="text" class="form-control" placeholder="Nhập từ khóa">
                <button type="submit" class="btn btn-primary">Tìm kiếm</button>
            </form>
        </div>
    </div>
    <div class="col-12">
        <div class="card card-post">
            <div class="card-header" style="color: #ffffff"><h1><?php echo e($post->title); ?></h1></div>
            <div class="card-body">                
                <div class="mb-3 content">
                    <?php echo $post->content; ?>

                </div>
                <div class="mb-3 share">
                    <div class="addthis_inline_share_toolbox_t3om"></div>
                </div>
                <div class="row">
                    <h6 class="col-12">Các tin liên quan</h6>
                    <ul class="col-12 list-group">
                        <?php $__currentLoopData = $relatedPosts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="list-group-item-light">
                                <a href="<?php echo e($p->getPostURL()); ?>"><?php echo e($p->title); ?></a></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            </div>
        </div>
        <?php echo $__env->make('partials.hot-news', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?> 
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>