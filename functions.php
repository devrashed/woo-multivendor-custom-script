<?php
add_action( 'wp_enqueue_scripts', 'martfury_child_enqueue_scripts', 20 );
function martfury_child_enqueue_scripts() {
	wp_enqueue_style( 'martfury-child-style', get_stylesheet_uri() );
	if ( is_rtl() ) {
		wp_enqueue_style( 'martfury-rtl', get_template_directory_uri() . '/rtl.css', array(), '20180105' );
	}
   wp_enqueue_style( 'survey-css', get_template_directory_uri() . '-child/survey.css', array(), '20180105' );    	
   
   wp_enqueue_script( 'Qrcode-genaretor', 'https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js', 0.122, true );
   
   wp_enqueue_script( 'dp_custom-script', get_template_directory_uri() . '-child/dp_custom_script.js', array( 'jquery' ), '20181210', true );
   
   wp_localize_script( 'dp_custom-script', 'dp_ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
}

//require_once 'sales-chart-widget.php';

 
// ******* Vendor Personal Email ******//
add_action('wp_ajax_vendor_personal_email', 'vendor_personal_email');
add_action('wp_ajax_nopriv_vendor_personal_email', 'vendor_personal_email');

function vendor_personal_email() {
    $name    = $_REQUEST['dp_name'];
    $email   = $_REQUEST['dp_email'];
    $message = $_REQUEST['dp_message']; 
    $to      = $_REQUEST['dp_owner'];
    
    $subject = "Query about your product";
    $message = "Senders Email :".$email."\r\n Name:".$name."\r\n Message:".$message;
    $from    = $name . '<>' . $email;
    $header .= "Cc:impulse.khan@gmail.com \r\n";
	$header .= "MIME-Version: 1.0\r\n";
	$header .= "Content-type: text/html\r\n";
    $retval  = mail($to, $subject, $message, $header);
    //$retval;
    ///$rdata = array();
    if ($retval == true ) {
        echo "Message sent successfully";
        //$rdata['message'] = 'Message sent successfully...';
        //$rdata['status'] = true;
    }else {
        echo "Message could not be sent";
        //$rdata['message'] = 'Message could not be sent...';
        //$rdata['status'] = false;
    }
    wp_die();
    //return $rdata;
    
    //echo "Message sent successfully...";
   // wp_die();
}




// ******* Survey form  to Email ******//

add_action('wp_ajax_vendor_survey_form', 'vendor_survey_email');
add_action('wp_ajax_nopriv_vendor_survey_form', 'vendor_survey_email');

function vendor_survey_email() {
    
    $trate1 = $_REQUEST['timeliness'];
    $crate1 = $_REQUEST['courtesy'];
    $qrate1 = $_REQUEST['quality'];
 
    $name = $_REQUEST['sv_name'];
    $email = $_REQUEST['sv_email'];
    $message = $_REQUEST['sv_message'];
    $storename = $_REQUEST['sv_storename'];
    $to = $_REQUEST['sv_vendor'];
    
    $subject = "Survey Report of Vendor";
    $message = "Senders Email :".$email."</br>Name: ".$name."\r\n Survey qusttions Timeliness: ".$trate1."\r\n Courtesy: ".$crate1."\r\n quality of service: ".$qrate1." \r\n Message: ".$message;
    $from    = $name . '<>' . $email;
    $header .= "Cc:impulse.khan@gmail.com \r\n";
	$header .= "MIME-Version: 1.0\r\n";
	$header .= "Content-type: text/html\r\n";
    $retval  = mail($to, $subject, $message, $header);

    if ($retval == true ) {
        echo "Message sent successfully";
        //$rdata['message'] = 'Message sent successfully...';
        //$rdata['status'] = true;
    }else {
        echo "Message could not be sent";
        //$rdata['message'] = 'Message could not be sent...';
        //$rdata['status'] = false;
    }
    wp_die();  
    //return $rdata;
    
    //echo "Message sent successfully...";
       
}
?>


<?php 
add_filter( 'dokan_query_var_filter', 'dokan_load_document_menu' );
function dokan_load_document_menu( $query_vars ) {
    $query_vars['help'] = 'help';
    return $query_vars;
}
add_filter( 'dokan_get_dashboard_nav', 'dokan_add_help_menu' );
function dokan_add_help_menu( $urls ) {
    $urls['help'] = array(
        'title' => __( 'Visiting', 'dokan'),
        'icon'  => '<i class="fa fa-user"></i>',
        //'url'   => dokan_get_navigation_url( 'help' ),
        'url'   => dokan_get_navigation_url( 'https://www.multivendor.dizmak.com/product/red-bycle'),
        'pos'   => 51
    );
    return $urls;
}
add_action( 'dokan_load_custom_template', 'dokan_load_template' );
function dokan_load_template( $query_vars ) {
    if ( isset( $query_vars['help'] ) ) {
        require_once dirname( __FILE__ ). '/help.php';
       }
}
?>

<?php 



/*====== Dokan Custom Registration field ===*/

function dokan_custom_seller_registration_required_fields( $required_fields ) {

    //$required_fields['gst_id'] = __( 'Please enter your GST number', 'dokan-custom' );
    $required_fields['street_1'] = __( 'Please enter Street Address', 'dokan-custom' );
    $required_fields['city'] = __( 'Please enter City Name', 'dokan-custom' );
    $required_fields['zip'] = __( 'Please enter Zip  Code', 'dokan-custom' );
    $required_fields['billing_country'] = __( 'Please enter Country Name', 'dokan-custom' );
    $required_fields['billing_state'] = __( 'Please enter State Name', 'dokan-custom' );
    $required_fields['dk_status'] = __( '', 'dokan-custom' );


    return $required_fields;
};

add_filter( 'dokan_seller_registration_required_fields', 'dokan_custom_seller_registration_required_fields' );


function dokan_custom_new_seller_created( $vendor_id, $dokan_settings ) {
    $post_data = wp_unslash( $_POST );

    $street_1 =  $post_data['street_1'];
    $street_2 =  $post_data['street_2'];
    $city =  $post_data['city'];
    $zip =  $post_data['zip'];
    $billing_country =  $post_data['billing_country'];
    $billing_state =  $post_data['billing_state'];
    $dk_status =  $post_data['dk_status'];
    

    $gst_id =  $post_data['gst_id'];
   
    //update_user_meta( $vendor_id, 'dokan_custom_gst_id', $gst_id );
   
    update_user_meta( $vendor_id, 'dokan_custom_street_1_field', $street_1 );
    update_user_meta( $vendor_id, 'dokan_custom_street_2_field', $street_2 );
    update_user_meta( $vendor_id, 'dokan_custom_city_field', $city );
    update_user_meta( $vendor_id, 'dokan_custom_zip_field', $zip );
    update_user_meta( $vendor_id, 'dokan_custom_country_field', $billing_country );
    update_user_meta( $vendor_id, 'dokan_custom_state_field', $billing_state );
    update_user_meta( $vendor_id, 'rsmembers_status', $dk_status );
}

add_action( 'dokan_new_seller_created', 'dokan_custom_new_seller_created', 10, 2 );




/* =====  User information Update in dashboard ====== */


add_action( 'dokan_seller_meta_fields', 'my_show_extra_profile_fields' );

function my_show_extra_profile_fields( $user ) { ?>

    <?php if ( ! current_user_can( 'manage_woocommerce' ) ) {
            return;
        }
        if ( ! user_can( $user, 'dokandar' ) ) {
            return;
        }
         
         $street_1  = get_user_meta( $user->ID, 'dokan_custom_street_1_field', true );
         $street_2  = get_user_meta( $user->ID, 'dokan_custom_street_2_field', true );
         $dok_city  = get_user_meta( $user->ID, 'dokan_custom_city_field', true );
         $dok_zip  = get_user_meta( $user->ID, 'dokan_custom_zip_field', true );
         $dok_coutry  = get_user_meta( $user->ID, 'dokan_custom_country_field', true );
         $dok_state  = get_user_meta( $user->ID, 'dokan_custom_state_field', true );
     ?>

       <h3> Dokan </h3>



         <tr>
                <th><?php esc_html_e( 'Streat Address 1', 'dokan-lite' ); ?></th>
                <td>
                    <input type="text" name="street_1" class="regular-text" value="<?php echo esc_attr($street_1); ?>"/>
                </td>
         </tr>

          <tr>
                <th><?php esc_html_e( 'Streat Address 2', 'dokan-lite' ); ?></th>
                <td>
                    <input type="text" name="street_2" class="regular-text" value="<?php echo esc_attr($street_2); ?>"/>
                </td>
         </tr>

         <tr>
                <th><?php esc_html_e( 'City', 'dokan-lite' ); ?></th>
                <td>
                    <input type="text" name="dok_city" class="regular-text" value="<?php echo esc_attr($dok_city); ?>"/>
                </td>
         </tr>

         <tr>
                <th><?php esc_html_e( 'Zip', 'dokan-lite' ); ?></th>
                <td>
                    <input type="text" name="dok_zip" class="regular-text" value="<?php echo esc_attr($dok_zip); ?>"/>
                </td>
         </tr>

         <tr>
                <th><?php esc_html_e( 'Country', 'dokan-lite' ); ?></th>
                <td>
                    <input type="text" name="dok_coutry" class="regular-text" value="<?php echo esc_attr($dok_coutry); ?>"/>
                </td>
         </tr>

         <tr>
                <th><?php esc_html_e( 'State', 'dokan-lite' ); ?></th>
                <td>
                    <input type="text" name="dok_state" class="regular-text" value="<?php echo esc_attr($dok_state); ?>"/>
                </td>
         </tr>

    <?php
 }

add_action( 'personal_options_update', 'my_save_extra_profile_fields' );
add_action( 'edit_user_profile_update', 'my_save_extra_profile_fields' );

function my_save_extra_profile_fields( $user_id ) {

if ( ! current_user_can( 'manage_woocommerce' ) ) {
            return;
        
         update_usermeta( $user_id, 'dokan_custom_street_1_field', $_POST['street_1'] );
         update_usermeta( $user_id, 'dokan_custom_street_2_field', $_POST['street_2'] );
         update_usermeta( $user_id, 'dokan_custom_city_field', $_POST['dok_city'] );
         update_usermeta( $user_id, 'dokan_custom_zip_field', $_POST['dok_zip'] );
         update_usermeta( $user_id, 'dokan_custom_country_field', $_POST['dok_coutry'] );
         update_usermeta( $user_id, 'dokan_custom_state_field', $_POST['dok_state'] );
  }
  
}

/*====== Redirect  user ======*/

function dok_registration_redirect() {
    wp_logout();
    return home_url('/redirect-registration');
}
add_action('woocommerce_registration_redirect', 'dok_registration_redirect', 2);


/*====== Search Shortcode ======*/

function vendor_search(){
?>
    <form action="/custom-search" method="GET">
			<div class="search boxes">   
			<input type="text" name="ven_search_title" class="customsearch-field" placeholder="Vendor Search" value=""> 
			<button class="vendor_search" type="submit" title="Search" aria-label="Search">
			   <i aria-hidden="true" class="fas fa-search"></i>							
			   <span class="elementor-screen-only">Search</span>
			</button>
			</div>

	</form>
    
<?php     
}
add_shortcode('custom_vendor_search','vendor_search');
?>