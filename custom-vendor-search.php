<?php 
/**
 * Template Name: Custom Search
 *
 *
 * @package Martfury
 */


/*if (isset($_GET['ven_search_title'])) {
    $ven_search_title = $_GET['ven_search_title'];
} 
*/
get_header();
?>

<!-- <form action="/custom-search" method="GET">

<div class="search boxes">   
<input type="text" name="ven_search_title" class="customsearch-field" placeholder="Vendor Search" value=""> 
<input type="submit" name="search" value="Search">
</div>

</form> -->

<?php


    if (sanitize_text_field($_GET['ven_search_title']) && sanitize_text_field ($_GET['ven_search_title']))
    {
      $ven_search_title = sanitize_text_field($_GET['ven_search_title']);
    }

	/*global $wpdb;
    $table = $wpdb->prefix . 'users';
    $query = $wpdb->get_results("SELECT user_nicename FROM $table WHERE user_nicename LIKE '".$ven_search_title."'", ARRAY_A);
    
    foreach ($query as $value) {
         echo $value['user_nicename'];
     }*/
  
    $user_nicename = sanitize_text_field($_GET['ven_search_title']);
    $user = get_user_by('slug', $user_nicename); 
    //$user = get_user_meta('slug', $user_nicename); 
    

    /*if ($user) {
        // user found, get the user information
        $user_id = $user->ID;
        $user_first_name = $user->first_name;
        $user_last_name = $user->last_name;
        $user_login = $user->user_login;
        $user_email = $user->user_email;
        $user_display_name = $user->display_name;
        

        // do something with the user information
        echo "User ID: " . $user_id . "<br>";
        echo "User First Name: " . $user_first_name . "<br>";
        echo "User Last Name: " . $user_last_name . "<br>";
        echo "User Login: " . $user_login . "<br>";
        echo "User Email: " . $user_email . "<br>";
        echo "User Display Name: " . $user_display_name . "<br>";
        echo "user image :" . get_avatar($user->ID)."<br>";
       print_r(get_user_meta($user->ID,'dokan_profile_settings', true)['phone']);
       print_r(get_user_meta($user->ID,'dokan_store_name', true));
       $profile_setting=(get_user_meta( $user->ID, 'dokan_profile_settings' , true )['address']);
       print_r( $profile_setting['street_1'].'&nbsp'.
                 $profile_setting['street_2'].'&nbsp'.
                 $profile_setting['city']
        );
    } else {
       
        echo "Vendor Not Found";
    }*/
    
    /*$all_meta_for_user = get_user_meta(2);
    echo "<pre>";
    print_r( $jason=$all_meta_for_user['dokan_profile_settings']);
       
    print_r(get_user_by('slug',store));
    print_r(get_userdata(3));
    echo "</pre>";*/

   
  $store_user = dokan()->vendor->get( get_query_var( 'author' ) );
  $store_user->get_id();
  
  //echo "<pre>";
  //print_r (get_user_meta( $user->ID, '' , true ));
  //echo "<pre>";
?>


<?php 
if ($user) {
  $user_nicename = sanitize_text_field($_GET['ven_search_title']);
  $user = get_user_by('slug', $user_nicename);   
  $profile_setting=(get_user_meta( $user->ID, 'dokan_custom_city_field' , true ));
?>
<div class="store-wrappers"> 
    <div class="seller-avatar"><?php echo get_avatar($user->ID) ?></div>
    <div class="storebody">
      <div class="search_title"><span>Store Name:</span> <?php print_r(get_user_meta($user->ID,'dokan_store_name', true)); ?> </div> 
        <div class="search_title"><span>Full Name:</span> <?php print_r(get_user_meta($user->ID,'first_name', true)); ?> 
      <?php print_r(get_user_meta($user->ID,'last_name', true)); ?> </div> 
      <div class="search_title"><span>Location: </span><?php print_r( $profile_setting);?> </div>
      <div class="search_title"> <a href="<?php echo bloginfo('url').'/store/'.get_user_meta($user->ID,'dokan_store_name', true)?>">Follow </a> </div>
     
    </div>
   
  <?php 
  //echo "<pre>";
   //print_r(get_user_meta($user->ID, '' , true));
  //echo "</pre>";
  ?>    
<div style="clear:both;"></div>  
</div>

<?php  } else {
        // user not found
        echo "Vendor Not Found";
    }
?>



<?php
get_footer();
?>