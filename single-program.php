<?php
get_header();
while(have_posts()){
    the_post(); 
    pageBanner();
    ?>
   
    </div>  
  </div>
  singleprogram.php
  <div class="container container--narrow page-section">
  <div class="metabox metabox--position-up metabox--with-home-link">
      <p><a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('program');?>">
      <i class="fa fa-home" aria-hidden="true"></i> All Programs</a> 
      <span class="metabox__main"> <?php the_title();?></span></p>
    </div>
      <div class="generic-content"><?php the_content();?></div>
      <?php 
      /** create a custom query to get the Professors related to the program */
        $relatedProfessor = new wp_Query(array(
            'posts_per_page'=> -1,
            'post_type'=>'professor',
            /** using 'meta_key' , 'orderby' for custom query  */
            'orderby'=> 'title',
            'order'=>'ASC',
            /**filters */
            'meta_query'=>array(
                /**2. events for programs */
                array(
                    'key'=>'related_programs',
                    /**LIKE here means contain */
                    'compare'=>'LIKE',
                    /**deseralize the 'related_programs array' array for database */
                    'value'=> '"' . get_the_ID() .'"'
            
                )
            )
        )
        );
        if($relatedProfessor->have_posts()){
            echo '<hr claass="section-break">';
        echo '<h2 class="headline headline--medium">'. get_the_title() .' Professors</h2>';
        echo '<ul class="professor-cards">';
        while($relatedProfessor->have_posts()){
            $relatedProfessor->the_post();?>
                 <li professor-card__list-item>
                     <a class="professor-card" href="<?php the_permalink()?>"><?php the_title()?>
                     <img class="professor-card__image" src="<?php the_post_thumbnail_url();?>" alt="">
                     <span class="professor-card__name"><?php the_title();?></span>
                    </a>
                </li>
        <?php }
        echo '</ul>';
}

        }
        wp_reset_postdata();
       
      /** create a custom query to get the upcoming events that related to the program */
        $today = date('Ymd');
        $homepageEvents = new wp_Query(array(
            'posts_per_page'=> 2,
            'post_type'=>'event',
            /** using 'meta_key' , 'orderby' for custom query  */
            'meta_key'=>'event_date',
            'orderby'=> 'meta_value_num',
            'order'=>'ASC',
            /**filters */
            'meta_query'=>array(
                /** 1.dates after today  */
                array(
                    'key' =>'event_date',
                    'compare'=>'>=',
                    'value'=>$today,
                    'type'=>'numeric'
                ),
                /**2. events for programs */
                array(
                    'key'=>'related_programs',
                    /**LIKE here means contain */
                    'compare'=>'LIKE',
                    /**deseralize the 'related_programs array' array for database */
                    'value'=> '"' . get_the_ID() .'"'
            
                )
            )
        )
        );
        if($homepageEvents->have_posts()){
            echo '<hr claass="section-break">';
        echo '<h2 class="headline headline--medium">Upcoming '. get_the_title() .' Events </h2>';
        while($homepageEvents->have_posts()){
            $homepageEvents->the_post();?>
                 <div class="event-summary">
          <a class="event-summary__date t-center" href="#">
            <span class="event-summary__month"><?php 
            /**using php DateTime object to get the right format for the */
               /*$eventDate = new DateTime(get_field('event_date'));
                echo $eventDate->format('Y-m-d');*/
            ?>
            </span>
            <span class="event-summary__day"></span>  
          </a>
          <div class="event-summary__content">
            <h5 class="event-summary__title headline headline--tiny"><a href="<?php echo the_permalink()?>"><?php the_title();?></a></h5>
            <p><?php  if( has_excerpt()){
                echo get_the_excerpt();
                }
                else{
                    echo wp_trim_words(get_the_content(),18);
                    }?><a href="<?php echo the_permalink()?>" class="nu gray">Learn more</a></p>
          </div>
        </div>
        <?php }
        ?>
    <?php
}

        
get_footer();
?>