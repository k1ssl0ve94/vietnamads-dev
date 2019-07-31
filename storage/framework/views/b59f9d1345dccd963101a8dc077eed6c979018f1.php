<?php $__env->startSection('title'); ?>
    <title><?php echo e($seos['meta_title']); ?></title>
<?php echo $__env->yieldSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <?php echo e(Breadcrumbs::render('home')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('meta-tags'); ?>
    <meta name="description" content="<?php echo e($seos['meta_description']); ?>">
    <meta name="keywords" content="<?php echo e($seos['meta_keywords']); ?>">
    <meta property="og:url"           content="<?php echo e(\Illuminate\Support\Facades\Request::url()); ?>" />
    <meta property="og:type"          content="website" />
    <meta property="og:title"         content="<?php echo e($seos['fb_meta_title']); ?>" />
    <meta property="og:description"   content="<?php echo e($seos['fb_meta_description']); ?>" />
    <meta property="og:image"         content="<?php echo e($seos['fb_image_url']); ?>" />    
    <script type="application/ld+json">
    {
        "@context": "http://schema.org",
        "@type" : "Organization",
        "name": "Vietnam Ads",
        "url": "https://www.vietnamads.vn/",
        "description": "Vietnamads là kênh thông tin về dịch vụ quảng cáo và marketing hàng đầu tại Việt Nam. Người dùng có thể dễ dàng tra cứu, tìm kiếm hoặc đăng tải các thông tin về các dịch vụ quảng cáo và marketing trên vietnamads với khối lượng tin tức lớn,đầy đủ và luôn được cập nhật liên tục 24/7",
        "address": "Tầng 8, tòa nhà 315 Trường Chinh, Thanh Xuân, Hà Nội",
        "email": "mailto:vietnamadsdotvn@gmail.com",
        "sameAs" :
        [
            "https://twitter.com/vietnamadsvn",
            "https://www.instagram.com/vietnamads/",
            "https://www.linkedin.com/company/vietnamads/about/",
            "https://about.me/vietnamads/",
            "https://www.youtube.com/channel/UCTWgeGSUC_Fh5_YBNteussQ/about",
            "https://soundcloud.com/vietnamads",
            "https://vietnamads.tumblr.com/",
            "https://myspace.com/vietnamads",
            "https://www.pinterest.com/vietnamadsvn/",
            "https://trello.com/vietnamads",
            "https://www.reddit.com/user/vietnamadsvn/",
            "https://www.scoop.it/u/vietnamads",
            "https://www.quora.com/profile/Long-Anh-5",
            "https://github.com/vietnamads",
            "https://medium.com/@vietnamads",
            "https://www.behance.net/vietnamads"
        ],
         "contactPoint": {
            "@type": "ContactPoint",
            "telephone": "+84919562247",
            "contactType": "customer service",
            "areaServed": "Việt Nam"
        }
    }
</script>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('main'); ?>
    <?php echo $__env->make('partials.col-left', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>