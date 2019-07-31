<?php $__env->startSection('title', 'Page Not Found'); ?>

<?php $__env->startSection('message', 'Xin lỗi, trang mà bạn đang tìm kiếm không tồn tại'); ?>

<?php echo $__env->make('errors::layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>