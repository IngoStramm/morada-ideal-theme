<?php
$post_id = get_the_ID();
$blogposts = mi_get_blogposts();
if ($blogposts && count($blogposts) > 0) {
    $blogpost_title = get_post_meta($post_id, 'home_destaque_4_title', true);
    $blogpost_content = get_post_meta($post_id, 'home_destaque_4_content', true);
    $blogpost_selo = get_post_meta($post_id, 'home_destaque_4_selo', true);
?>
    <section class="flat-section blog-latest-posts">
        <div class="container">
            <div class="row">
                <div class="col-md-12 mb-5 d-flex align-items-center justify-content-between gap-20">
                    <div>
                        <?php if ($blogpost_title) { ?>
                            <h3 class="blog-latest-posts-title"><?php echo $blogpost_title; ?></h3>
                        <?php } ?>
                        <?php if ($blogpost_content) { ?>
                            <div class="blog-latest-posts-content"><?php echo wpautop($blogpost_content); ?></div>
                        <?php } ?>
                    </div>
                    <?php if ($blogpost_selo) { ?>
                        <img class="blog-latest-posts-selo" src="<?php echo $blogpost_selo; ?>">
                    <?php } ?>
                </div>
            </div>
            <div dir="ltr" class="swiper tf-sw-latest wow fadeInUp" data-wow-delay=".2s" data-preview="3" data-tablet="2" data-mobile-sm="2" data-mobile="1" data-space-lg="30" data-space-md="15" data-space="15">
                <div class="swiper-wrapper">
                    <?php foreach ($blogposts as $blogpost_id => $blogpost) { ?>
                        <div class="swiper-slide">
                            <a href="<?php echo $blogpost->link; ?>" class="flat-blog-item hover-img" target="_blank">
                                <div class="img-style">
                                    <img class="lazyload" data-src="<?php echo $blogpost->media; ?>" src="<?php echo $blogpost->media; ?>" alt="img-blog">
                                    <?php if ($blogpost->cats && count($blogpost->cats) > 0) { ?>
                                        <span class="date-post">
                                            <?php
                                            $count = 0;
                                            foreach ($blogpost->cats as $cat) {
                                                $sep = $count > 0 && $count < count($blogpost->cats) ? ', ' : '';
                                                echo $sep . $cat;
                                                $count++;
                                            } ?>
                                        </span>
                                    <?php } ?>
                                </div>
                                <div class="content-box">
                                    <div class="post-author">
                                    </div>
                                    <?php // mi_debug($blogpost); 
                                    ?>
                                    <h5 class="title link"><?php echo $blogpost->title->rendered; ?></h5>
                                    <p class="description"><?php echo $blogpost->excerpt->rendered; ?></p>
                                </div>

                            </a>
                        </div>
                    <?php } ?>
                </div>
                <div class="sw-pagination sw-pagination-latest text-center"></div>
            </div>
        </div>
    </section>
<?php } ?>