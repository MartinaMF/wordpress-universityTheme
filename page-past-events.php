<?php
get_header();
pageBanner(array(
    'title' => 'Past Events',
    'subtitle'=>'Recape of our past events'
));
 ?>
  <div class="container container--narrow page-section">
      <?php
       $today = date('Ymd');
       /** create a custom query to get the upcoming events */
       $pastEvents = new wp_Query(array(
           /** get the page number for pagination  */
           'paged' => get_query_var('paged',1),
           'posts_per_page' => 1,
           'post_type'=>'event',
           /** using 'meta_key' , 'orderby' for custom query  */
           'meta_key'=>'event_date',
           'orderby'=> 'meta_value_num',
           'order'=>'ASC',
           /** dates after today */
           'meta_query'=>array(
               array(
                   'key' =>'event_date',
                   'compare'=>'<',
                   'value'=>$today,
                   'type'=>'numeric'
                   )
           )
       )
       );
      while($pastEvents->have_posts()){
        $pastEvents->the_post(); ?>
          <div class="event-summary">
          <a class="event-summary__date t-center" href="#">
            <span class="event-summary__month">
            <?php 
            /**using php DateTime object to get the right format for the date */
               /* $eventDate = new DateTime(get_field('event_date'));
                echo $eventDate->format('Y-m-d');*/
            ?>
            </span>
            <span class="event-summary__day"></span>  
          </a>
                    <div class="event-summary__content">
                        <h5 class="event-summary__title headline headline--tiny"><a href="<?php the_permalink();?>"><?php the_title();?></a></h5>
                        <p><?php echo wp_trim_words(get_the_content(),18)?><a href="<?php the_permalink();?>" class="nu gray">Read more</a></p>
                    </div>
                </div>
      <?php }
      /**pagination for custom query */
      echo paginate_links(array(
          'total' => $pastEvents->max_num_pages
      ));
      ?>
</div>
  <?php
get_footer();
?>