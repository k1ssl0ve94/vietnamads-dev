
<a class="btn btn-success btn-block" id="btn-tu-van" href="tel:19000127">
    Hỗ trợ dịch vụ
    <div><i class="fa fa-phone" aria-hidden="true"></i> 1900 0127</div>
    <div class="note">(1000đ/phút T2 - sáng T7 giờ hành chính)</div>
</a>
<?php echo $__env->yieldContent('advanced_search'); ?>


    


<?php if(request()->path() == "/"): ?>
<div class="card card-muted">
    <div class="card-header"><h2>Nhà cung cấp hàng đầu</h2></div>
    <div class="card-body" id="top-brands">
        <div class="row">
            <?php $__currentLoopData = $brands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col brand col-4" data-img="<?php echo e($b->logo_url); ?>">
                <a href="<?php echo e($b->url); ?>">
                    <img class="image img-fluid"
                            src="<?php echo e($b->logo_url); ?>" alt="<?php echo e($b->name); ?>">
                </a>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</div>
<?php endif; ?>
<?php $__currentLoopData = $keywordData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<div class="card card-muted">
    <div class="card-header"><?php echo e($data['title']); ?></div>
    <div class="card-body">
        <ul class="link-list">
            <?php $__currentLoopData = $data['keywords']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php 
    
        if( strpos($row['url'], '?city=') !== false){
        
                    $city_id = explode("=", $row['url']);
                    if( !is_numeric($city_id[1]) ){
                        $row['url'] = str_replace('?city=', '/', $row['url']);
                    }
        } 
                ?>
                <h3 class="link-add-broad"><a href="<?php echo e($row['url']); ?>" title="<?php echo e($row['text']); ?>"><?php echo e($row['text']); ?></a></h3>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>
</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


    

