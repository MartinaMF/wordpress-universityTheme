<?php
require get_theme_file_path('/includes/search-route.php');
//adding new new items to our rest api
function mywebsite_custom_rest_api(){
  register_rest_field('post','authorName', array(
    'get_callback' => function() {return get_the_author();}
  ));
}
add_action('rest_api_init','mywebsite_custom_rest_api');
function pageBanner($args = NULL){
    if(!$args['title']){
        $args['title'] = get_the_title();
    }
    if(!$args['subtitle']){
        $args['subtitle']= get_field('page_baner_subtitle');
    }
    if(!$args['photo']){
        if(get_field('page_baner_backgroung_image')){
            $args['photo'] = get_field('page_baner_backgroung_image')['url'];
        }
        else{
            $args['photo'] = get_theme_file_uri('./images/ocean.jpg');
        }
    }
    ?>
     <div class="page-banner">
    <div class="page-banner__bg-image" style="background-image: url(<?php echo  $args['photo']?>?>"></div>
    <div class="page-banner__content container container--narrow">
      <h1 class="page-banner__title"><?php echo $args['title']?></h1>
      <div class="page-banner__intro">
        <p><?php echo $args['subtitle']?></p>
      </div>
    </div>  
  </div>
<?php }
function mywebsite_files(){
    wp_enqueue_script('mywebsite_main-js' ,get_theme_file_uri('/js/scripts-bundled.js'),NULL,microtime(),true);
    wp_enqueue_style('mywebsite_main_style',get_stylesheet_uri(),NULL,microtime());
    wp_enqueue_style('custom-google-font','//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
    wp_enqueue_style('font-awesome','//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
    wp_localize_script('mywebsite_main-js','mywebsiteData',array(
      'root_url' => get_site_url(),
      // create session for logged in user
      'nonce' => wp_create_nonce('wp_rest')
    ));
}
add_action('wp_enqueue_scripts','mywebsite_files');

function mywebsite_features(){
    /**generate a title tage for each screen  */
    add_theme_support('title-tag');
    /**enable feature image */
    add_theme_support('post-thumbnails');
    /**add image size */
    //add_iamge_size('professorLandscape', 400 ,260, true);
    //add_image_size('professorPortrait', 480 ,650, true);
    /**add nav menu */
    register_nav_menu('headerMenuLocation', 'Header Menu Location');
    register_nav_menu('footerLocationOne','footer Location One');
    register_nav_menu('FooterLocationTwo', 'Footer Location Two');
}
add_action('after_setup_theme','mywebsite_features');
/** minpulate the default Query  */
function mywebsite_adjust_queries($query){
    if(!is_admin() and is_post_type_archive('program') and $query->is_main_query()){
        $query->set('orderby','title');
        $query->set('order','ASC');
        $query->set('posts_per_page',-1);

    }
    /** use this only if the post type is event and just for the front end */
  if(!is_admin() and is_post_type_archive('event') and $query->is_main_query()){
    $today = date('Ymd');
    $query->set('meta_key','event_date');
    $query->set('orderby','meta_value_num');
    $query->set('order','ASC');
    $query->set('meta_query',array(
        array(
            'key' =>'event_date',
            'compare'=>'>=',
            'value'=>$today,
            'type'=>'numeric'
            )
    ));
  }
}
add_action('pre_get_posts','mywebsite_adjust_queries');

function myMapKey($api){
$api['key'] = 'AIzaSyC2YSH3ccrWUIsDVWubhWsziQRmIglqeRA';
return $api;
}
add_filter('acf/fields/google_map/api', 'myMapKey');
//Redirect subscriber accounts out of admin and onto homepage
add_action('admin_init', 'redirectSubsToFrontpage');  

function redirectSubsToFrontpage (){
  $CurrentUser = wp_get_current_user();
  if(count($CurrentUser->roles) == 1 && $CurrentUser->roles[0] == 'subscriber'){
    wp_redirect(site_url('/'));
    exit;
  }
}
//hide the admin bar in case of suscriber
add_action('wp_loaded', 'noSubsAdminBar');  

function noSubsAdminBar (){
  $CurrentUser = wp_get_current_user();
  if(count($CurrentUser->roles) == 1 && $CurrentUser->roles[0] == 'subscriber'){
    show_admin_bar(false);
  }
}
//Customize Login Screen
add_filter('login_headerurl', 'ourHeaderUrl');

function ourHeaderUrl(){
  return esc_url(site_url('/'));
}
add_action('login_enqueue_scripts', 'ourLoginCSS');
function ourLoginCSS(){
  wp_enqueue_style('mywebsite_main_style',get_stylesheet_uri(),NULL,microtime());
  wp_enqueue_style('custom-google-font','//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
}
add_filter('login_heeadertitle', 'ourLoginTitle');

function ourLoginTitle(){
  return get_bloginfo('name');
}
?>