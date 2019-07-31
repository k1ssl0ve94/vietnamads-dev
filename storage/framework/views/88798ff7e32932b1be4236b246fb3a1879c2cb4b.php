<!doctype html>
<html lang="<?php echo e(app()->getLocale()); ?>">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
        <title>VietnamAds - Admin</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,300i,400,400i,500,500i,600,600i,700,700i&amp;subset=latin-ext">
        <link rel="stylesheet" href="<?php echo e(mix('css/app.css', 'backend')); ?>">
    </head>
    <body>
        <div id="app"></div>
        <script src="<?php echo e(mix('js/manifest.js', 'backend')); ?>"></script>
        <script src="<?php echo e(mix('js/vendor.js', 'backend')); ?>"></script>
        <script src="<?php echo e(mix('js/app.js', 'backend')); ?>"></script>
    </body>
</html>
