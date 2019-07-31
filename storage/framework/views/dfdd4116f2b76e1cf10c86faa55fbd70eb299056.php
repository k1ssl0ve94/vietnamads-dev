<div class="">
    <?php if(isset($cat) && $cat['classCategoryArray']): ?>
    <div class="card card-muted">
        <div class="card-header"><h2>Nhóm tin nổi bật</h2></div>
        <div class="card-body">
            <ul class="link-list">
                <?php if($cat['classCategoryArray']): ?>
                    <?php $__currentLoopData = $cat['classCategoryArray']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <h3>
                            <a href="<?php echo e(route('class-category', ['id' => $class['id'], 'slug' => str_slug($class['name'])])); ?>">
                                <?php echo e($class['name']); ?>

                            </a>
                        </h3>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
            </ul>
        </div>
    </div>
    <?php endif; ?>
    <?php if(isset($subCat) && $subCat->classCategoryArray): ?>
        <div class="card card-muted">
            <div class="card-header"><h2>Gợi ý tìm kiếm</h2></div>
            <div class="card-body">
                <ul class="link-list">
                    <?php if($subCat->classCategoryArray): ?>
                        <?php $__currentLoopData = $subCat->classCategoryArray; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <h3>
                                <a href="<?php echo e(route('class-category', ['id' => $class['id'], 'slug' => str_slug($class['name'])])); ?>">
                                    <?php echo e($class['name']); ?> (<?php echo e(number_format($class['total_products'])); ?>)
                                </a>
                            </h3>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    <?php endif; ?>
</div>