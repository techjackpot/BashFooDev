<?php

/**
 * Generate Theme Options String for DB storage
 *
 * @param array $theme_options
 * @return array
 **/
function _usdp_generate_options_string($theme_options)
{
	$page_options_string = array();
	foreach( $theme_options as $title => $options) {
		foreach( $options as $option ){
			$page_options_string[] = $option[1];
		}
	}
	return $page_options_string;
}

/** 
 * Generate Options Page Markup
 *
 * @param array(string $title, string $description, array $theme options, array $page_options_string)
 * @return null
 */
function _usdp_generate_options_page_markup($title, $description, $theme_options, $page_options_string)
{ 
	if(function_exists( 'wp_enqueue_media' )){
	    wp_enqueue_media();
	}else{
	    wp_enqueue_style('thickbox');
	    wp_enqueue_script('media-upload');
	    wp_enqueue_script('thickbox');
	}

?>

	<div class="wrap">
		<?php settings_errors();?>
		<h2><?php echo $title; ?></h2>
		<p><?php echo $description; ?></p>
		<form method="post" action="options.php">
			<?php wp_nonce_field('update-options') ?>

			<?php foreach( $theme_options as $heading => $options ) { ?>
			<h3><?php echo $heading;?></h3>
				<table class="form-table">
					<?php foreach( $options as $title => $option ) { ?>
					<tr>
						<th scope="row"><label for="<?php echo $option[1];?>"><?php echo $title;?></label></th>
						<td>
						<?php if( $option[0] == 'text' ) { ?>
							<input type="text" name="<?php echo $option[1];?>" size="45" value="<?php echo get_option($option[1]);?>"/>
						<?php } ?>
						<?php if( $option[0] == 'checkbox' ) { ?>
							<input type="hidden" name="<?php echo $option[1]; ?>" value="false"/>
							<input type="checkbox" name="<?php echo $option[1]; ?>" value="true" <?php echo get_option($option[1]) == 'true' ? 'checked' : '';?>/>
						<?php } ?>
						<?php if( $option[0] == "textarea" ) { ?>
							<?php wp_editor(get_option($option[1]), $option[1], null); ?>
						<?php } ?>
						<?php if( $option[0] == 'select' ) { ?>
							<select name="<?php echo $option[1]; ?>">
								<option>Select Item</option>
								<?php foreach( $option[3] as $item ) { ?>
									<option value="<?php echo $item[0];?>" <?php echo $item[0] == get_option($option[1]) ? 'selected' : '' ;?>><?php echo $item[1];?></option>
								<?php } ?>
							</select>
						<?php } ?>
						<?php if( $option[0] == "image" ) { ?>
						
							<input class="<?php echo $option[1];?>_input" type="text" size="45" name="<?php echo $option[1];?>" size="60" value="<?php echo get_option($option[1]);?>">
							<a href="#" class="<?php echo $option[1] . '_upload';?> button button-primary">Upload</a>
						</td>
						<td>
							<img class="<?php echo $option[1];?>_image" src="<?php echo get_option($option[1]); ?>" height="auto" width="100"/>
							
							<script>
							jQuery(document).ready(function($) {
								$('.<?php echo $option[1] . '_upload';?>').click(function(e) {
									e.preventDefault();
									console.log('Clicked');
									var custom_uploader = wp.media({
										title: 'Custom Image',
										button: {
											text: 'Upload Image'
										},
									multiple: false  // Set this to true to allow multiple files to be selected
								})
									.on('select', function() {
										var attachment = custom_uploader.state().get('selection').first().toJSON();
										$('.<?php echo $option[1];?>_image').attr('src', attachment.url);
										$('.<?php echo $option[1];?>_input').val(attachment.url);

									})
									.open();
								});
							});
							</script>

						<?php } ?>
						<?php if( $option[2] != null ) {?>
						<p class="description"><?php echo $option[2];?></p>
						<?php } ?>
						</td>
					</tr>
					<?php } ?>
				</table>
				<?php if( $heading == 'Instagram API Configuration' || $heading == 'Twitter API Configuration' ) { 
					if(strrpos($heading, 'Instagram') !== false) {
						$uri = "https://instagram.com/oauth/authorize/?client_id=" . get_option('instagram_client_id') . "&redirect_uri=" . home_url() . "/wp-admin/admin.php?page=functions&response_type=token";
					}
					if(strrpos($heading, 'Twitter') !== false) {
						$uri = "https://instagram.com/oauth/authorize/?client_id=" . get_option('instagram_client_id') . "&redirect_uri=" . home_url() . "/wp-admin/admin.php?page=functions&response_type=token";
					}
				?>
					<p class="submit"><a href="<?php echo $uri;?>" class="button button-secondary">Get Access Token</a></p>
				<?php } ?>
			<?php } ?>

			<?php submit_button();?>
			<input type="hidden" name="action" value="update" />
			<input type="hidden" name="page_options" value="<?php echo implode(',', $page_options_string);?>" />
		</form>
	</div>

<?php }