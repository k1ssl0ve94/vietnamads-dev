<!doctype html>
<html lang="<?php echo e(app()->getLocale()); ?>">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="robots" content="noindex">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <meta name="google-site-verification" content="SiY3rxs81xpi7JKDyYyaqLJJwYAOKoJBF59TKr0neeI" />
    <?php $__env->startSection('title'); ?>
    <title><?php echo e($seos['meta_title']); ?></title>
    <?php echo $__env->yieldSection(); ?>
    <?php $__env->startSection('meta-tags'); ?>
    <meta name="description" content="<?php echo e($seos['meta_description']); ?>">
    <meta name="keywords" content="<?php echo e($seos['meta_keywords']); ?>">
    <?php echo $__env->yieldSection(); ?>
    <?php $__env->startSection('meta-canonical'); ?>
    <link rel="canonical"  href="<?php echo e(\Illuminate\Support\Facades\Request::url()); ?>">
    <?php echo $__env->yieldSection(); ?>
    <meta name="author" content="vietnamads.vn">
    <meta name="robots" content="index, follow" />
    <meta name="geo.region" content="VN" />
    <meta name="geo.placename" content="Ha Noi, Ho Chi Minh" />
    <meta name="geo.position" content="21.02945;105.854444" />
    <meta name="ICBM" content="21.02945, 105.854444" />
    <link rel="shortcut icon" href="/imgs/icon.ico" />

    
          
    

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,400i,500,500i,700,700i&amp;subset=latin-ext,vietnamese">
    <link rel="stylesheet" href="<?php echo e(mix('css/app.css')); ?>">
    
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-131416354-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'UA-131416354-1');
    </script>
</head>
<body>
    <?php echo $__env->make('partials.header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <div id="main">
        <div class="container">
            
            
            
            
            
            
            <div class="row">
                <div class="col-md-12 col-12">
                    <?php echo $__env->yieldContent('breadcrumb'); ?>
                </div>
                <div class="col-lg-9">
                    <?php echo $__env->yieldContent('main'); ?>
                </div>
                <div class="col-lg-3">
                    <?php $__env->startSection('col-right'); ?>
                        <?php echo $__env->make('partials.col-right', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                    <?php echo $__env->yieldSection(); ?>
                </div>
            </div>
        </div>
    </div>
    <?php echo $__env->make('partials.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->make('partials.modals', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <script src="/js/location.js"></script>
    <?php echo NoCaptcha::renderJs(); ?>

    <script>
        window.all_settings = <?php echo json_encode($allSettings); ?>;
        window.app_url = <?php echo json_encode(url('/')); ?>;
    </script>
    <script src="<?php echo e(mix('js/manifest.js')); ?>"></script>
    <script src="<?php echo e(mix('js/vendor.js')); ?>"></script>
    <script src="<?php echo e(mix('js/app.js')); ?>"></script>
    <?php echo $__env->yieldContent('other_scripts'); ?>
</body>
</html>