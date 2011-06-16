<?php

function topics_frontend_table() {
	if ( is_user_logged_in() ) {
		
		// table function goes here
		global $wpdb;
		$table_name = $wpdb->prefix . "topic_manager"; 

		$countAll = $wpdb->get_results( "SELECT COUNT(ID) as countAll FROM $table_name",ARRAY_A );

		$countOpen = $wpdb->get_results( "SELECT COUNT(ID) as countOpen FROM $table_name WHERE status = 'open' OR status = 'in progress'",ARRAY_A );

		$countClosed = $wpdb->get_results( "SELECT COUNT(ID) as countClosed FROM $table_name WHERE status = 'closed'",ARRAY_A ); 

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
		
		<div id="statusTableForm">
			<strong>Show Topics:</strong> <a href="<?php the_permalink()?>?status=all">All</a> (<?php print $countAll[0]['countAll'] ?>) | <a href="<?php the_permalink()?>?status=open">Open</a> (<?php print $countOpen[0]['countOpen'] ?>) | <a href="<?php the_permalink()?>?status=closed">Closed</a> (<?php print $countClosed[0]['countClosed'] ?>)


			<!-- <div id="optionMenu">
				<a href="#" id="addNewLink">Add new topic</a>&nbsp;|
				<a href="#" id="sendMessageLink">Send a message to an author</a>
			</div> -->
		</div>
		
		<!-- <pre><?php // print_r($_GET); ?></pre> -->
		
		
		<!-- Main Table starts here -->
	<table cellpadding="15" id="topicTable" style="width:100%">
		<thead>
		<tr id="topicTableHeader">
			<th><strong>Topic</strong></th>
			<th><strong>Format</strong></th>
			<th><strong>Publish Date</strong></th>
			<th><strong>Status</strong></th>
			<th><strong>Author</strong></th>
		</tr>
		</thead>
	
		<tbody>
		
	<?php
	
	foreach ($results as $row) { 	
		$authorID = $row->author;
		$id = $row->id;
		// converts userID from dropdown to user_nicename
		$authorName = $wpdb->get_results( "SELECT user_nicename FROM wp_users, $table_name WHERE wp_users.ID = author AND $table_name.id = '$authorID'", ARRAY_A );

		?>
		
	
		<tr>
		<form method="post" action="admin.php?page=topics" id="topicForm<?php print $id; ?>">
		<input type="hidden" name="id" value="<?php print $id; ?>" />
			<td style="padding:5px">
				<?php print stripslashes($row->topic); ?>
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

	
	<?php	
		// end table function
	
	} else {  // if user is not logged in  ?>
		<p><a href="<?php echo wp_login_url( get_permalink() ); ?>" title="Login">Login</a> to see the list of available topics.</p>

	<?php }

}