<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if directly accessed
do_action('quick_search_scripts');
?>

<div class="row">
	<div class="col-sm-12">
		<div class="card">
			<div class="card-header">
			</div>
			<h1><?= get_the_title($instance_id); ?></h1>
			<div class="card-body">
				<form action="" method="post" id="wp-generate-diploma">
					<div class="form-group row">
						<div class="col-sm-12">
							<input type="hidden" name="post_title" value="<?= get_the_title($instance_id); ?>" >
							<input type="hidden" name="post_id" value="<?= $instance_id; ?>" >
							<?php
							$default_image = WP_DIPLOMA_URL.'/templates/background.jpg';
							$custom_image = get_post_meta($instance_id,'bg_image_wp_diploma',true);
							?>
							<input type="hidden" name="bg_image_url" value="<?= (empty($custom_image)? $default_image : $custom_image); ?>" >
							<label for="search_key"><?php _e('Your full name', 'wp-diploma'); ?></label>
							<input type="text" name="user_name" required="">

							<input type="hidden" name="action" value="diploma_generate">
							<br>
						</div>
						<div class="form-group row">
							<label for="wp_diploma" class="col-sm-2 col-form-label"></label>
							<div class="col-sm-10">
								<button type="submit" id="wp_diploma" name="wp_diploma" class="btn btn-primary"><?php _e('Submit!', 'wp-diploma'); ?></button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>	</div>
	</div>
	<script>
		jQuery(document).ready(function(){
			jQuery('#quick-search input[type=submit]').click(function(){
				return confirm('<?php _e('Are you sure to do that?', 'quick-search'); ?>');
		});
	});
	</script>