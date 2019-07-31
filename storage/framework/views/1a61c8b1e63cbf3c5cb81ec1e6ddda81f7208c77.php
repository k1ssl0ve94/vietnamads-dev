<?php
$link = $p->detailLink();
$subCat = json_decode($p->subCat, true);
?>
<div class="post clearfix big-post">
    <h3>
        <a href="<?php echo e($link); ?>" class="title d-block" style="color: <?php echo e($p->title_color); ?>" title="<?php echo e($p->title); ?>">
            <?php if($p->icon): ?>
                <span class="badge badge-danger"><i class="fa fa-diamond"></i></span>
            <?php endif; ?>
            <?php echo e($p->title); ?></a>
    </h3>
    <div class="thumb rounded">
        <a href="<?php echo e($link); ?>" title="<?php echo e($p->title); ?>">
            <img src="<?php echo e($p->thumbImage()); ?>" class="img-fluid" alt="<?php echo e($p->title); ?>">
        </a>
    </div>
    <div class="info">
        <p><?php echo e(str_limit($p->content, 330)); ?></p>
        <div class="row">
            <div class="col-sm-4">
                <ul class="meta">
                    <li style="color: <?php echo e($p->price_color); ?>"><img src="/imgs/icons/ic_giatien.svg" class="meta-icon"> <?php echo e($p->priceText()); ?></li>
                    <li style="color: <?php echo e($p->parameter_color); ?>"><img src="/imgs/icons/ic_diachi.svg" class="meta-icon"> <?php echo e($p->locationText()); ?></li>
                </ul>
            </div>
            <div class="col-sm-4">
                <ul class="meta">
                    <li style="color: <?php echo e($p->parameter_color); ?>"><img src="/imgs/icons/ic_diachi.svg" class="meta-icon"> <?php echo e($p->contact_address); ?></li>
                    <li style="color: <?php echo e($p->parameter_color); ?>"><img src="/imgs/icons/ic_ten.svg" class="meta-icon"> <?php echo e($p->contact_name); ?></li>
                </ul>
            </div>
            <div class="col-sm-4">
                <ul class="meta">
                    <li style="color: <?php echo e($p->parameter_color); ?>"><img src="/imgs/icons/ic_hinhthuc.svg" class="meta-icon"> <?php echo e($subCat['name']); ?></li>
                    <li style="color: <?php echo e($p->parameter_color); ?>">
                        <img src="/imgs/icons/ic_date.svg" class="meta-icon"> <?php echo e($p->created_at->format('d/m/Y')); ?>

                    </li>
                </ul>
            </div>
            <?php if($p->user && $p->user->verified_by_admin): ?> 
            <div class="col-sm-4">
                <ul class="meta">
                    <li><span class="badge-success badge">Đã xác minh người đăng</span></li>
                </ul>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>