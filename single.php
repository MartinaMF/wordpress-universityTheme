<?php
get_header();
while(have_posts()){
    the_post(); 
    pageBanner();
    ?>
 single.php
  <div class="container container--narrow page-section">
  <div class="metabox metabox--position-up metabox--with-home-link">
      <p><a class="metabox__blog-home-link" href="<?php echo site_url('/Blog')?>">
      <i class="fa fa-home" aria-hidden="true"></i> Blog Home</a> 
      <span class="metabox__main">posted by <?php the_author_posts_link();?> on <?php the_time('D.M.Y')?> in 
                  <?php echo get_the_category_list(',');
                  ?></span></p>
    </div>
      <div class="generic-content"><?php the_content();?></div>
    <?php
}
get_footer();
?>