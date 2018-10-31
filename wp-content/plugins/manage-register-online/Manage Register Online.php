<?php
session_start();
?>
<?php
/*

Plugin Name: Manage Register Online
Plugin URI:
Description: Manage, save, export csv information from register online through contact form 7
Author: Sapling
Version: 1.1
Author URI:

*/
require_once (ABSPATH . 'wp-content/plugins/manage-register-online/Helper.php');
require_once (ABSPATH . 'wp-content/plugins/manage-register-online/ListPupilTable.php');
require_once (ABSPATH . 'wp-content/plugins/manage-register-online/ActionProcessor.php');


/*
require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
dbDelta($sql_create_table);
*/


function wp_registeronline_addmin_tab()
{
add_menu_page('Manage Register Online', 'Manage Register Online', 'create_users', 'manage-register-online', 'wp_registeronline_admin_options_page', 'dashicons-awards', 81);
}
add_action('admin_menu', 'wp_registeronline_addmin_tab');


function wp_registeronline_scripts()
{
wp_register_script('datePicker', plugins_url('/js/jquery.datepick.js', __FILE__) , array(
'jquery'
));
wp_enqueue_script('datePicker');
wp_enqueue_script('media-upload');
wp_enqueue_script('thickbox');
}

function wp_registeronline_styles()
{
	wp_register_style('styleDatePicker', plugins_url('/css/jquery.datepick.css', __FILE__) , array() , '20120914', 'all');
	wp_enqueue_style('styleDatePicker');
	wp_register_style('wp_registeronline', WP_PLUGIN_URL . '/manage-register-online/css/style.css');
	wp_enqueue_style('wp_registeronline');
}

add_action('admin_print_scripts', 'wp_registeronline_scripts');
add_action('admin_print_styles', 'wp_registeronline_styles');

add_action('wpcf7_before_send_mail', 'processUploadForm',1);

    // Process upload form
function processUploadForm($cfdata) {
	global $wpdb;

	 if (!isset($cfdata->posted_data) && class_exists('WPCF7_Submission')) {
        // Contact Form 7 version 3.9 removed $cfdata->posted_data and now
        // we have to retrieve it from an API
        $submission = WPCF7_Submission::get_instance();
        if ($submission) {
            $formData =& $submission->get_posted_data();
        }
    } elseif (isset($cfdata->posted_data)) {
        // For pre-3.9 versions of Contact Form 7
        $formData = $cfdata->posted_data;
    } else {
        // We can't retrieve the form data
        return $cfdata;
    }

	$title = $cfdata->title();
	
       $pupilname 	= isset($formData['your-name'])?	$formData['your-name'] 	: '';
		
		$tmp_birthday  = isset($formData['birthday'])?	$formData['birthday'] 	: '';
		$tmp_birthmonth  = isset($formData['birthmonth'])?	$formData['birthmonth'] 	: '';
		$tmp_birthyear = isset($formData['birthyear'])?	$formData['birthyear'] 	: '';
		
        $birthday 	= $tmp_birthday."/".$tmp_birthmonth."/".$tmp_birthyear;
		$birthday_2 	= $tmp_birthyear."-".$tmp_birthmonth."-".$tmp_birthday;
		$email = isset($formData['your-email'])?		$formData['your-email'] 	: '';
		$phone	  =  isset ($formData['your-mobile'])?	$formData['your-mobile'] : '';
		$doituong	  =  isset ($formData['your-object'])?	$formData['your-object'] : '';
		$province = isset($formData['your-location'])?		$formData['your-location'] 	: '';
		$daduthi = isset($formData['applyed-uni'])?		$formData['applyed-uni'] 	: '';
		$diemthi = isset($formData['applyed-mark'])?		$formData['applyed-mark'] 	: '';
		$khoithi_tmps = isset($formData['applyed-group'])?	$formData['applyed-group'] 	: '';
		$namthi = isset($formData['applyed-year'])?		$formData['applyed-year'] 	: '';
		$university = isset($formData['university'])?		$formData['university'] 	: '';
		$doituongkhac = isset($formData['another-obj-student'])?	$formData['another-obj-student'] 	: '';
		$pupil_school = isset($formData['highschool'])?		$formData['highschool'] 	: '';
		$url_refer_z = $_SESSION['daihoc_z'];
		$url_request_z = $_SESSION['click'];
		date_default_timezone_set('Asia/Ho_Chi_Minh'); 
		$dateregister =  date('Y-m-d H:i:s');
		
		$khoithi = '';
		if ($khoithi_tmps != '') {
			foreach($khoithi_tmps as $khoithi_tmp) {
				$khoithi .= $khoithi_tmp .",";
			}
		}
			
		if ($diemthi == '')
			$diemthi = -1;
		
        $item = array('name'     => $pupilname,
                      'birthday'     => $birthday,
					  'pupil_school'	=> $pupil_school,
					  'email'		=> $email,
					  'diadiemthi'		=> $province,
					  'doituong'		=> $doituong[0],
					  'phone'		=> $phone,
					  'daduthi'		=> $daduthi,
					  'diemthiDH'		=> $diemthi,
                      'khoithiDH'        => $khoithi,
                      'namthi'        => $namthi,
                      'university'        => $university,
                      'doituongkhac'        => $doituongkhac,
					  'register_date'		=> $dateregister,
					  'Url_refer' => $url_refer_z,
					  'Url_Request' => $url_request_z
					  );

		if ($id === null && $title == 'Registration form 1') {
				if ($wpdb->get_results("SELECT * FROM wp_plg_registeronline WHERE name = '$pupilname' AND phone = '$phone' AND birthday = '$birthday'") && $wpdb->num_rows > 0 ) {
					exit;
				}
				else {
					$helper = new Helper($wpdb);
					$result = $helper->insertItem($item);
					
					/*$url = 'http://crm.fpt.edu.vn/index.php?entryPoint=WebToLeadCapture';
					
					switch ($province) {
						case "HN":
						$assigned_user_id = "85ec40fe-e642-5cba-d306-54b50623be40";
						break;
						case "DN":
						$assigned_user_id = "10986776-610f-5eaf-493f-54c26e9a73d9";
						break;
						case "HCM":
						$assigned_user_id = "cbe61be7-ece7-3a39-7a39-54c26e7a98f1";
						break;
						default:
						echo 'Lỗi assigned_user_id hoặc Province không có giá trị!';
					}
					
					 $param = array(
						'last_name' => $pupilname,
						'birthdate' => $birthday_2,
						'area_c' => $province,
						'email1' => $email,
						'phone_mobile' => $phone,
						'campaign_id' => '5024ae1c-3bd7-0245-94f3-54b505b06cd2',
						'assigned_user_id' => $assigned_user_id,
						'lead_source'	=> 'Online'
					);
					// Khởi tạo CURL
					$ch = curl_init($url);
					 
					// Thiết lập có return
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					 
					// Thiết lập sử dụng POST
					curl_setopt($ch, CURLOPT_POST, true);
					 
					// Thiết lập các dữ liệu gửi đi
					curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
					 
					$result_curl = curl_exec($ch);
					 
					curl_close($ch);
					*/
					if ($result == 0) {
						return 0;
					} else {
						return 1;
					}
				} 
		} 
    }

function wp_registeronline_admin_options_page(){
	
	$actionProcessor = new ActionProcessor();
	?>
	<div class="wp-registeronline-content">
	<?php
		$actionProcessor->processAction(); ?>
	</div>
	<?php
}

?>