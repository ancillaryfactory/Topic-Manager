<?php 
//////////////////////// SETTINGS PAGE /////////////////////////////////////
 
	
function topic_manager_options() {
	 if($_POST['topics_updated'] == 'Y') {  
        //Form data sent  

		$topicsShowInAdminBar = $_POST['topicsShowInAdminBar'];  
        update_option('topicsShowInAdminBar', $topicsShowInAdminBar);
		
		$topicManagerPermission = $_POST['topicManagerPermission'];  
        update_option('topicManagerPermission', $topicManagerPermission);
		

		
        ?>  
        <div class="updated fade"><p><strong><?php _e('Options saved.' ); ?></strong></p></div>  
        <?php 
    } else {  
        //Normal page display  
		
		$topicsShowInAdminBar = get_option('topicsShowInAdminBar');
		$topicManagerPermission = get_option('topicManagerPermission'); 		
    } 

	if (!current_user_can('manage_options'))  {
		wp_die( __('You do not have sufficient permissions to access this page.') );
	} ?>	
	<div class="wrap">
		<h2>Settings - Topic Manager</h2>
		<form name="topics_options_form" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">  
		<input type="hidden" name="topics_updated" value="Y">  
		
		<h3>Admin bar</h3>
		<p><input type="checkbox" name="topicsShowInAdminBar" value="yes" 
		<?php if ($topicsShowInAdminBar=='yes') { ?> checked <?php } ?> /> Show Topic Manager link in Admin Bar</p>
		
		<h3>Permission to use Topic Manager administrator functions</h3>
	
		 <label>
    <input type="radio" name="topicManagerPermission" value="publish_posts" id="status_0"
	<?php if ($topicManagerPermission=='upload_files') {?> checked <?php } ?> />
    Authors and Administrators</label>
  <br>
  <label>
    <input type="radio" name="topicManagerPermission" value="manage_options" id="status_1"
	<?php if ($topicManagerPermission=='manage_options') {?> checked <?php } ?> />
    Administrators only</label>
		
		<p class="submit">  
        <input class="button-primary" type="submit" name="Submit" value="<?php _e('Update Options') ?>" />  
        </p>  
	
	</form>
	</div> <!-- end .wrap -->
<?php }


//////////////////////// END SETTINGS PAGE /////////////////////////////////////