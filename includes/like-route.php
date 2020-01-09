<?php
add_action('res_api_init','mywebsiteLikeRoutes');
function mywebsiteLikeRoutes(){
    //respond for post request
    register_rest_rout('mywebsite/v1','manageLike',array(
        'method'=>'POST',
        'callback'=>'createLike'
    ));
    //responde for delete request
    register_rest_rout('mywebsite/v1','manageLike',array(
        'method'=>'DELET',
        'callback'=>'deleteLike'
    ));
}
function createLike(){
    wp_insert_post(array(
        'post_type'=>'like',
        'post_status'=>'publish',
        'post_title'=>'Our PHP Create Post Test',
        'post_content'=>'Hello world 123'
    ));
}
function deleteLike(){
 return 'thanks for delete';
}

