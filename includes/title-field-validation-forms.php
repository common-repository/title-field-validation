<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

if (!function_exists('add_admin_menu_tfv_validation')) {
/**
* Function that adds admin menu in settings for validation settings
*/
	function add_admin_menu_tfv_validation(){ 

		add_options_page( 'Title Field Validation', 'Title Field Validation', 'manage_options', 'title_field_validation', 'tfv_validation_options_page' );

	}

	add_action( 'admin_menu', 'add_admin_menu_tfv_validation' );
}

if (!function_exists('tfv_validation_options_page')) {
/**
* Function that adds admin callback
*/
	function tfv_validation_options_page(){

	?>
	<form method="post" action="">
	<?php  
	wp_nonce_field(__FILE__,'tfv_nonce');
	?>
		<h1 class="tfv-heading">Validation Settings</h1>
		<br>

		<!-- Add Validation Settings Form -->
		<div id="tfv-validation-add-div">
			<h2 class="tfv-sub-heading">Add Validation</h2>
			<?php
			$post_types = get_post_types();
			?>
				<div id="error-message-save" class="notice notice-error is-dismissible" style="width: 33%;margin-left: 0px">
					<p id="error-message-save-p"></p>
					<button type="button" class="notice-dismiss"><span class="screen-reader-text">
					Dismiss this notice.</span></button>
				</div>
				<div id="success-message-save" class="notice notice-success is-dismissible" style="width: 33%;margin-left: 0px">
					<p id="success-message-save-p"></p>
					<button type="button" class="notice-dismiss"><span class="screen-reader-text">
					Dismiss this notice.</span></button>
			    </div>
			
			<div class="wrap">
				<label>Post type<span class="tfv-star">*</span></label>
				<select name="tfv_post_type" id="tfv-post-type" class="tfv-field tfv-post-label">
				    <option value="">Select post types</option>
					<?php
					foreach ( $post_types as $post_type ) {
						if($post_type == "attachment" || $post_type == "revision" || $post_type == "nav_menu_item" ||$post_type == "custom_css" || $post_type == "customize_changeset") {
						}
						else{
					    ?>
				            <option value="<?php echo $post_type; ?>"><?php echo $post_type; ?></option>
				        <?php
				    	}
				    }
				    ?>
			    </select>
			</div>
			<div id="tfv_post_error"></div>
			<div class="wrap">
				<div>
					<b>Title</b>
				</div>
				<div>
					<label>Title Label</label>
					<input type="text" name="tfv_title_label" id="tfv-title-label" class="tfv-field tfv-title-label">
				</div>
				<div>
					<label>Error Message</label>
					<input type="text" name="tfv_title_error" id="tfv-title-error" class="tfv-field tfv-title-error">
				</div>
			</div>
			<div class="wrap">
				<div>
					<b>Content</b>
				</div>
				<div>
					<label>Content Label</label>
					<input type="text" name="tfv_content_label" id="tfv-content-label" class="tfv-field tfv-content-title">
				</div>
				<div>
					<label>Error Message</label>
					<input type="text" name="tfv_content_error" id="tfv-content-error" class="tfv-field tfv-content-error">
				</div>
			</div>
			<input type="button" class="button-primary" name="tfv_submit" id="tfv-submit" value="<?php _e('Save') ?>" onclick="save_validation()"/>
		</div>

		<!-- Edit Validation Settings Form -->
		<div id="tfv-validation-edit-div">
			<h2 class="tfv-sub-heading">Edit Validation</h2>
			    <div id="error-message-edit" class="notice notice-error is-dismissible" style="width: 33%;margin-left: 0px">
					<p id="error-message-edit-p"></p>
					<button type="button" class="notice-dismiss"><span class="screen-reader-text">
					Dismiss this notice.</span></button>
				</div>
				<div id="success-message-edit" class="notice notice-success is-dismissible" style="width: 33%;margin-left: 0px">
					<p id="success-message-edit-p"></p>
					<button type="button" class="notice-dismiss"><span class="screen-reader-text">
					Dismiss this notice.</span></button>
			    </div>
			<div class="wrap">
			<input type="hidden" name="tfv_validation_id" id="tfv-validation-id" value="<?php echo esc_html($validation_id); ?>">
				<label>Post type<span class="tfv-star">*</span></label>
				<select name="tfv_post_type_e" id="tfv-post-type-e" class="tfv-field tfv-post-label" disabled>
				    <option value="">Select post types</option>
					<?php
					foreach ( $post_types as $post_type ) {
						if($post_type == "attachment" || $post_type == "revision" || $post_type == "nav_menu_item" ||$post_type == "custom_css" || $post_type == "customize_changeset") {
						}
						else{
					    ?>
				            <option value="<?php echo $post_type; ?>" 
				            <?php
				            if($posttype == $post_type)
				            {
				            	echo "selected";
				            }?>><?php echo $post_type; ?></option>
				        <?php
				    	}
				    }
				    ?>
			    </select>
			</div>
			<div class="wrap">
				<b>Title</b>
				<div>
					<label>Title Label</label>
					<input type="text" name="tfv_title_label_e" id="tfv-title-label-e" value="<?php echo esc_html($title_label); ?>" class="tfv-field tfv-title-label">
				</div>
				<div>
					<label>Error Message</label>
					<input type="text" name="tfv_title_error_e" id="tfv-title-error-e" value="<?php echo esc_html($title_error_msg); ?>" class="tfv-field tfv-title-error">
				</div>
			</div>
			<div class="wrap">
				<b>Content</b>
				<div>
					<label>Content Label</label>
					<input type="text" name="tfv_content_label_e" id="tfv-content-label-e" value="<?php echo esc_html($content_label); ?>" class="tfv-field tfv-content-title">
				</div>
				<div>
					<label>Error Message</label>
					<input type="text" name="tfv_content_error_e" id="tfv-content-error-e" value="<?php echo esc_html($content_error_msg); ?>" class="tfv-field tfv-content-error">
				</div>
			</div>
			<input type="button" class="button-primary" name="tfv_edit" id="tfv-edit" value="<?php _e('Update') ?>" onclick="update_validation()"/>
			<input type="button" class="button-primary" name="tfv_cancel" id="tfv-cancel" value="<?php _e('Cancel') ?>" onclick="cancel_validation()"/>
		</div>

		<!-- View Validation Settings  -->
		<div id="tfv-validation-view-div" class="scrollcss">
		    <table class="wp-list-table widefat fixed striped posts" style="width: 99%;">
			<thead>
			<tr>
			    <th>Sl No</th>
				<th width=100>Post Type</th>
				<th width=150>Title Label</th>
				<th width=200>Title Error Message</th>	
				<th width=150>Content Label</th>
				<th width=200>Content Error Message</th>
				<th width=100>Options</th>	
			</tr>
			</thead>
			<tbody>
			<?php
			global $wpdb;
			$table_validation = $wpdb->prefix."tfv_validation";
			$query_validation = $wpdb->get_results( $wpdb->prepare( 
								"
									SELECT * 
									FROM $table_validation  
									WHERE flag = %d
								", 
								1
							   ) );
			if(count($query_validation)>0){
				$i=1;
				foreach($query_validation as $validation){
				?>
					<tr>
					    <td><?php echo $i; ?></td>
						<td><?php echo esc_html($validation->post_type);?></td>
						<td><?php echo esc_html($validation->title_label);?></td>
						<td><?php echo esc_html($validation->title_error_msg);?></td>
						<td><?php echo esc_html($validation->content_label);?></td>
						<td><?php echo esc_html($validation->content_error_msg);?></td>
						<td><input type="button" value="Edit" class="button button-primary button-large" onclick="edit_validation('<?php echo esc_html($validation->validation_id); ?>')"></td>
						<td><input type="button" value="Delete" class="button button-primary button-large" onclick="delete_validation('<?php echo esc_html($validation->validation_id); ?>')" style="margin-left: -50px;"></td>
					</tr>
				<?php
				$i++;
			    }
			}
			else{
				?>
				<tr>
						<td>No validation settings found.</td>
				</tr>
		    <?php
			}?>
			</tbody>
			</table>
		</div>
	</form>
	<?php
	}
}

if (!function_exists('tfv_add_title_validation')) {
/**
* Function that adds title and validation to default field
*/

	function tfv_add_title_validation() {

	?>
	        <script> jQuery('<h2 style="padding-left: 0px;padding-top: 0px;" id="label-title"></h2>').insertBefore('#titlewrap'); </script>
		    <script> jQuery('<label id="title-error" class="error">'+jQuery("#new-title-error").val()+'</label>').insertAfter('#titlewrap'); </script>
		    <script> jQuery('<h2 style="padding-left: 0px; padding-bottom: 0px;padding-top: 16px;" id="label-content"></h2>').insertBefore('#postdivrich'); </script>
		    <script> jQuery('<label id="content-error" class="error">'+jQuery("#new-content-error").val()+'</label>').insertAfter('#postdivrich'); </script>
	<?php

	}
	add_action('admin_footer', 'tfv_add_title_validation');

}

if (!function_exists('tfv_find_title_validation')) {
/**
* Function that adds find validation settings.
*/

	function tfv_find_title_validation(){

		global $wpdb;
		$table_validation = $wpdb->prefix."tfv_validation";

		check_ajax_referer( 'tfv_nonce', 'tfv_nonce', false );

		if(isset($_POST['post_type'])){
		
		    $post_type = sanitize_text_field($_POST['post_type']);
			$query_validation = $wpdb->get_results( $wpdb->prepare( 
									"
										SELECT * 
										FROM $table_validation  
										WHERE post_type = %s and flag = %d
									", 
									$post_type,
									1
								) );
				if(count($query_validation)>0){
					foreach($query_validation as $validation){	
						$post_type_label	=	esc_html($validation->post_type);
						$title_label 		=	esc_html($validation->title_label);
						$error_title 		=	esc_html($validation->title_error_msg);
						$content_label 		=	esc_html($validation->content_label);
						$error_content 		=	esc_html($validation->content_error_msg);
					}
					$data=array('post_type_label'   => 	$post_type_label,
							    'title_label'       =>  $title_label,
							    'title_error_msg'   =>  $error_title,
							    'content_label'     =>  $content_label,
				                'content_error_msg' =>  $error_content);
					echo json_encode($data);
					wp_die();
				}
			}
	    wp_die();
		}
		add_action('wp_ajax_find_post_type','tfv_find_title_validation');

}

if (!function_exists('save_validation')) {
/**
* Function that adds save validation settings.
*/

	function save_validation(){

		global $wpdb;
		$table_validation = $wpdb->prefix."tfv_validation";
		$date 		      = date('Y-m-d H:i:s');

		check_ajax_referer( 'tfv_nonce', 'tfv_nonce', false );

		if(isset($_POST['tfv_post_type'])){
			$post_name = sanitize_text_field($_POST['tfv_post_type']);
		}
		else{
			$post_name = "";
		}

		if(isset($_POST['tfv_title_label'])){
			$title_lable = sanitize_text_field($_POST['tfv_title_label']);
		}
		else{
			$title_lable = "";
		}

		if(isset($_POST['tfv_title_error'])){
			$title_error = sanitize_text_field($_POST['tfv_title_error']);
		}
		else{
			$title_error = "";
		}

		if(isset($_POST['tfv_content_label'])){
			$content_label = sanitize_text_field($_POST['tfv_content_label']);
		}
		else{
			$content_label = "";
		}
			
		if(isset($_POST['tfv_content_error'])){
			$content_error = sanitize_text_field($_POST['tfv_content_error']);
		}
		else{
			$content_error = "";
		}

		if($post_name == "") {
			echo "error1";
		}
		else if($title_lable == "" && $content_label == "" && $title_error  == "" && $content_error == ""){
			echo "error2";
		}
		else {
			$get_validation   = $wpdb->get_results( $wpdb->prepare( 
								"
									SELECT * 
									FROM $table_validation  
									WHERE post_type = %s and flag = %d
								", 
								$post_type,
								1
							    ) );
		    if(count($get_validation)>0){
		    	echo "error3";
		    }
		    else{
				$wpdb->query( $wpdb->prepare( 
						"
							INSERT INTO $table_validation
							(post_type, title_label, title_error_msg, content_label, content_error_msg, created_at, modified_at)
							VALUES ( %s, %s, %s , %s , %s , %s , %s )
						", 
					    $post_name, 
						$title_lable, 
						$title_error, 
						$content_label,
						$content_error,
						$date,
						$date
					) );
				    echo "success";
			}
		}
		wp_die();
	}
	add_action('wp_ajax_save_validation','save_validation');
}

if (!function_exists('edit_validation')) {
/**
* Function that adds edit validation settings.
*/

	function edit_validation(){

		global $wpdb;
		$table_validation = $wpdb->prefix."tfv_validation";

		check_ajax_referer( 'tfv_nonce', 'tfv_nonce', false );

		if(isset($_POST['id'])){

			$id = sanitize_text_field($_POST['id']);
			$edit_validation = $wpdb->get_results( $wpdb->prepare( 
								"
									SELECT * 
									FROM $table_validation  
									WHERE validation_id = %d and flag = %d
								", 
								$id,
								1
							) );
			foreach ($edit_validation as $validation) {
				$posttype 			= esc_html($validation->post_type);
				$title_label 		= esc_html($validation->title_label);
				$title_error_msg 	= esc_html($validation->title_error_msg);
				$content_label 		= esc_html($validation->content_label);
				$content_error_msg 	= esc_html($validation->content_error_msg);
			}
			$data=array("validation_id"     => $id,
				        "post_type"         => $posttype,
				        "title_label"       => $title_label,
				        'title_error_msg'   => $title_error_msg,
				        'content_label'     => $content_label,
				        'content_error_msg' => $content_error_msg);
			echo json_encode($data);
		}		
		wp_die();	
	}
	add_action('wp_ajax_edit_validation','edit_validation');

}

if (!function_exists('update_validation')) {
/**
* Function that adds update validation settings.
*/

	function update_validation(){

		global $wpdb;
		$table_validation = $wpdb->prefix."tfv_validation";
		$date 		      = date('Y-m-d H:i:s');

		check_ajax_referer( 'tfv_nonce', 'tfv_nonce', false );

		if(isset($_POST['tfv_validation_id'])){
			$validation_id = sanitize_text_field($_POST['tfv_validation_id']);

			if(isset($_POST['tfv_post_type_e'])){
			    $post_name = sanitize_text_field($_POST['tfv_post_type_e']);	
			}
			else{
				$post_name = "";
			}

			if(isset($_POST['tfv_title_label_e'])){
				$title_lable = sanitize_text_field($_POST['tfv_title_label_e']);
			}
			else{
				$title_lable = "";
			}

			if(isset($_POST['tfv_title_error_e'])){
				$title_error = sanitize_text_field($_POST['tfv_title_error_e']);
			}
			else{
				$title_error = "";
			}

			if(isset($_POST['tfv_content_label_e'])){
				$content_label = sanitize_text_field($_POST['tfv_content_label_e']);
			}
			else{
				$content_label = "";
			}

			if(isset($_POST['tfv_content_error_e'])){
				$content_error = sanitize_text_field($_POST['tfv_content_error_e']);
			}
			else{
				$content_error = "";
			}

			if($title_error  == "" && $content_error == ""){
				echo "error";
			}
			else{
		        $wpdb->query( $wpdb->prepare( 
				"
					UPDATE $table_validation SET
					title_label = %s, title_error_msg = %s, content_label = %s, content_error_msg = %s, modified_at = %s where validation_id = %d
				", 
			     $title_lable,
			     $title_error,
			     $content_label,
			     $content_error,
			     $date,
			     $validation_id
			    ) );
			    echo "success";
			}
			wp_die();
		}

	}
	add_action('wp_ajax_update_validation','update_validation');
}

if (!function_exists('delete_validation')) {
/**
* Function that adds delete validation settings.
*/

	function delete_validation(){

		global $wpdb;
		$table_validation = $wpdb->prefix."tfv_validation";

		check_ajax_referer( 'tfv_nonce', 'tfv_nonce', false );
	    
	    if(isset($_POST['id'])){

	    	$id = sanitize_text_field($_POST['id']);
			$wpdb->query( $wpdb->prepare( 
			"
				UPDATE $table_validation
				SET flag = %d where validation_id = %d
			", 
		     0,
		     $id
		    ) );
			echo "success";
			wp_die();	
	    }
		
	}
	add_action('wp_ajax_delete_validation','delete_validation');
}
?>