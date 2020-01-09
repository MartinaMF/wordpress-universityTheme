<?php
get_header(); 
pageBanner(array(
    'title'=>'All Programs',
    'subtitle' => 'There is somthing for every one have a look around<'
));
?>
archive programs.php
  <div class="container container--narrow page-section">
      <ul class="link-list min-list">
          
    
      <?php
      while(have_posts()){
          the_post(); ?>
         <li><a href="<?php the_permalink();?>"></a><?php the_title();?></li>
         
      <?php }
        echo '</ul>';
      echo paginate_links();
      ?>
      <hr class="section-break">
      <p>Looking for a recap pf past events ? <a href="<?php echo site_url('/past-events')?>">
      Check out our past recap events archive</a></p>
      
</div>
  <?php
get_footer();
?>