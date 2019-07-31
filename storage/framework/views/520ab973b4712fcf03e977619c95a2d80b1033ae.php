<div class="card card-primary">
    <div class="card-header"><h2><?php echo e(__('msg.product_same_cat')); ?></h2></div>
    <div class="card-body">
        <div class="row">
            <?php $__currentLoopData = $relatedProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-md-6">
                <?php $__env->startComponent('components.product_home', ['p' => $p]); ?>
                <?php echo $__env->renderComponent(); ?>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</div>
<div class="text-right">
    <a href="<?php echo e(route('subcat', ['catSlug'=> $product->cat(\App::getLocale())['slug'], 'slug' => $product->subCatSlug(), 'city' => $product->city])); ?>"
       class="btn btn-flat btn-primary"><?php echo e(__('msg.view_more')); ?> <i class="fa fa-angle-double-right"></i></a>
</div>