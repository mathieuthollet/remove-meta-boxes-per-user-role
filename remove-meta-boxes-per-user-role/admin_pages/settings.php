<?php
 
	wp_enqueue_script(RMBPUR_PLUGIN_SLUG."-settings", RMBPUR_WEB_PATH."js/settings.js");
	
	global $wp_roles;
	$meta_boxes = array('authordiv' => __("Author", RMBPUR_I18N_DOMAIN)
						, 'categorydiv' => __("Categories", RMBPUR_I18N_DOMAIN)
						, 'commentstatusdiv' => __("Comments status (discussion)", RMBPUR_I18N_DOMAIN)
						, 'commentsdiv' => __("Comments", RMBPUR_I18N_DOMAIN)
						, 'formatdiv' => __("Formats", RMBPUR_I18N_DOMAIN)
						, 'pageparentdiv' => __("Attributes", RMBPUR_I18N_DOMAIN)
						, 'postcustom' => __("Custom fields", RMBPUR_I18N_DOMAIN)
						, 'postexcerpt' => __("Excerpt", RMBPUR_I18N_DOMAIN)
						, 'postimagediv' => __("Featured image", RMBPUR_I18N_DOMAIN)
						, 'revisionsdiv' => __("Revisions", RMBPUR_I18N_DOMAIN)
						, 'slugdiv' => __("Slug", RMBPUR_I18N_DOMAIN)
						, 'submitdiv' => __("Date, status, and update/save", RMBPUR_I18N_DOMAIN)
						, 'tagsdiv-post_tag' => __("Tags", RMBPUR_I18N_DOMAIN)
						, 'trackbacksdiv' => __("Trackbacks ", RMBPUR_I18N_DOMAIN)
					);

	// Manage form submission
	if (isset($_POST["submit"])) {
		foreach ($wp_roles->roles as $role => $wp_role) {
			if (isset($_POST["meta_box_to_remove_".$role]))
				update_option("rmbpur_".$role, json_encode($_POST["meta_box_to_remove_".$role]));
			else
				update_option("rmbpur_".$role, json_encode(array()));
		}
	}
	
	
// Display form
?>
<div class="wrap rmbpur_admin_page">
	<h1><?php _e("Remove Meta Boxes Per User Role", RMBPUR_I18N_DOMAIN); ?></h1>
	<p><?php _e("Remove those meta boxes from new post / edit post pages", RMBPUR_I18N_DOMAIN); ?></p>
	<form method="POST">
		<? foreach ($wp_roles->roles as $role => $wp_role) {
			$checked_meta_boxes = json_decode(get_option("rmbpur_".$role, "")); 
			if (!is_array($checked_meta_boxes))
				$checked_meta_boxes = array();
			?>
			<h2><?php echo $wp_role["name"]?></h2>
				<table class="form-table">
					<tr>
						<th>
							<label for="role"><?php _e("Meta boxes to remove", RMBPUR_I18N_DOMAIN); ?></label>
						</th>
						<td>
							<?php foreach ($meta_boxes as $meta_box => $meta_box_name) { ?>
								<p>
									<label>
										<input type="checkbox" name="meta_box_to_remove_<?php echo $role;?>[]" value="<?php echo $meta_box; ?>" id="<?php echo $role."_".$meta_box; ?>" rel="<?echo $role;?>" <?php echo in_array($meta_box, $checked_meta_boxes) ? "checked" : ""; ?>/>
										<?php _e($meta_box_name, RMBPUR_I18N_DOMAIN); ?>
									</label>
								</p>
							<?php } ?>
							<p>
								<a class="check-all" rel="<?php echo $role;?>" href="#"><?php _e("Check all", RMBPUR_I18N_DOMAIN);?></a>
							</p>
						</td>
					</tr>
				</tbody>
			</table>
		<?php } ?>
		<p class="submit">
			<input type="submit" value="<?php _e("Save", RMBPUR_I18N_DOMAIN); ?>" class="button button-primary" name="submit">
		</p>
	</form>
</div> 
<script type="text/javascript">
	rmbpur_check_all_label = '<?php _e("Check all", RMBPUR_I18N_DOMAIN);?>';
	rmbpur_uncheck_all_label = '<?php _e("Uncheck all", RMBPUR_I18N_DOMAIN);?>';
</script>