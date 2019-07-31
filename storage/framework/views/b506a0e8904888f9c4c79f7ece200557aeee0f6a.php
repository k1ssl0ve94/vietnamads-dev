<?php if(count($hotPosts) > 0): ?>
<div id="box-top-content">
    <?php
        $post = $hotPosts[0];
        $hotPostData = [];
        foreach ($hotPosts as $p) {
            $hotPostData[] = [
                'id' => $p->id,
                'title' => $p->title,
                'title_short' => str_limit($p->title, 60),
                'url' => $post->getPostURL(),
                'image_url' => $p->image_url,
                'sapo_short' => str_limit($p->sapo, 130),
            ];
        }
    ?>
    <script>
        window.hot_post_data = <?php echo json_encode($hotPostData); ?>;
    </script>
    <div class="top-post clearfix">
        <a href="<?php echo e($post->getPostURL()); ?>" class="image rounded" title="<?php echo e($post->title); ?>">
            <?php if($post->image_url): ?>
            <img src="<?php echo e($post->image_url); ?>" class="img-fluid" alt="<?php echo e($post->image_alt ? : $post->title); ?>">
            <?php else: ?>
            <img src="/imgs/img_placeholder.png" class="img-fluid " alt="<?php echo e($post->title); ?>">
            <?php endif; ?>
        </a>
        <div class="content">
            <a href="<?php echo e($post->getPostURL()); ?>" class="title" title="<?php echo e($post->title); ?>"><?php echo e(str_limit($post->title, 60)); ?></a>
            <p><?php echo e(str_limit($post->sapo, 130)); ?></p>
        </div>
    </div>
    <div class="box-top-titles">
        <?php $__currentLoopData = $hotPosts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <a href="<?php echo e($p->getPostURL()); ?>" class="title" title="<?php echo e($p->title); ?>">
            <?php echo e(str_limit($p->title, 55)); ?>

        </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>
<?php endif; ?>