
/*
|--------------------------------------------------------------------------
| ADDED BY: John Eiman Mission
| DATE ADDED: July 13, 2016
|--------------------------------------------------------------------------
|
*/

// FUNCTION FOR DASHBOARD DIGITAL CLOCK
function updateClock(){
	var currentTime = new Date ( );
  	var currentHours = currentTime.getHours ( );
  	var currentMinutes = currentTime.getMinutes ( );
  	var currentSeconds = currentTime.getSeconds ( );

  	// Pad the minutes and seconds with leading zeros, if required
  	currentMinutes = ( currentMinutes < 10 ? "0" : "" ) + currentMinutes;
  	currentSeconds = ( currentSeconds < 10 ? "0" : "" ) + currentSeconds;

  	// Choose either "AM" or "PM" as appropriate
  	var timeOfDay = ( currentHours < 12 ) ? "AM" : "PM";

  	// Convert the hours component to 12-hour format if needed
  	currentHours = ( currentHours > 12 ) ? currentHours - 12 : currentHours;

  	// Convert an hours component of "0" to "12"
  	currentHours = ( currentHours == 0 ) ? 12 : currentHours;

  	// Compose the string for display
  	var currentTimeString = currentHours + ":" + currentMinutes + ":" + currentSeconds + " " + timeOfDay;
  	
  	
   	$("#clock").html(currentTimeString);
}
n = 0;
function progressBar(){
	$('#progressbar').css({
		width: n+"%"
	});;
	n+=8;
}
$(document).ready( function(){
	updateClock();
	$('#body').on('focus', function(){
		$('#submit-post').removeAttr('disabled');
		$('#body').attr({
			rows: "5"
		});
	}).on('focusout', (function() {
		if($('#body').val()){
			$('#submit-post').removeAttr('disabled');
			$('#body').attr({
				rows: "5"
			});
		}
		else{
			$('#submit-post').attr('disabled', 'disabled');
			$('#body').attr({
				rows: "2"
			});
		}
	}));

	$('#loginclass, #breakclass, #stopbreakclass, #logoutclass').on("contextmenu",function(){
       return false;
    });
	$('#submit-post').on('click', function(){
		if($('#body').val()){
			event.preventDefault();
			$( "#body" ).prop( "disabled", true );
			$.ajax({
			  url: createPostUrl,
			  type: 'POST',
			  dataType: 'json',
			  data: {body:  $('#body').val(), _token: token},
			  complete: function(xhr, textStatus) {
			    //called when complete
			    console.log(textStatus);
			    console.log(xhr);
			  },
			  success: function(data, textStatus, xhr) {
			  	$('#submit-post').attr('disabled', 'disabled');

			  	// USE THIS FOR POSTING WITHOUT PAGE REFRESH
			 	$( "#body" ).prop( "disabled", false );
				$( "#body" ).val('');
				$('.post').closest('div#all-posts').prepend('<div class="post"><img class="img-circle dashboardpicture" src="/images/employees/profile_photo/'
					+ data['image'] + '"/><span class="disable"><strong>'
					+ data['employeename'] + '</strong><br/>'
					+ data['date'] + '</span><div class="well disable" id="'+ data['id']
					+ '"><span class="postbody"><a href="#" id="delete'+ data['id']
					+'"><span onclick="deleteRecentPost(this)" class="glyphicon glyphicon-trash deletelink" id="' + data['id']
					+ '"></span></a><a href="#" id="' + data['id']
					+ '"><span onclick="editRecentPost(this)" class="glyphicon glyphicon-edit editlink" id="' 
					+ data['id'] + '"></span></a><span id="post' + data['id'] + '">'
					+ data['post'] + '</span></div></span></span><hr/></div></div>');
				$('#body').attr({
					rows: "2"
				});
			  },
			  error: function(xhr, textStatus, errorThrown) {
			    //called when there is an error
			  }
			});
		}
		else{
			event.preventDefault();
		}
	});
	
	$('.well.disable').find('.postbody').find('.glyphicon.glyphicon-edit.editlink').on('click', function(){
		postId = this.id;
		event.preventDefault();
		$('#edit-modal').modal();
		// $('html, body').addClass('modalOverlay');
		$('#post-body').val($('span#post' + this.id).html());
	});

	$('.well.disable').find('.postbody').find('.glyphicon.glyphicon-trash.deletelink').on('click', function(){
		postId = this.id;
		event.preventDefault();
		// $('html, body').addClass('modalOverlay');
		$('#delete-modal').modal();
	});
	
	$('.well.disable').on('mouseover', function(){
		$('.well.disable').find('.postbody').find('#edit' + this.id).show();
	}).on('mouseout', function(){
		$('.well.disable').find('.postbody').find('#edit' + this.id).hide();
	});

	$('.well.disable').on('mouseover', function(){
		$('.well.disable').find('.postbody').find('#delete' + this.id).show();
	}).on('mouseout', function(){
		$('.well.disable').find('.postbody').find('#delete' + this.id).hide();
	});

	$('#modal-save').on('click', function(){
		console.log(postId);
		if($('#post-body').val()){
			$( "#post-body" ).prop( "disabled", true );
			$.ajax({
			  url: editPostUrl,
			  type: 'POST',
			  dataType: 'json',
			  data: {body:  $('#post-body').val(), _token: token, postId: postId},
			  complete: function(xhr, textStatus) {
			  },
			  success: function(msg) {
			    $( "#post-body" ).prop( "disabled", false );
				$('span#post' + postId).html(msg['edited']);
				$('#edit-modal').modal('hide');
				console.log(msg);
				// $('html, body').removeClass('modalOverlay');
			  },
			  error: function(xhr, textStatus, errorThrown) {
			    //called when there is an error
			  }
			});
		}
	});

	$('#modal-delete').on('click', function(){
		event.preventDefault();
		$.ajax({
			url: deletePostUrl,
			type: 'POST',
			dataType: 'json',
			data: {_token: token, postId: postId},
			complete: function(xhr, textStatus) {
			},
			success: function(msg) {
				$('#' + postId).closest('.post').remove();
				$('#delete-modal').modal('hide');
			  	// $('html, body').removeClass('modalOverlay');
			},
			error: function(xhr, textStatus, errorThrown) {
				//called when there is an error
			}
		});
	});

	$( "button[data-dismiss='modal']" ).on('click', function(){
		$('html, body').removeClass('modalOverlay');
	});

	$('.well.disable').find('.postbody').find('.glyphicon.glyphicon-edit.editlink').on('click', function(){
		postId = this.id;
		event.preventDefault();
		$('#edit-modal').modal();
		$('body').attr('style', 'overflow: hidden;');
		$('#post-body').val($('span#post' + this.id).html());
	});

	$('#printbtn').click(function() {
		$('.to-be-printed').show();
		$('#table-responsive').removeAttr('style');
		$('#table-responsive').removeAttr('class');
		$('table').attr('style', 'font-size:12px');
		$('#printbtn').hide();
		$('#employee-name').html($('small').first().html());
		var printed = $('#test').html();
		$('#table-responsive').attr('style', 'height:300px');
		$('#table-responsive').attr('class', 'table-responsive');
		$('table').removeAttr('style');
		$('.to-be-printed').hide();
		var x=window.open();
		x.document.open();
		x.document.write("<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css' integrity='sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7' crossorigin='anonymous'>\n<script src='https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js'></script>" +'<div class="container">'+ printed + '</div>' + '<script>\n$("span").removeClass();\nsetTimeout(function(){window.print();},500);</script>');
		x.document.close();
		$('.to-be-printed').hide();
		location.href = location.href;
	});
});