<?php
$post_id = get_the_ID();
$calculadora_title = get_post_meta($post_id, 'home_calculadora_title', true);
$calculadora_image = get_post_meta($post_id, 'home_calculadora_image', true);
?>
<section class="destaque">
    <div class="container">
        <div class="row">
            <div class="col-md-6 destaque-image-col">
                <?php if ($calculadora_image) { ?>
                    <img class="destaque-image" src="<?php echo $calculadora_image; ?>">
                <?php } ?>
            </div>
            <div class="col-md-6 destaque-text-col gap-3">
                <?php if ($calculadora_title) { ?>
                    <h4 class="destaque-title"><?php echo $calculadora_title; ?></h4>
                    <?php get_template_part('template-parts/general/simulador-credito-habitacao-preview'); ?>
                <?php } ?>
            </div>
        </div>
    </div>
</section>