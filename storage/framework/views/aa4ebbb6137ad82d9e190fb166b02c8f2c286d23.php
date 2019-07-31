<div class="card card-primary">
    <div class="card-header">Tin Tức nổi bật</div>
    <div class="card-body">
        <div class="row">
            <?php $__currentLoopData = $hotNews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-md-6">
                <div class="post clearfix">
                    <div class="thumb rounded">
                        <a href="<?php echo e($post->getPostURL()); ?>" alt="">
                            <?php if($post->image_url): ?>
                            <img src="<?php echo e($post->image_url); ?>" class="img-fluid"
                                alt="<?php echo e($post->image_alt ? : $post->title); ?>">
                            <?php else: ?>
                            <img src="/imgs/img_placeholder.png" class="img-fluid"
                                alt="VietnamAds">
                            <?php endif; ?>
                        </a>
                    </div>
                    <div class="info">
                        <a href="<?php echo e($post->getPostURL()); ?>" class="title d-block"><?php echo e(str_limit($post->title, 70)); ?></a>
                        <p><?php echo e(str_limit($post->sapo, 100)); ?></p>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</div>