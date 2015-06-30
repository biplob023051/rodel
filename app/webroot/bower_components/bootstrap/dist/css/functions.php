<?php
/**
 * Spacious functions related to defining constants, adding files and WordPress core functionality.
 *
 * Defining some constants, loading all the required files and Adding some core functionality.
 * @uses add_theme_support() To add support for post thumbnails and automatic feed links.
 * @uses register_nav_menu() To add support for navigation menu.
 * @uses set_post_thumbnail_size() To set a custom post thumbnail size.
 *
 * @package ThemeGrill
 * @subpackage Spacious
 * @since Spacious 1.0
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 700;

add_action( 'after_setup_theme', 'spacious_setup' );
/**
 * All setup functionalities.
 *
 * @since 1.0
 */
if( !function_exists( 'spacious_setup' ) ) :
function spacious_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 */
	load_theme_textdomain( 'spacious', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );

	// This theme uses Featured Images (also known as post thumbnails) for per-post/per-page.
	add_theme_support( 'post-thumbnails' );
 
	// Registering navigation menus.
	register_nav_menus( array(	
		'primary' 	=> 'Primary Menu',
		'footer' 	=> 'Footer Menu'
	) );

	// Cropping the images to different sizes to be used in the theme
	add_image_size( 'featured-blog-large', 750, 350, true );
	add_image_size( 'featured-blog-medium', 270, 270, true );
	add_image_size( 'featured', 642, 300, true );
	add_image_size( 'featured-blog-medium-small', 230, 230, true );	

	// Setup the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'spacious_custom_background_args', array(
		'default-color' => 'eaeaea'
	) ) );

	// Adding excerpt option box for pages as well
	add_post_type_support( 'page', 'excerpt' );
}
endif;

/**
 * Define Directory Location Constants 
 */
define( 'SPACIOUS_PARENT_DIR', get_template_directory() );
define( 'SPACIOUS_CHILD_DIR', get_stylesheet_directory() );

define( 'SPACIOUS_INCLUDES_DIR', SPACIOUS_PARENT_DIR. '/inc' );	
define( 'SPACIOUS_CSS_DIR', SPACIOUS_PARENT_DIR . '/css' );
define( 'SPACIOUS_JS_DIR', SPACIOUS_PARENT_DIR . '/js' );
define( 'SPACIOUS_LANGUAGES_DIR', SPACIOUS_PARENT_DIR . '/languages' );

define( 'SPACIOUS_ADMIN_DIR', SPACIOUS_INCLUDES_DIR . '/admin' );
define( 'SPACIOUS_WIDGETS_DIR', SPACIOUS_INCLUDES_DIR . '/widgets' );

define( 'SPACIOUS_ADMIN_IMAGES_DIR', SPACIOUS_ADMIN_DIR . '/images' );
define( 'SPACIOUS_ADMIN_CSS_DIR', SPACIOUS_ADMIN_DIR . '/css' );


/** 
 * Define URL Location Constants 
 */
define( 'SPACIOUS_PARENT_URL', get_template_directory_uri() );
define( 'SPACIOUS_CHILD_URL', get_stylesheet_directory_uri() );

define( 'SPACIOUS_INCLUDES_URL', SPACIOUS_PARENT_URL. '/inc' );
define( 'SPACIOUS_CSS_URL', SPACIOUS_PARENT_URL . '/css' );
define( 'SPACIOUS_JS_URL', SPACIOUS_PARENT_URL . '/js' );
define( 'SPACIOUS_LANGUAGES_URL', SPACIOUS_PARENT_URL . '/languages' );

define( 'SPACIOUS_ADMIN_URL', SPACIOUS_INCLUDES_URL . '/admin' );
define( 'SPACIOUS_WIDGETS_URL', SPACIOUS_INCLUDES_URL . '/widgets' );

define( 'SPACIOUS_ADMIN_IMAGES_URL', SPACIOUS_ADMIN_URL . '/images' );
define( 'SPACIOUS_ADMIN_CSS_URL', SPACIOUS_ADMIN_URL . '/css' );

/** Load functions */
require_once( SPACIOUS_INCLUDES_DIR . '/custom-header.php' );
require_once( SPACIOUS_INCLUDES_DIR . '/functions.php' );
require_once( SPACIOUS_INCLUDES_DIR . '/header-functions.php' );

require_once( SPACIOUS_ADMIN_DIR . '/meta-boxes.php' );		

/** Load Widgets and Widgetized Area */
require_once( SPACIOUS_WIDGETS_DIR . '/widgets.php' );

/**
 * Adds support for a theme option.
 */
if ( !function_exists( 'optionsframework_init' ) ) {
	define( 'OPTIONS_FRAMEWORK_DIRECTORY', get_template_directory_uri() . '/inc/admin/options/' );
	require_once( SPACIOUS_ADMIN_DIR . '/options/options-framework.php' );
	require_once( SPACIOUS_PARENT_DIR . '/options.php' );
}



add_filter( 'wp_mail_content_type', 'set_content_type' );
function set_content_type( $content_type ){
	return 'text/html';
}

function call_my_ajax()
{
	Global $wpdb;
	$case=$_POST['postfunction'];
    if($case=='Updatepermittable')
	{
      
              $lotid=$_POST['lotid'];
              $permitno=$_POST['permitno'];
              $status_id=$_POST['status_id'];         
            $customerappid=$_POST['customer_app_id'];         
			if($status_id==13)
			{
                  $sdsql="update permit_number_generator set temp_active=2,active=2 where lot_id='$lotid' && permit_no in('$permitno')";
                  $res=$wpdb->get_results($sdsql);
                  $permo=explode(',',$permitno);
                  $count=sizeof($permo);
				  $sqlsql2="select permit_no from permit_number_generator where lot_id='$lotid' order by permit_no desc limit 0,1";
				  $res2=$wpdb->get_results($sqlsql2);
                  $start=0;
		           while(list($key,$val)=each($res2))
				   {
						  $start=$val->permit_no;
				   }
                   for($i=0;$i<$count;++$i)
				   {
                          ++$start;
                          $sqlsql3="insert into permit_number_generator(lot_id,permit_no,temp_active,active,created_at) values('$lotid','$start',0,0,NOW());";
                          $wpdb->query($sqlsql3);
                    }
					
					$sdsql="delete from customer_permit_no where customer_app_id='$customerappid'";
                    $wpdb->query($sdsql);
				 
				 
                    exit;
            }
			else if($status_id!=8 && $status_id!=6)
			{
			     $sdsql="update permit_number_generator set temp_active=0,active=0 where lot_id='$lotid' && permit_no in('$permitno')";
                 $res=$wpdb->get_results($sdsql);
				 
				 
				 $sdsql="delete from customer_permit_no where customer_app_id='$customerappid'";
                 $wpdb->query($sdsql);
				 
				 
                 exit;

			 }
     }
	else if($case=='UpdateLotInformation')
	{

		$lotid=$_POST['lotid'];
		$permittypeid=$_POST['permittypeid'];
		$sdsql="select * from parking_lot_details where parking_lot_id=$lotid";
		$arrLotDetails=$wpdb->get_results($sdsql);	
		while(list($key,$val)=each($arrLotDetails))
		{
			$arrLots[$val->parking_lot_type_id]=array('permitid'=>$val->parking_lot_type_id, 'permit_space'=>$val->permit_spaces,
				'permit_duration'=>$val->parking_lot_daurations,
                                'permit_duration2'=>$val->parking_lot_daurations2,
				'permit_rate'=>money_format('%.2n',$val->applicable_rate),
                                'permit_rate2'=>money_format('%.2n',$val->applicable_rate2),
				'permit_lot_active'=>$val->lot_active);
		}
		print_r(json_encode($arrLots));exit;
	}
   else if($case=='permitfeeduration')
	{

		$lotid=$_POST['lotid'];
		$permittype=$_POST['permittype'];
		 $sqlid="select parking_lot_type_master_id from parking_type_master where parking_lot_type='$permittype'";
		 $arrayvalue=$wpdb->get_results($sqlid);
		$sdsql="select * from parking_lot_details where parking_lot_id=$lotid and parking_lot_type_id='".$arrayvalue[0]->parking_lot_type_master_id."'";

		$arrLotDetails=$wpdb->get_results($sdsql);	
		while(list($key,$val)=each($arrLotDetails))
		{
			$arrLots[$val->parking_lot_type_id]=array('permitid'=>$val->parking_lot_type_id,
				'permit_duration'=>$val->parking_lot_daurations,
                                'permit_duration2'=>$val->parking_lot_daurations2,
				'permit_rate'=>money_format('%.2n',$val->applicable_rate),
                                'permit_rate2'=>money_format('%.2n',$val->applicable_rate2),
				);
		}
		print_r(json_encode($arrLots));exit;
	}
	else if($case=='GetLotPermitType')
	{
		$lotid=$_POST['lotid'];
		//$permittypeid=$_POST['permittypeid'];
		$sdsql="select * from parking_lot_details,parking_type_master where parking_type_master.parking_lot_type_master_id=parking_lot_details.parking_lot_type_id and parking_lot_id=$lotid";
		$arrLotDetails=$wpdb->get_results($sdsql);	

		$html='';
		while(list($key,$val)=each($arrLotDetails))
		{
			$html.='<option value="'.strtolower($val->parking_lot_type).'">'.$val->parking_lot_type.'</option>';
		}
		print_r($html);exit;
	}
	else if($case=='GenratePermitNo')
	{
		$norequired=$_POST['noofpermit'];
		$cusomter_app_id=(int)$_POST['cusomter_app_id'];
		$permitype=(int)$_POST['permtype'];
		$intlotid=(int)$_POST['intlotid'];

		$sdsql="select MIN(permit_no) as numCount from permit_number_generator where temp_active=0 and active=0 and lot_id=$intlotid";
		$startno=$wpdb->get_results($sdsql);	
		$startno=$startno[0]->numCount;

		$updatenewno=$norequired + $startno;

		for($startno;$startno<$updatenewno;$startno++)
		{
			$sdsql="update permit_number_generator set temp_active=1 where permit_no=$startno and lot_id=$intlotid";
			$wpdb->query($sdsql);	
			$arrPermitNos[]=$startno;
			$message.="Permit #$i : $startno<br/>";
		}

		
		$i=1;
		//$message="This is to notify that Permit # in reference to your application number BPA$customer_app_id has been generated.<br/>List of Permit no's are:<br/>";
		$user_id = get_current_user_id();

		$message.="<br/>Best Regards<br/>BPA<br/>";

		if($permitype=='Business')
		{
			$sdsql="select email from customer_application where customer_app_id=$cusomter_app_id";
			$arremail=$wpdb->get_results($sdsql);	
			$businessemail=$arremail[0]->email;

			$to=$businessemail;
			$headers[] = "From: BPA <generalinformation@bloomfieldparking.org>";
			$subject="Permit No.s for Application No - BPA$customer_app_id";
		//	wp_mail( $to, $subject, $message, $headers );

		}
		print_r(json_encode($arrPermitNos));exit;

	}

}

add_action('wp_ajax_run-my-ajax', 'call_my_ajax');
add_action('wp_ajax_nopriv_run-my-ajax', 'call_my_ajax');
?>