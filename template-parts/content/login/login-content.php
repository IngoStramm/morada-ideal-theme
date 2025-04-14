<section class="flat-section flat-contact">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-8 col-lg-10 col-md-12 col-offset-2">

                <?php if (!is_user_logged_in()) { ?>
                    <?php get_template_part('template-parts/content/login', 'form'); ?>
                <?php } else { ?>
                    <?php get_template_part('template-parts/content/logged-in'); ?>
                <?php } ?>

            </div>
        </div>
    </div>
</section>