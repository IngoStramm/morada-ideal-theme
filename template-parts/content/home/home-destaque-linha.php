<?php
$reverse_class = isset($args['reverse']) && $args['reverse'] ? 'destaque-linha-reverse' : false;
?>
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="destaque-linha <?php echo $reverse_class; ?>">
                <div class="destaque-linha-left"></div>
                <div class="destaque-linha-middle"></div>
                <div class="destaque-linha-right"></div>
            </div>
        </div>
    </div>
</div>