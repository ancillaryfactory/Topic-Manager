<?php

/*

Plugin Name: Topic Manager
Description: Remember and manage post topics for single or multiple authors
Version: 1.5.2
Author: AOA
Author URI: http://www.aoa.org
License: GPL2


Copyright 2011  AOA  (email : jsschwab@aoa.org)

    This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See th
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA


To do:


- function to edit authors from table

- add uninstall function

-find way to show description (notes)

*/


// Add settings link on plugin page

function topics_settings_link($links) { 
  $settings_link = '<a href="admin.php?page=topics">Settings</a>'; 
  array_unshift($links, $settings_link); 
  return $links; 
}

 
$plugin = plugin_basename(__FILE__); 
//add_filter("plugin_action_links_$plugin", 'topics_admin_actions' );


function topic_activate() {
	global $wpdb;
	$table_name = $wpdb->prefix . "topic_manager";
	if($wpdb->get_var("show tables like '$table_name'") != $table_name)
	{
			$sql = "CREATE TABLE $table_name (
			id mediumint(9) NOT NULL AUTO_INCREMENT,
			topic text,
			description text,
			date varchar(16) DEFAULT NULL,
			status varchar(20) DEFAULT NULL,
			author varchar(40) DEFAULT NULL,
			format varchar(100) DEFAULT NULL,
			PRIMARY KEY (id)
			);";
			
			require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
			dbDelta($sql);
 
		$insertedTopic = $wpdb->insert( $table_name, array( 'topic' => 'My first topic', 'description' => 'Here is the description', 'status' => 'open'), array( '%s', '%s' ) );
	
	}
}

if ( !is_admin() ) {
	include 'frontend-template.php';
}


//////////////////////////////// Admin Settings///////////////////////////////////////////////////////

function topics_admin() {   
?>
<!-- Success Messages -->
<?php if (!empty($_POST['editTopic'])) { ?>
<div class="updated fade"><p><strong><?php _e('Topic updated.' ); ?></strong></p></div>  
<?php } ?>

<?php if (isset($_POST['sendSubmit'])) { ?>
<div class="updated fade"><p><strong><?php _e('Message sent.' ); ?></strong></p></div>  
<?php } ?>

<?php if (!empty($_POST['topic'])) { ?>
<div class="updated fade"><p><strong><?php _e('New topic added.' ); ?></strong></p></div>  
<?php } ?>
<!-- End Success Messages -->




<?php

global $wpdb;
$table_name = $wpdb->prefix . "topic_manager"; 

$countAll = $wpdb->get_results( "SELECT COUNT(id) as countAll FROM $table_name",ARRAY_A );

$countOpen = $wpdb->get_results( "SELECT COUNT(id) as countOpen FROM $table_name WHERE status = 'open' OR status = 'in progress'",ARRAY_A );

$countClosed = $wpdb->get_results( "SELECT COUNT(id) as countClosed FROM $table_name WHERE status = 'closed'",ARRAY_A );

 ?> 
 
  <div class="wrap"> 
  <div id="icon-plugins" class="icon32" style="float:left"></div>
<h2>Topic Manager</h2>

<div id="statusTableForm">
<strong>Show Topics:</strong> <a href="admin.php?page=topics&status=all">All</a> (<?php print $countAll[0]['countAll'] ?>)
| <a href="admin.php?page=topics&status=open">Open</a> (<?php print $countOpen[0]['countOpen'] ?>) | <a href="admin.php?page=topics&status=closed">Closed</a> (<?php print $countClosed[0]['countClosed'] ?>)

<div id="optionMenu">
	<a href="#" id="addNewLink">Add new topic</a>&nbsp;|
	<a href="#" id="sendMessageLink">Send a message to an author</a>
	</div>
</div>




<?php 
	// shows open or in progress topics by default, or shows individual statuses if postback from top form
 
  $status = $_GET['status'];
if (isset($_GET['status'])) {
		
	if ($status=='open') {
		$results = $wpdb->get_results( "SELECT * FROM $table_name WHERE status = 'open' OR status = 'in progress' ORDER BY id DESC" );
	} elseif ($status=='closed') {
		$results = $wpdb->get_results( "SELECT * FROM $table_name WHERE status = 'closed' ORDER BY id DESC" );
	} elseif ($status=='progress') {
		$results = $wpdb->get_results( "SELECT * FROM $table_name WHERE status = 'in progress' ORDER BY id DESC" );
	} elseif ($status=='all') {
		$results = $wpdb->get_results( "SELECT * FROM $table_name ORDER BY id DESC" );
	}
		
   } else { // if no status is speficied via $_GET
		$results = $wpdb->get_results( "SELECT * FROM $table_name WHERE status = 'open' OR status = 'in progress' ORDER BY id DESC" );
   }
  
  

 ?>
	
	
	<div id="addTopicForm">
	<h3>Add New Topic</h3>
	<form id="newTopic" method="post" action="admin.php?page=topics">
		<p><label>Topic:</label><br/>
		<input type="text" name="topic" style="width:500px"/></p>
		
		<p><label>Notes:</label><br/>
			<textarea name="description" cols="65" rows="3"></textarea></p>
			
		<p style="float:left;margin-top:0px;margin-right:40px"><label>Format:</label><br/>
		<input type="text" name="format" style="width:200px"/></p>
		
		<p><label>Date to Publish:</label><br/>
		<input type="text" name="date" class="datePicker" style="width:200px"/></p>
		
		<p><label>Assigned Author(s):</label><br/>
		<input type="text" name="author" style="width:200px"/></p>
		
		<input type="submit" name="addTopic" value="Add topic" />&nbsp;&nbsp;<a href="#" id="cancelAdd">Cancel</a>
		
	</form>
	</div> <!-- end addTopicForm -->
	
	
	<!-- Send Message Form -->
	<div id="sendMessageForm">
	<h3>Send Message</h3>
	<form id="sendMessage" method="post" action="admin.php?page=topics">
		<p><label>To:</label>&nbsp;
		<?php wp_dropdown_users(); ?></p>
		
		<p><label>Subject:</label>&nbsp;
		<input type="text" name="subject" style="width:400px"/></p>
		
		<p><label>Message:</label><br/>
			<textarea name="message" cols="65" rows="5"></textarea></p>
			
		
		<input type="submit" name="sendSubmit" value="Send" />&nbsp;&nbsp;<a href="#" id="cancelSend">Cancel</a>
		
	</form>
	</div> <!-- end sendMessageForm -->
	
	
	<!-- End Send Message Form -->
	
<?php if (!isset($_GET['topic'])) { ?> <!-- don't show table on topic edit pages -->	
	<!-- Main Table starts here -->
	<table class="widefat" cellpadding="15" id="topicTable">
		<thead>
		<tr id="topicTableHeader">
			<th width="250"><strong>Topic</strong></th>
			<th width="150"><strong>Format</strong></th>
			<th width="100"><strong>Publish Date</strong></th>
			<th width="100"><strong>Status</strong></th>
			<th width="200"><strong>Author</strong></th>
		</tr>
		</thead>
	
		<tbody>
		
	<?php foreach ($results as $row) { 	
		$authorID = $row->author;
		$id = $row->id;
		// converts userID from dropdown to user_nicename
		$authorName = $wpdb->get_results( "SELECT user_nicename FROM wp_users, $table_name WHERE wp_users.ID = author AND $table_name.id = '$authorID'", ARRAY_A );

		?>
		<!-- <pre><?php// print_r($_GET); ?></pre> -->
	
		<tr>
		<form method="post" action="admin.php?page=topics" id="topicForm<?php print $id; ?>">
		<input type="hidden" name="id" value="<?php print $id; ?>" />
			<td style="padding:5px">
				<a href="admin.php?page=topics&topic=<?php print $id; ?>"><?php print stripslashes($row->topic); ?></a>
			</td>
			<td style="padding:5px"><?php print $row->format; ?></td>
			<td style="padding:5px"><?php print $row->date; ?></td>
			<td style="padding:5px"><?php print $row->status; ?></td>
			<td style="padding:5px" id="authorName"><?php print $row->author; ?></td>

		</form>
		</tr>
		<?php } ?>
		</tbody>
	</table>
	<?php if (!$results) {
		print '<p style="margin-left:10px">No topics to display.</p>';
	} ?>
	
	
	<div style="height:40px"></div>
	<?php }  // end if statement ?>
<?php
	// edit form here
if (isset($_GET['topic'])) {
	global $wpdb;
	$table_name = $wpdb->prefix . "topic_manager"; 
	$editID = $_GET['topic'];
	$editDetails = $wpdb->get_results( "SELECT * FROM $table_name WHERE id = '$editID' ", ARRAY_A );
	
	$status = $editDetails[0]['status'];
	$adminURL = admin_url();
?>
	<hr/>
	
	<h3>Edit Topic</h3>
	<form method="post" action="admin.php?page=topics" id="editForm">
		<input type="hidden" name="id" value="<?php print $editDetails[0]['id'];?>" />
		<p><label>Topic:</label><br/>
		<input type="text" name="editTopic" style="width:500px" value="<?php print stripslashes($editDetails[0]['topic']); ?>"/></p>
		
		<p><label>Notes:</label><br/>
			<textarea name="description" cols="60" rows="3"><?php print stripslashes($editDetails[0]['description']); ?></textarea>
		</p>
		
		<p><label>Status:</label><br/>
		<select name="status">
	
			<option value="open" <?php if ($status == 'open') { ?> selected <?php } ?>>open</option>
			
			<option value="in progress" <?php if ($status == 'in progress') { ?> selected <?php } ?>>in progress</option>
			
			<option value="closed" <?php if ($status == 'closed') { ?> selected <?php } ?>>closed</option>
		</select>
		</p>
		
		<p style="float:left;margin-top:0px;margin-right:40px"><label>Format:</label><br/>
		<input type="text" name="format" style="width:200px" value="<?php print stripslashes($editDetails[0]['format']); ?>"/></p>
		
		<p><label>Date to Publish:</label><br/>
		<input type="text" name="date" class="datePicker" style="width:200px" value="<?php print stripslashes($editDetails[0]['date']); ?>"/></p>
		
		<p><label>Assigned Author(s):</label><br/>
		<input type="text" name="author" style="width:200px" value="<?php print stripslashes($editDetails[0]['author']); ?>"/></p>
		
		<input type="submit" name="editSubmit" value="Update" />&nbsp;
		<a href="<?php print $adminURL; ?>admin.php?page=topics">Cancel</a>&nbsp;&nbsp;
		<input type="submit" name="deleteSubmit" id="deleteSubmit" value="Delete this topic" />
		
	</form>
	
<?php 

}
// end edit form
	
?>	
	
	</div> <!-- end wrap -->
 <?php
  
 // echo "<pre>"; print_r($_GET); echo "</pre>";
 
} 
// end main function

////////////////// ADD TOPIC FORM /////////////////////////////////////////////////
function processTopic() {
	
	$topic = $_POST['topic'];
	$description = $_POST['description'];
	$date = $_POST['date'];
	$format = $_POST['format'];
	$author = $_POST['author'];
		
	global $wpdb;
	$table_name = $wpdb->prefix . "topic_manager"; 
	
	if (!empty($topic)) {
	$insertedTopic = $wpdb->insert( $table_name, array( 'topic' => $topic, 'description' => $description, 'status' => 'open', 'date' => $date, 'format' => $format, 'author' => $author), array( '%s', '%s', '%s', '%s', '%s' ) );
	}
	
	// check for affected rows
}
/////////////////// END ADD TOPIC FORM //////////////////////////////////////////////////////

////////////////// DELETE TOPIC FORM /////////////////////////////////////////////////
function deleteTopic() {
		
	global $wpdb;
	$table_name = $wpdb->prefix . "topic_manager"; 
	$topicID = $_POST['id'];
	
	$wpdb->query("DELETE FROM $table_name WHERE id = '$topicID'");
	
	
}
/////////////////// END DELETE TOPIC FORM //////////////////////////////////////////////////////


////////////////// ADD AUTHOR TO TOPIC FORM /////////////////////////////////////////////////

function updateAuthor() {
	global $wpdb;
	$topicID = $_POST['id'];
	$author = $_POST['user'];

	 $wpdb->update( '$table_name', 
		array( 'author' => $author), 
		array( 'id' => $topicID )
		);

}

function updateTopic() {
	global $wpdb;
	$table_name = $wpdb->prefix . "topic_manager"; 
	$topicID = $_POST['id'];
	$description = $_POST['description'];
	$status = $_POST['status'];
	$format = $_POST['format'];
	$date = $_POST['date'];
	$author = $_POST['author'];
	$editTopic = $_POST['editTopic'];

	if (!empty($editTopic)) {
	 $wpdb->update( $table_name, 
		array( 'topic' => $editTopic, 'description' => $description, 'status' => $status, 'format' => $format, 'date' => $date, 'author' => $author), 
		array( 'id' => $topicID )
		);
	}	
	// check for affected rows
}


////////////////// END ADD AUTHOR TO TOPIC FORM /////////////////////////////////////////////////


////////////////////// SEND AUTHOR MESSAGE ////////////////////////////////////////////
function sendAuthorMessage() {
	$message = $_POST['message'];
	$user = $_POST['user'];
	$subject = $_POST['subject'];
	
	// get user's email from id
	$userInfo = get_userdata( $user );
	$email = $userInfo->user_email;
	
	$headers= "MIME-Version: 1.0\n" .
        "From: <OptometryStudents.com>" . $fromAddress . "\n" .
        "Content-Type: text/html; charset=\"" .
		get_option('blog_charset') . "\"\n";
  
		wp_mail($email, $subject, $message, $headers);
}

////////////////////// END SEND AUTHOR MESSAGE ///////////////////////////////////////


if (isset($_POST['topic'])) {
	add_action('admin_init', 'processTopic');
}

if (isset($_POST['authorSubmit'])) {
	add_action('admin_init', 'updateAuthor');
}

if (isset($_POST['editSubmit'])) {
	add_action('admin_init', 'updateTopic');
}

if (isset($_POST['sendSubmit'])) {
	add_action('admin_init', 'sendAuthorMessage');
}

if (isset($_POST['deleteSubmit'])) {
	add_action('admin_init', 'deleteTopic');
}


function topics_admin_actions() {  
	$page = add_menu_page( "Topic Manager", "Topic Manager", "edit_posts", "topics", "topics_admin", "", 30 ); 
	add_action( "admin_print_scripts", 'topics_admin_js' );
	add_action( "admin_print_styles-$page", 'topics_admin_register_head' );
	
}  

function topics_admin_register_head() {
	$pluginfolder = get_bloginfo('url') . '/' . PLUGINDIR . '/' . dirname(plugin_basename(__FILE__));
	wp_enqueue_style('jquery.ui.theme', $pluginfolder . '/smoothness/jquery-ui-1.8.12.custom.css');
	wp_enqueue_style('topicStyle', $pluginfolder . '/topics.css');
	
}


// adds jQuery UI datepicker
function topics_admin_js() {
	$pluginfolder = get_bloginfo('url') . '/' . PLUGINDIR . '/' . dirname(plugin_basename(__FILE__));
	wp_enqueue_script('jquery-ui-datepicker', $pluginfolder . '/jquery.ui.datepicker.min.js', array('jquery', 'jquery-ui-core'), 1, true );
	wp_enqueue_script('topics-js', $pluginfolder . '/topics.js', 'jquery', 1.0, true );
	
}


add_action('admin_menu', 'topics_admin_actions');

register_activation_hook( __FILE__, 'topic_activate' );


/////////////////////// ADD LINK TO ADMIN BAR ////////////////////////////

add_action("admin_bar_menu", "topics_customize_menu");

function topics_customize_menu(){
    global $wp_admin_bar;

    $wp_admin_bar->add_menu(array(
		"id" => "topic_menu",
		"title" => "Topic Manager",
		"href" => admin_url("admin.php?page=topics")
	));
}
//////////////////////// END ADMIN BAR /////////////////////////////////////



/*
// Create the function to output the contents of our Dashboard Widget

function topic_manager_dashboard_widget_function() {
	// Display whatever it is you want to show
	echo "Table of open topics";
} 

// Create the function use in the action hook

function topic_manager_add_dashboard_widgets() {
	wp_add_dashboard_widget('topic_manager_dashboard_widget', 'Topic Manager', 'topic_manager_dashboard_widget_function');	
} 

// Hook into the 'wp_dashboard_setup' action to register our other functions

add_action('wp_dashboard_setup', 'topic_manager_add_dashboard_widgets' );

*/