jQuery(document).ready(function(){
		jQuery('.datePicker').datepicker({
			dateFormat : 'mm/dd/yy'
		});
		
		// shows/hides add new topic form
		jQuery('#addNewLink').click(function() {
			jQuery('#sendMessageForm').slideUp();
			jQuery('#addTopicForm').slideToggle();
			return false;
		});
		
		jQuery('#sendMessageLink').click(function() {
			jQuery('#addTopicForm').slideUp();
			jQuery('#sendMessageForm').slideToggle();
			return false;
		});
		
		
		jQuery('#cancelAdd').click(function() {
			jQuery('#addTopicForm').slideUp();
			return false;
		});
		
		jQuery('#cancelSend').click(function() {
			jQuery('#sendMessageForm').slideUp();
			return false;
		});
		
		// adds main table stripe on hover
		jQuery('#topicTable tr').hover(
		function() {
			jQuery(this).addClass('rowHover');
			jQuery(this).find('.topicEditLink').show();
		},
		function() {
			jQuery(this).removeClass('rowHover');
			jQuery(this).find('.topicEditLink').hide();
		}
		);
		
		jQuery('#deleteSubmit').click(function() {
			var answer = confirm('Delete this topic?');
			if (!(answer)) { return false };
		});
		
		jQuery('a.descriptionLink').click(function() {
			jQuery(this).parent().parent().toggleClass('topicOpenRow');
			jQuery(this).parent().parent().next('tr.topicDescription').toggle();
		});
		
		jQuery('tr.topicDescription').click(function() {
			jQuery(this).hide();
			jQuery(this).prev('tr').removeClass('topicOpenRow');
		});
		
	//	jQuery('#editForm').submit(function() {
    //var content = jQuery('#pearlContent').val();
			
   // if ( content == '') {
	//jQuery('#titleError').show();
   // }


// removes error message
//jQuery('#pearlContent').keyup(function() {
//	var content = jQuery('#pearlContent').val();
//	if ( content != '') {
//		jQuery('#contentError').slideUp();
//	}

		
	});