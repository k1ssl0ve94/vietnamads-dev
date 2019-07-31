<?php
if (!isset($cat)) {
    $cat = $p->cat();
}
$subCat = json_decode($p->subCat, true);
$link = $p->detailLink();
?>
<div class="post clearfix">
    <div class="thumb rounded">
        <a href="<?php echo e($link); ?>" title="<?php echo e($p->title); ?>">
            <img src="<?php echo e($p->thumbImage()); ?>" class="img-fluid" alt="<?php echo e($p->title); ?>">
        </a>
        <?php if(!empty($badge)): ?>
        <span class="badge badge-danger"><?php echo e($badge); ?></span>
        <?php endif; ?>
    </div>
    <div class="info">
        <h3>
            <a href="<?php echo e($link); ?>" class="title d-block"
               style="color: <?php echo e($p->title_color); ?>"
               title="<?php echo e($p->title); ?>">
                <?php if($p->icon): ?>
                    <span class="badge badge-danger"><i class="fa fa-diamond"></i></span>
                <?php endif; ?>
                <?php echo e(str_limit($p->title, 60)); ?></a>
        </h3>
        <ul class="meta">
            <li style="color: <?php echo e($p->parameter_color); ?>"><img src="/imgs/icons/ic_date.svg" class="meta-icon"> <?php echo e($p->created_at->format('d/m/Y')); ?></li>
            <li style="color: <?php echo e($p->parameter_color); ?>"><img src="/imgs/icons/ic_hinhthuc.svg" class="meta-icon"><?php echo e($subCat['name']); ?></li>
            <li style="color: <?php echo e($p->parameter_color); ?>"><img src="/imgs/icons/ic_diachi.svg" class="meta-icon"> <?php echo e($p->locationText()); ?></li>
            <li style="color: <?php echo e($p->price_color); ?>"><img src="/imgs/icons/ic_giatien.svg" class="meta-icon"> <?php echo e($p->priceText()); ?></li>
            <?php if($p->verified_by_admin): ?>
                <li><span class="badge-success badge">Đã xác minh người đăng</span></li>
            <?php endif; ?>
        </ul>
    </div>
</div>