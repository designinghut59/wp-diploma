<?php 
/**
 * ajax
 */
include(WP_DIPLOMA_PATH.'/vendor/autoload.php');
	class wp_diploma_ajax extends WpDiploma{
	function __construct(){
      
            add_action( "wp_ajax_diploma_generate", array($this, 'wp_diploma_generate') );
            add_action( "wp_ajax_nopriv_diploma_generate", array($this, 'wp_diploma_generate') );
       
	}
	public function wp_diploma_generate(){
	      $folder_location = ABSPATH . 'wp-content/uploads/wp_diploma';
            $folder_created  = wp_mkdir_p($folder_location);
            $bg_image_url = $_POST['bg_image_url'];
            list($width_orig, $height_orig) = getimagesize($bg_image_url);
           	$post_id = $_POST['post_id'];
            $name_size_wp_diploma = get_post_meta($post_id, 'name_size_wp_diploma', true);
            $name_font_family = get_post_meta($post_id, 'name_font_family', true);
            $name_position = get_post_meta($post_id, 'name_position', true);
           
            if ($name_size_wp_diploma >= 40 && $name_size_wp_diploma <= 50) {
                $margin_left_percentage = 0.35;
                $margin_top_percentage = (( in_array($height_orig, range(897,1400)) ) ?  0.3 : 0.4 ) ;
            }
            elseif ($name_size_wp_diploma > 50 && $name_size_wp_diploma <= 70) {
                $margin_left_percentage = 0.3;
                $margin_top_percentage = (( in_array($height_orig, range(897,1400)) ) ?  0.27 : 0.37 ) ;
            }
            else{
                $margin_left_percentage = 0.4;
                $margin_top_percentage = (( in_array($height_orig, range(897,1400)) ) ?  0.35 : 0.42 ) ;
            }
        	$name_variable_settings = array(
                'center' => 'text-align: center !important; margin-top:'.$height_orig * $margin_top_percentage.';',
        		'top_left' => '',
        		'top_right' => 'margin-left:'.$width_orig*.7.';',
        		'bottom_left' => 'margin-top:'.$height_orig*.55.';',
        		'bottom_right' => 'margin-left:'.$width_orig*.7.'; margin-top:'.$height_orig *.55.';',
        	);
            $name_info =array(
            	"font_size" => $name_size_wp_diploma. "px",
            	"font_family" => $name_font_family,
            	"position" => $name_variable_settings[$name_position],
            	"date_margin" => $width_orig - 630,
            );

            $_POST = array_merge($_POST, $name_info);
            if ($folder_created == true) {
            	$mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => [$width_orig * 0.2645833333, $height_orig * 0.2645833333]]);
            	
		        $options = array( 
				    'http' => array( 
				    'method' => 'POST', 
				    'content' => http_build_query($_POST)) 
				); 
				
				$stream = stream_context_create($options); 
				$html = file_get_contents(WP_DIPLOMA_URL.'/templates/certificate.php', false, $stream); 
		        $html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
				// $mpdf->WriteHTML(utf8_encode($html), \Mpdf\HTMLParserMode::HTML_BODY);
				$mpdf->WriteHTML($html,\Mpdf\HTMLParserMode::DEFAULT_MODE);
		        $uploads = wp_upload_dir();
		        $diploma_name = "wp_diploma_".WpDiploma::generateRandomString();
		        $filename = $uploads['basedir'].'/wp_diploma/'.$diploma_name.'.pdf';
		        $filename_toredirect = $uploads['baseurl'].'/wp_diploma/'.$diploma_name.'.pdf';
		        $mpdf->Output($filename, 'F');
		        // $mpdf->Output($filename, 'D');
		        // return $uploads['baseurl'].'/certificates/'.$diploma_name.'.pdf';
            	$response['message'] = 'foler created';
            	$response['filename'] = $filename_toredirect;
            	$response['status'] = true;
            }
            else{
            	$response['message'] = 'Error in creating folder';
            	$response['status'] = false;
            }
            $this->responseJsonResults($response);
		

		// var_dump(WpDiploma::generateRandomString());exit();

	}
 
	function responseJsonResults($data){
        header('Content-Type: application/json');
        echo json_encode($data);
        wp_die();
    }

}
new wp_diploma_ajax();