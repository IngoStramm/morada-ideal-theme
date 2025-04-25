<?php
$mi_add_form_home_filter_imovel_nonce = wp_create_nonce('mi_form_home_filter_imovel_nonce');

$operacao_terms = get_terms(array(
    'taxonomy'   => 'operacao',
    'hide_empty' => false,
));
$tipo_terms = get_terms(array(
    'taxonomy'   => 'tipo',
    'hide_empty' => false,
));
?>
<form role="filter" method="post" name="home-filter-imoveis" id="home-filter-imoveis" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" class="needs-validation home-filter-imoveis-form" novalidate>
    <div class="wd-find-select">
        <div class="inner-group">
            <?php if ($operacao_terms) { ?>
                <div class="form-group-1 search-form form-style">
                    <div class="group-select select-list">
                        <div class="nice-select" tabindex="0">
                            <span class="current"><?php _e('Negócio', 'mi'); ?></span>
                            <ul class="list" id="operacao-filter">
                                <li class="option" data-value="" data-term-id="">
                                    <?php _e('Todos', 'mi'); ?>
                                </li>
                                <?php foreach ($operacao_terms as $term) { ?>
                                    <li data-value="<?php echo $term->name; ?>" data-term-id="<?php echo $term->term_id; ?>" class="option"><?php echo $term->name; ?></li>
                                <?php } ?>
                            </ul>
                        </div>
                        <input type="hidden" name="operacao-term" id="operacao-term" data-select-list-value value="">
                    </div>
                </div>
            <?php } ?>
            <?php if ($tipo_terms) { ?>
                <div class="form-group-1 search-form form-style">
                    <div class="group-select select-list">
                        <div class="nice-select" tabindex="0">
                            <span class="current"><?php _e('Tipo', 'mi'); ?></span>
                            <ul class="list" id="tipo-filter">
                                <li class="option" data-value="" data-term-id="">
                                    <?php _e('Todos', 'mi'); ?>
                                </li>
                                <?php foreach ($tipo_terms as $term) { ?>
                                    <li data-value="<?php echo $term->name; ?>" data-term-id="<?php echo $term->term_id; ?>" class="option"><?php echo $term->name; ?></li>
                                <?php } ?>
                            </ul>
                        </div>
                        <input type="hidden" name="tipo-terms" id="tipo-terms" data-select-list-value value="">
                    </div>
                </div>
            <?php } ?>
            <div class="form-group-2 form-style">
                <?php echo mi_autocomplete_search_input(); ?>
            </div>

        </div>
        <div class="box-btn-advanced">
            <button type="submit" class="tf-btn btn-search primary"><?php _e('Procurar', 'mi'); ?> <i class="icon icon-search"></i> </button>
        </div>

    </div>
    <input type="hidden" name="mi_form_home_filter_imovel_nonce" value="<?php echo $mi_add_form_home_filter_imovel_nonce ?>" />
    <input type="hidden" value="mi_home_filter_imovel" name="action">
</form>