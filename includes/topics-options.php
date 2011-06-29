<?php 
//////////////////////// SETTINGS PAGE /////////////////////////////////////
 
	
function topic_manager_options() {
	 if($_POST['topics_updated'] == 'Y') {  
        //Form data sent  

		$topicsShowInAdminBar = $_POST['topicsShowInAdminBar'];  
        update_option('topicsShowInAdminBar', $topicsShowInAdminBar);

		
        ?>  
        <div class="updated fade"><p><strong><?php _e('Options saved.' ); ?></strong></p></div>  
        <?php 
    } else {  
        //Normal page display  
		
		$topicsShowInAdminBar = get_option('topicsShowInAdminBar'); 
    } 

	if (!current_user_can('manage_options'))  {
		wp_die( __('You do not have sufficient permissions to access this page.') );
	} ?>	
	<div class="wrap">
		<h2>Settings - Topic Manager</h2>
		<form name="topics_options_form" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">  
		<input type="hidden" name="topics_updated" value="Y">  
	
		<p><input type="checkbox" name="topicsShowInAdminBar" value="yes" 
		<?php if ($topicsShowInAdminBar=='yes') { ?> checked <?php } ?> /> Show Topic Manager link in Admin Bar</p>
		
		
		<p class="submit">  
        <input class="button-primary" type="submit" name="Submit" value="<?php _e('Update Options') ?>" />  
        </p>  
	
	</form>
	</div> <!-- end .wrap -->
<?php }


//////////////////////// END SETTINGS PAGE /////////////////////////////////////