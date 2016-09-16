jQuery(document).ready(function($){

	$('.search-event-drop-link').click( function(e){
		$('.searchdropdown').fadeToggle('1000');
		return false;
	});

	var viewportWidth = $(window).width();
	$('.topMenu .menu-item-has-children > a').click(function(event) {
		if (viewportWidth <= 803 ) {
			$(this).siblings('ul').slideToggle('1000');
			return false;
		}		
	});

	var topMenu = $('.topMenu');
	$('.toggleMenu').click(function(event) {
		topMenu.slideToggle('slow');
		return false;
	});


	// Delete an Event
	$('.trash').click(function(event) {

		if( !confirm('Do you really want to delete this item?') )
			return false;

		var id 	 = $(this).data('id');
		var data = 'eventid=' + id + '&userid=' + user_data.id + '&action=delete';
		var path = user_data.url + "/events";
		var item = $(this);

		$.post(path , data , function(data) {
			if(data.error) {
				alert(data.msg);
			} else {
				item.parents('.list-group-item').fadeOut('fast');
			}
		},'json');

		return false;
	});

	// Added placeholder to the login form
	$('#loginform input[type="text"]').attr('placeholder', 'Username');
	$('#loginform input[type="password"]').attr('placeholder', 'Password');

});