<?php
// Exit if accessed directly.
if (!defined('ABSPATH')){
    exit;
}

if ( ! class_exists( 'ThemeHunk_Child_Notify' ) ){

class ThemeHunk_Child_Notify{

    function __construct(){

		if(isset($_GET['notice-disable']) && $_GET['notice-disable'] == true){
		add_action('admin_init', array($this,'set_cookie'));
		}


		if(!isset($_COOKIE['thc_time'])) {
			 add_action( 'admin_notices', array($this,'notify'));

		}

		if(isset($_COOKIE['thc_time'])) {
			add_action( 'admin_notices', array($this,'unset_cookie'));
		}

	}


	function set_cookie() { 
 
		$visit_time = date('F j, Y  g:i a');

			$cok_time = time()+(86457*30);
 
		if(!isset($_COOKIE['thc_time'])) {
 
			// set a cookie for 1 year
		setcookie('thc_time', $cok_time, time()+(86457*30));
			 
		}
 
	}

		function unset_cookie(){

			$visit_time = time();
		
		
			$cookie_time = isset($_COOKIE['thc_time']) ? sanitize_key($_COOKIE['thc_time']) : '0';

			if ($cookie_time < $visit_time) {
				setcookie('thc_time', null, strtotime('-1 day'));
			}
	}

	function notify(){
		  $my_theme = wp_get_theme();
		  $theme =  esc_html( $my_theme->get( 'TextDomain' ) );
		$display = isset($_GET['notice-disable'])?'none':'block'; 
		?>

          <div class="notice notice-success is-dismissible child-theme-notice" style="display:<?php echo esc_attr($display); ?>;">
        <p><?php esc_html_e( "Child theme inherit the style and functionality of parent theme, you can easily update the parent theme without losing its Customization. That's why we highly recommend you to use Child theme to make your site update proof.", 'th-shop-mania' ); ?></p>
        <a href="<?php echo esc_url('https://themehunk.com/child-theme/#th-shop-mania-child'); ?>" class="button" target="_blank"><?php esc_html_e('Get Child Theme Now','th-shop-mania') ?></a>

        <a href="?notice-disable=1"  class="notice-dismiss dashicons dashicons-dismiss dashicons-dismiss-icon"></a>
    </div>


 <?php } 


}

$obj = New ThemeHunk_Child_Notify();

 } // if class end ?>
