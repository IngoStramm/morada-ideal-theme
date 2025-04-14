<?php
// Filter Search
$operacao_terms = get_terms(array(
    'taxonomy'   => 'operacao',
    'hide_empty' => false,
));
?>
<form role="filter" method="get" name="filter-imoveis">
    <div class="wd-find-select">
        <div class="inner-group">
            <?php if ($operacao_terms) { ?>
                <div class="form-group-1 search-form form-style">
                    <label><?php _e('Tipo', 'mi'); ?></label>
                    <div class="group-select select-list">
                        <div class="nice-select" tabindex="0">
                            <span class="current"><?php _e('Todos', 'mi'); ?></span>
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
            <div class="form-group-2 form-style">
                <label>Location</label>
                <div class="group-ip">
                    <input type="text" class="form-control" placeholder="Search Location" value="" name="s" title="Search for" required="">
                    <a href="#" class="icon icon-location">
                    </a>
                </div>
            </div>
            <div class="form-group-3 form-style">
                <label>Keyword</label>
                <input type="text" class="form-control" placeholder="Search Keyword." value="" name="s" title="Search for" required="">
            </div>

        </div>
        <div class="box-btn-advanced">
            <button type="submit" class="tf-btn btn-search primary">Search <i class="icon icon-search"></i> </button>
        </div>

    </div>
</form>