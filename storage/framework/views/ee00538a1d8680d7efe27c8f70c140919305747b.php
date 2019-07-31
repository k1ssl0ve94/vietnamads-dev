<!doctype html>
<html lang="<?php echo e(app()->getLocale()); ?>">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <?php $__env->startSection('title'); ?>
        <title>VietnamAds</title>
    <?php echo $__env->yieldSection(); ?>
    <?php $__env->startSection('meta-tags'); ?>
        <meta name="description" content="Vietnamads.vn, vietnamads, quang cao, marketing">
        <meta name="keywords" content="Vietnamads.vn, vietnamads, quang cao, marketing">
    <?php echo $__env->yieldSection(); ?>
    <?php $__env->startSection('meta-canonical'); ?>
        <link rel="canonical"  href="<?php echo e(\Illuminate\Support\Facades\Request::url()); ?>">
    <?php echo $__env->yieldSection(); ?>
    
          
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,400i,500,500i,700,700i&amp;subset=latin-ext,vietnamese">
    <link rel="stylesheet" href="<?php echo e(mix('css/app.css')); ?>">
    <link rel="shortcut icon" href="/imgs/icon.ico" />
    
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
                <div class="col-md-12">
                    <?php echo $__env->yieldContent('main'); ?>
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
    </script>
    <script src="<?php echo e(mix('js/manifest.js')); ?>"></script>
    <script src="<?php echo e(mix('js/vendor.js')); ?>"></script>
    <script src="<?php echo e(mix('js/app.js')); ?>"></script>
</body>
</html>