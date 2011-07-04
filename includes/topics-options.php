<?php 
//////////////////////// SETTINGS PAGE /////////////////////////////////////
 
	
function topic_manager_options() {
	 if($_POST['topics_updated'] == 'Y') {  
        //Form data sent  

		$topicsShowInAdminBar = $_POST['topicsShowInAdminBar'];  
        update_option('topicsShowInAdminBar', $topicsShowInAdminBar);
		
		$topicManagerPermission = $_POST['topicManagerPermission'];  
        update_option('topicManagerPermission', $topicManagerPermission);
		
		$topicManagerAuthorMode = $_POST['topicManagerAuthorMode'];  
        update_option('topicManagerAuthorMode', $topicManagerAuthorMode);
		
        ?>  
        <div class="updated fade"><p><strong><?php _e('Options saved.' ); ?></strong></p></div>  
        <?php 
    } else {  
        //Normal page display  
		
		$topicsShowInAdminBar = get_option('topicsShowInAdminBar');
		$topicManagerPermission = get_option('topicManagerPermission');
		$topicManagerAuthorMode = get_option('topicManagerAuthorMode');  		
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
		
		<div style="height:30px">&nbsp;</div>
		
		<h3>Permission to use Topic Manager administrator functions</h3>
	
		 <label>
    <input type="radio" name="topicManagerPermission" value="author" id="status_0"
	<?php if ($topicManagerPermission=='author') {?> checked <?php } ?> />
    Authors and Administrators</label>
  <br>
  <label>
    <input type="radio" name="topicManagerPermission" value="admin" id="status_1"
	<?php if ($topicManagerPermission=='admin') {?> checked <?php } ?> />
    Administrators only</label>
		
		<div style="height:30px">&nbsp;</div>
		
		
		<h3>Author mode</h3>
		
		 <label>
    <input type="radio" name="topicManagerAuthorMode" value="single" id="mode_0"
	<?php if ($topicManagerAuthorMode=='single') {?> checked <?php } ?> />
    Single author mode</label>
  <br>
  <label>
    <input type="radio" name="topicManagerAuthorMode" value="multi" id="mode_1"
	<?php if ($topicManagerAuthorMode=='multi') {?> checked <?php } ?> />
    Multi-author mode <em>(adds Author field to each topic and allows admins to email other authors)</em></label>
	
	<div style="height:30px">&nbsp;</div>
	
		
		<p class="submit">  
        <input class="button-primary" type="submit" name="Submit" value="<?php _e('Update Options') ?>" />  
        </p>  
	
	</form>
	</div> <!-- end .wrap -->
<?php }


//////////////////////// END SETTINGS PAGE /////////////////////////////////////