<div class="slider">
    <?if(!empty($slides)){?>
        <?if(count($slides) > 0){?>
            <?foreach($slides as $oneSlide){?>
                <div class="slider_item">
                    <img src="<?= $oneSlide->big_img_src;?>" />
                </div>
            <?}?>
        <?}?>
    <?}?>
</div>