<?php
get_header();
while(have_posts()){
    the_post(); 
    pageBanner();
    ?>
    singel professor.php
  <div class="container container--narrow page-section">
  
      <div class="generic-content">
          <div class="row group">
          <div class="one-third">
              <?php the_post_thumbnail();?>
          </div>
          <div class="two-third">
              <?php the_content();?>
          </div>
          </div>
    </div>
      <?php 
      /** our advanced custom fiel plugin is what gives us access to 'get_field() method' */
        $relatedPrograms = get_field('related_programs');
        if($relatedPrograms){
        ?>
        <hr class="section-break">
        <h2 class="headline headline--medium">Supject(s) taught</h2>
       <ul class="link-list headline--dedium">
        <?php 
        foreach($relatedPrograms as $program){?>
        <li><a href=" <?php echo get_the_permalink($program)?>"><?php echo get_the_title($program);?></a></li>
        </ul>
        <?php }
        }
      ?>
    </div>
    <?php
}
get_footer();
?>