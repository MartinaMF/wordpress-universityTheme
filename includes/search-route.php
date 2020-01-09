<?php
//create our own custom rest API
add_action('rest_api_init', 'mywebsiteRegisterSearch');
function mywebsiteRegisterSearch(){
    register_rest_route('amazingtheme/v1', 'search', array(
        //this is another way of saying 'get' to make sure it is working in all browsers
        'method' => WP_REST_SERVER::READABLE,
        'callback'=>'mywebsiteSearchResults'
    ));
}
function mywebsiteSearchResults($data){
    //create a custom Query to get all match results from all post types that match 'term'
    $mainQuery = new wp_Query(array(
        'post_type' => array('post','page','professor','program','campus','event'),
        //using sanitize_text_field() function for security
        's' => sanitize_text_field($data['term'])
    ));
    $Results = array(
        'generalInfo' =>array(),
        'professors' =>array(),
        'programs' =>array(),
        'events' =>array(),
        'campuses' =>array()
    );
    while($mainQuery->have_posts()){
        $mainQuery->the_post();
        if(get_post_type() == 'post' || get_post_type() == 'page' ){
             //array_push() is a wordpress function
            array_push($Results['generalInfo'], array(
            'title' => get_the_title(),
            'permalink' => get_the_permalink(),
            'postType'=> get_post_type(),
            'authorName'=>get_the_author()
        ));
        }
        if(get_post_type() == 'professor'){
            //array_push() is a wordpress function
           array_push($Results['professors'], array(
           'title' => get_the_title(),
           'permalink' =>get_the_permalink(),
           'image' =>get_the_post_thumbnail_url()
       ));
       }
       if(get_post_type() == 'campus'){
        //array_push() is a wordpress function
       array_push($Results['campuses'], array(
       'title' => get_the_title(),
       'permalink' =>get_the_permalink()
        ));
        }
        if(get_post_type() == 'event' ){
            $eventDate = new DateTime(get_field('event_date'));
            $description = NULL;
            if( has_excerpt()){
            $description  = get_the_excerpt();
            }
            else{
                $description  = wp_trim_words(get_the_content(),18);
                }
            //array_push() is a wordpress function
        array_push($Results['events'], array(
        'title' => get_the_title(),
        'permalink' =>get_the_permalink(),
        'month'=>$eventDate->format('M'),
        'day'=>$eventDate->format('d'),
        'description' => $description
        ));
        }
        if(get_post_type() == 'program'){
            //array_push() is a wordpress function
        array_push($Results['programs'], array(
        'title' => get_the_title(),
        'permalink' =>get_the_permalink(),
        'id'=>get_the_id()
        ));
        }
       
    }
    ///create a custom related query to get professors related to certan program
    $programRelationshipQuery = new wp_Query(array(array(
        'post_type' =>'professor',
        'meta_query' => array(
            array(
                'key' =>'related_programs',
                'compare'=>'LIKE',
                'value'=>'"'. $Results['programs'][0][id] . '"'
            )
        )
    )
    )); 
    while($programRelationshipQuery->have_posts()){
        $programRelationshipQuery->the_post();

        if(get_post_type() == 'professor'){
            //array_push() is a wordpress function
           array_push($Results['professors'], array(
           'title' => get_the_title(),
           'permalink' =>get_the_permalink(),
           'image' =>get_the_post_thumbnail_url()
       ));
       }

    }
    return $Results;
}
?>