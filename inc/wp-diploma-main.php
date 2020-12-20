<?php
/**
* Fired during plugin activation
*/

include(WP_DIPLOMA_PATH.'/assets/simplexlsx-master/src/SimpleXLSX.php');

class WpDiploma{

	
	function __construct(){
		/*Menu hook*/
		add_action( 'admin_menu', array($this,'register_wp_diploma_menu' ));
		/*Register Styling Scripts For admin*/
        // add_action( 'admin_enqueue_scripts', array($this,'script_styles_admin' ));
		add_action( 'admin_enqueue_scripts', array($this,'script_styles_admin' ));
        /*Register Styling Scripts For admin*/
        add_action( 'wp_enqueue_scripts', array($this,'script_styles_user' ));
        /*Register Custom PostType*/
		add_action( 'init', array($this,'registerCustomPostType' ));
        /*Add meta box for shortcode*/
        add_action( 'admin_init', array($this,'add_post_meta_boxes' ));
        /*add shortcode*/
        add_shortcode( 'wp_diploma', array($this,'get_all_shortcodes' ));
        /*update meta on instance update*/
        add_action( 'save_post_instance', array($this,'on_save_instance' ),10,3);
        add_action( 'post_edit_form_tag', array($this,'update_edit_form' ),10,3);


        // add_action( 'transition_post_status', array($this,'on_update_instance' ),10,3);

		/*add meta box for image url field*/
        // add_action( 'admin_init', array($this,'add_custom_field_for_image_url' ));

	}
      
    function display_box_imageurl_field(){
        global $post;
        $name_size_wp_diploma = get_post_meta($post->ID, 'name_size_wp_diploma', true);
        $name_font_family = get_post_meta($post->ID, 'name_font_family', true);
        $name_position = get_post_meta($post->ID, 'name_position', true);
        $bg_image_wp_diploma = get_post_meta($post->ID, 'bg_image_wp_diploma', true);
        $name_positions = array(
            'Center' => 'center',
            'Top Left' => 'top_left',
            'Top Right' => 'top_right',
            'Bottom Left' => 'bottom_left',
            'Bottom Right' => 'bottom_right',
        );

        ?>
        <style type="text/css">
            div#advanced-sortables .inside .card {
                min-width: 100% !important;
            }
        </style>
        <div class="card">
          <h3 class="card-header">Settings</h3>
          <div class="card-body">
          <div class="form-group row">
            <label for="name_size_wp_diploma" class="col-sm-2 col-form-label">Name font size:</label>
            <div class="col-lg-10">
              <input type="text" class="form-control-plaintext" id="name_size_wp_diploma"  name="name_size_wp_diploma" placeholder="example 10px" value="<?php echo $name_size_wp_diploma; ?>">
            </div>
          </div>
           <div class="form-group row">
            <label for="name_font_family" class="col-sm-2 col-form-label">Name font family:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control-plaintext" id="name_font_family"  name="name_font_family" placeholder="" value="<?php echo $name_font_family; ?>">
            </div>
          </div>
           <div class="form-group row">
            <label for="name_position" class="col-sm-2 col-form-label">Name position:</label>
            <div class="col-sm-10">
                <select class="form-control-plaintext" id="name_position" name="name_position" required="">
                    <option value="">Select position</option>
                    <?php
                    foreach ($name_positions as $label => $value) {
                        ?>
                        <option value="<?= $value; ?>" <?= ($name_position == $value)? 'selected':''; ?> > <?= $label; ?></option>
                        <?php
                    }
                    ?>
                </select>
              <!-- <input type="text"  placeholder="" value="<?php echo $name_position; ?>"> -->
            </div>
          </div>
           <div class="form-group row">
            <label for="bg_image_wp_diploma" class="col-sm-2 col-form-label">Backgroung Image:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control-plaintext" id="bg_image_wp_diploma"  name="bg_image_wp_diploma" placeholder="Image url" value="<?php echo $bg_image_wp_diploma; ?>">
            </div>
          </div>
         
          </div>
         
          </div>

        <?php
    }

    function on_save_instance($id) {

        if(!empty($_FILES['bulk_create']['name'])) {
        $arr_file_type = wp_check_filetype(basename($_FILES['bulk_create']['name']));
        $uploaded_type = $arr_file_type['type'];
            $upload = wp_upload_bits($_FILES['bulk_create']['name'], null, file_get_contents($_FILES['bulk_create']['tmp_name']));
            if(isset($upload['error']) && $upload['error'] != 0) {
                wp_die('There was an error uploading your file. The error is: ' . $upload['error']);
            } else {
                update_post_meta($id, 'bulk_create_file', $upload);
                update_post_meta($id, 'bulk_create_file_name', $_FILES['bulk_create']['name']);
            }

            $file = get_post_meta($id, 'bulk_create_file_name', true);
            $upload_dir = wp_upload_dir();
            if ( $xlsx = SimpleXLSX::parse( $upload_dir['path'].'/'.$file ) ) {
                $folder_location = ABSPATH . 'wp-content/uploads/wp_diploma/bulk';
                $folder_created  = wp_mkdir_p($folder_location);
                $bg_image_url = get_post_meta($id,'bg_image_wp_diploma',true);
                list($width_orig, $height_orig) = getimagesize($bg_image_url);
                $name_size_wp_diploma = get_post_meta($id, 'name_size_wp_diploma', true);
                $name_font_family = get_post_meta($id, 'name_font_family', true);
                $name_position = get_post_meta($id, 'name_position', true);
                $name_variable_settings = array(
                    'center' => 'margin-left:'.$width_orig*.4.'; margin-top:'.$height_orig *.35.';',
                    'top_left' => '',
                    'top_right' => 'margin-left:'.$width_orig*.7.';',
                    'bottom_left' => 'margin-top:'.$height_orig*.55.';',
                    'bottom_right' => 'margin-left:'.$width_orig*.7.'; margin-top:'.$height_orig *.55.';',
                );
                foreach ($xlsx->rows() as $row) {
                    $name_info =array(
                        "font_size" => $name_size_wp_diploma,
                        "font_family" => $name_font_family,
                        "position" => $name_variable_settings[$name_position],
                        "date_margin" => $width_orig - 630,
                        "bg_image_url" => $bg_image_url,
                        "user_name" => $row[0]
                    );
                    if ($folder_created == true) {
                            $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => [$width_orig * 0.2645833333, $height_orig * 0.2645833333]]);
                            
                            $options = array( 
                                'http' => array( 
                                'method' => 'POST', 
                                'content' => http_build_query($name_info)) 
                            ); 

                            $stream = stream_context_create($options); 
                            $html = file_get_contents(WP_DIPLOMA_URL.'/inc/wp-bulk-diploma.php', false, $stream); 
                            $html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
                            // $mpdf->WriteHTML(utf8_encode($html), \Mpdf\HTMLParserMode::HTML_BODY);
                            $mpdf->WriteHTML($html,\Mpdf\HTMLParserMode::DEFAULT_MODE);
                            $uploads = wp_upload_dir();
                            $filename = $uploads['basedir'].'/wp_diploma/bulk/'.$row[1].'.pdf';
                            $filename_toredirect = $uploads['baseurl'].'/wp_diploma/bulk/'.$row[1].'.pdf';
                            $mpdf->Output($filename, 'F');
                            // $mpdf->Output($filename, 'D');
                            // return $uploads['baseurl'].'/certificates/'.$diploma_name.'.pdf';
            }

                  $count++;
                }


              } else {
                echo SimpleXLSX::parseError();
              }
    }
        else{
        $custom_fields_arr = $_POST['meta'];
        
        $name_size_wp_diploma = $_POST['name_size_wp_diploma'];
        $name_font_family = $_POST['name_font_family'];
        $name_position = $_POST['name_position'];
        $image_url = $_POST['bg_image_wp_diploma'];

        update_post_meta($id,'name_size_wp_diploma',$name_size_wp_diploma);
        update_post_meta($id,'name_font_family',$name_font_family);
        update_post_meta($id,'name_position',$name_position);
        update_post_meta($id,'bg_image_wp_diploma',$image_url);

        }
    }
    

	function register_wp_diploma_menu() {
		if(is_admin())
		add_menu_page('Wp Diploma', 'Wp Diploma', 'edit_pages', 'wp-diploma', 'edit.php?post_type=quiz',  'dashicons-admin-users', 30);
        add_submenu_page( 'wp-diploma', 'Create New Instace', 'Create Instace', 'manage_options', 'post-new.php?post_type=instance');
	}
	function script_styles_admin(){
		echo '<link rel="stylesheet" href="'.WP_DIPLOMA_URL.'/assets/css/bootstrap.css">';
    	wp_enqueue_script( 'jquery-validate', WP_DIPLOMA_URL.'/assets/js/jquery-validate.js', '', '', true );
    	wp_enqueue_script( 'main-script', WP_DIPLOMA_URL.'/assets/js/main-script.js', '', '', true );
        wp_localize_script('main-script', 'wp_diploma',
        array(
            'ajax_url' => admin_url( 'admin-ajax.php' ),
        )
    );
    	
	}
    function script_styles_user(){
        // echo '<link rel="stylesheet" href="'.WP_DIPLOMA_URL.'/assets/css/bootstrap.css">';
        wp_enqueue_style('main-css',WP_DIPLOMA_URL.'/assets/css/main-style.css');
        wp_enqueue_script( 'main-script', WP_DIPLOMA_URL.'assets/js/main-script.js', '', '', true );
        wp_localize_script('main-script', 'wp_diploma',
        array(
            'ajax_url' => admin_url( 'admin-ajax.php' ),
        )
    );
    }
    function get_all_shortcodes($atts){
           extract( shortcode_atts( array(
                'instance_id' => 'myvalue'
                ), $atts ) );
           require(WP_DIPLOMA_PATH.'/templates/form.php');

    }



	function registerCustomPostType(){
     $labels = array(
        'name'                => __( 'Instance', 'wp-diploma' ),
        'singular_name'       => __( 'Instance', 'wp-diploma' ),
        'add_new'             => _x( 'Create New Instance', 'wp-diploma', 'wp-diploma' ),
        'add_new_item'        => __( 'Create New Instance', 'wp-diploma' ),
        'edit_item'           => __( 'Edit Instance', 'wp-diploma' ),
        'new_item'            => __( 'New Instance', 'wp-diploma' ),
        'view_item'           => __( 'View Instance', 'wp-diploma' ),
        'search_items'        => __( 'Search Instance', 'wp-diploma' ),
        'not_found'           => __( 'No Instance found', 'wp-diploma' ),
        'not_found_in_trash'  => __( 'No Instance found in Trash', 'wp-diploma' ),
        'parent_item_colon'   => __( 'Parent Instance:', 'wp-diploma' ),
        'menu_name'           => __( 'View Instance', 'wp-diploma' ),
	);

    $args = array(
        'labels'              => $labels,
        'hierarchical'        => false,
        'description'         => 'description',
        'taxonomies'          => array(),
        'public'              => false,
        'show_ui'             => true,
        'show_in_menu'        => 'wp-diploma',
        'show_in_admin_bar'   => true,
        'menu_position'       => null,
        'menu_icon'           => null,
        'show_in_nav_menus'   => true,
        'show_in_rest'        => true,    
        'publicly_queryable'  => true,
        'exclude_from_search' => false,
        'has_archive'         => true,
        'query_var'           => true,
        'can_export'          => true,
        'rewrite'             => true,
        'capability_type'     => 'post',
        'supports'            => array(
            'title',
            // 'custom-fields'
        )
    );

    register_post_type( 'instance', $args );

	}
	function add_post_meta_boxes() {
    // see https://developer.wordpress.org/reference/functions/add_meta_box for a full explanation of each property
	    add_meta_box(
	        "instance_shortcode_wp_diploma", // div id containing rendered fields
	        "Shortcode", // section heading displayed as text
	        array($this,'post_meta_box_advertising_category' ), // callback function to render fields
	        "instance", // name of post type on which to render fields
	        "side", // location on the screen
	        "low" // placement priority
		    );
        add_meta_box(
            "bulk_create_wp_diploma", // div id containing rendered fields
            "Bulk Create", // section heading displayed as text
            array($this,'diploma_meta_box_bulk_create' ), // callback function to render fields
            "instance", // name of post type on which to render fields
            "advanced", // location on the screen
            "low" // placement priority
            );
         add_meta_box(
            "image_url_field_wp_diploma", // div id containing rendered fields
            " ", // Diploma background image url //heading
            array($this,'display_box_imageurl_field' ),
            "instance", // name of post type on which to render fields
            "advanced", // location on the screen
            "high" // placement priority
        );
	}

    function diploma_meta_box_bulk_create(){
        global $post;
        if ($post->post_status == 'publish') {
            ?>
            <p>Upload excel or csv file</p>
                <input type="file" name="bulk_create">
            <?php
        }
        ?>
        <?php
    }
	function post_meta_box_advertising_category(){
	    global $post;
        if ($post->post_status == 'publish') {
            ?>
            <p><?php echo "[wp_diploma instance_id='". $post->ID."']"; ?></p>
            <?php
        }
	    ?>
	    <?php
	}
    public static function generateRandomString($length = 3) {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    public function update_edit_form() {
            echo 'enctype="multipart/form-data"';
    }
}
$WpDiploma = new WpDiploma();
