
/*
|--------------------------------------------------------------------------
| AUTHOR: Ryan Binas
| DATE CREATED: January 29, 2015
|--------------------------------------------------------------------------
|
*/
var host = 'http://'+top.location.host+"/";
var xhr = null;
$(document).ready( function() {
	
	var d = new Date();
	var hour = d.getHours();

	$( " #form-update-attendance-reference, #form-create-leave, #form-update-leave-details, #form-update-profile-image, #form-create-employee, #form-update-personal-information, #form-update-employee-account-details, #form-update-employee-work-details" ).submit(function( event ) 
	{
		var $this = $(this);
		var data =  $this.serialize();
		var submitBtn = $this.find('.submit');
		var butText = submitBtn.attr('value');
		submitBtn.attr('disabled', 'disabled');
		submitBtn.attr('value', submitBtn.attr('data-svalue') );
		$.post( $this.attr('action') , data, function(data) {
			if( data.error === false ) {
				$this.find('.info-msg').show();
				$this.find('.info-msg .alert-danger').hide();
				$this.find('.info-msg .alert-success .msg').html(data.msg);
				$this.find('.info-msg .alert-success').show();
				if ( data.redirect === true )
				window.location.href = host+data.redirect_to;
			} else {
				$this.find('.info-msg').show();
				$this.find('.info-msg .alert-success').hide();
				$this.find('.info-msg .alert-danger .msg').html(data.msg);
				$this.find('.info-msg .alert-danger').show();
			}
			
			submitBtn.removeAttr("disabled");
			submitBtn.attr('value', butText);
		},"json");
	
		event.preventDefault();
		return false;
	});
	setTimeout(function(){
		$('#table-responsive').animate({ scrollTop: $('#table-responsive').prop("scrollHeight") }, 1500);
	}, 100);
	

	if(document.getElementById("loginbtn").hasAttribute('disabled')) {
		$('#loginclass').hide();
		$('#breakclass').show();
	}
	else {
		 $('#logoutbtn').attr('disabled', 'disabled');
	}

	if(document.getElementById("breakbtn").hasAttribute('disabled')) {
		$('#stopbreakclass').show();
		$('#breakclass').hide();
		breakTime = setInterval(function() {
			$('#breaktimerreload').load(location.href+" #breaktimer");
		},1000);
	}

	if(document.getElementById("stopbreakbtn").hasAttribute('disabled')) {
		clearInterval(breakTime);
		$('#breaktimer').hide();
	}

	if(document.getElementById("logoutbtn").hasAttribute('disabled')) {
		$('#breakbtn').attr('disabled', 'disabled');
		$('#stopbreakbtn').attr('disabled', 'disabled');
	}

	// Employee is allowed to consume break time between 11 AM to 1 PM
	if(hour < 11 || hour > 12) {
		$('#breakbtn').attr('disabled', 'disabled');
	}



/* -------------------------------------------------------------------------------------------------

								FORM TIME IN SUBMIT
	
---------------------------------------------------------------------------------------------------*/
	
	$( ".form-attendance-login" ).submit(function( event ) {
		
		var $this = $(this);
		var data =  $this.serialize();
		var submitBtn = $this.find('.submit');
		var butText = submitBtn.attr('value');
		submitBtn.attr('disabled', 'disabled');
		submitBtn.attr('value', submitBtn.attr('data-svalue') );
		
		$.post( $this.attr('action') , data, function(data) {
			if( data.error === false ) {
				
				if(!(hour < 11 || hour > 12)){
					$('#breakbtn').removeAttr('disabled');
				}
				$('.attendance-record-result .info-msg').show();
				
				$('.attendance-record-result .info-msg .alert-danger').hide();
				$('.attendance-record-result .info-msg .alert-success .msg').html(data.msg);
				$('.attendance-record-result .info-msg .alert-success').show();
				$('#loginclass').hide();
				$('#breakclass').show();
				if(!(hour > 17)){
					$('#logoutbtn').removeAttr("disabled");
				}
				console.log(data);

				// updating attendance info
				var newAttendance = "<li><span class='handle ui-sortable-handle'><i class='fa fa-ellipsis-v'></i><i class='fa fa-ellipsis-v'></i></span><span class='text'>" + data.attendance.day + "</span>";

				if(data.attendance.lates){
					newAttendance += "<small class='label label-warning'>" + data.attendance.status + " " + seconds_to_words(data.attendance.lates) + "</small>";
				}

				newAttendance += "</li>";
				
				$('#boxbody').append(newAttendance);
				$('#total-lates').html(seconds_to_words(data.attendance.lates));

			} else {


				if(!(hour < 11 || hour > 12)){
					$('#breakbtn').removeAttr('disabled');
				}
				$('.attendance-record-result .info-msg').show();
				$('.attendance-record-result .info-msg .alert-success').hide();
				$('.attendance-record-result .info-msg .alert-danger .msg').html(data.msg);
				$('.attendance-record-result .info-msg .alert-danger').show();
				$('#loginclass').hide();
				$('#breakclass').show();
				if(!(hour > 17)){
					$('#logoutbtn').removeAttr("disabled");
				}
			}
			// submitBtn.removeAttr("disabled");
			submitBtn.attr('value', butText);
		},"json");

		event.preventDefault();
		return false;
	});

	$( ".form-attendance-break" ).submit(function( event ) 
	{
		var $this = $(this);
		var data =  $this.serialize();
		var submitBtn = $this.find('.submit');
		var butText = submitBtn.attr('value');
		submitBtn.attr('disabled', 'disabled');
		submitBtn.attr('value', submitBtn.attr('data-svalue') );
		$.post( $this.attr('action') , data, function(data) {
			if( data.error === false ) {
				$('.attendance-record-result .info-msg').show();
				$('#boxbodymain').load(location.href+" #boxbody");
				$('#detailed-data').load(location.href+" #refresh-detailed-data");
				setInterval(function(){
					$('#breaktimerreload').load(location.href+" #breaktimer");
				},1000);
				$('.attendance-record-result .info-msg .alert-danger').hide();
				$('.attendance-record-result .info-msg .alert-success .msg').html(data.msg);
				$('.attendance-record-result .info-msg .alert-success').show();
				$('#stopbreakclass').show();
				$('#breakclass').hide();
				$('#stopbreakbtn').removeAttr("disabled");
				$('#logoutbtn').removeAttr("disabled");

			} else {
				$('.attendance-record-result .info-msg').show();
				$('#boxbodymain').load(location.href+" #boxbody");
				$('#detailed-data').load(location.href+" #refresh-detailed-data");
				setInterval(function(){
					$('#breaktimerreload').load(location.href+" #breaktimer");
				},1000);
				$('.attendance-record-result .info-msg .alert-success').hide();
				$('.attendance-record-result .info-msg .alert-danger .msg').html(data.msg);
				$('.attendance-record-result .info-msg .alert-danger').show();
				// $('#stopbreakclass').show();
				// $('#breakclass').hide();
				$('#stopbreakbtn').removeAttr("disabled");
				$('#logoutbtn').removeAttr("disabled");
			}
			// submitBtn.removeAttr("disabled");
			submitBtn.attr('value', butText);
		},"json");
		event.preventDefault();
		return false;
	});

	$( ".form-attendance-stopbreak" ).submit(function( event ) 
	{
		var $this = $(this);
		var data =  $this.serialize();
		var submitBtn = $this.find('.submit');
		var butText = submitBtn.attr('value');
		submitBtn.attr('disabled', 'disabled');
		submitBtn.attr('value', submitBtn.attr('data-svalue') );
		$.post( $this.attr('action') , data, function(data) {
			if( data.error === false ) {
				$('#breaktimer').hide();
				$('.attendance-record-result .info-msg').show();
				$('#boxbodymain').load(location.href+" #boxbody");
				$('#detailed-data').load(location.href+" #refresh-detailed-data");
				$('.attendance-record-result .info-msg .alert-danger').hide();
				$('.attendance-record-result .info-msg .alert-success .msg').html(data.msg);
				$('.attendance-record-result .info-msg .alert-success').show();
				$('#breakclass').hide();
				$('#stopbreakclass').attr('disabled', 'disabled');
			} else {
				$('#breaktimer').hide();
				$('.attendance-record-result .info-msg').show();
				$('#boxbodymain').load(location.href+" #boxbody");
				$('#detailed-data').load(location.href+" #refresh-detailed-data");
				$('.attendance-record-result .info-msg .alert-success').hide();
				$('.attendance-record-result .info-msg .alert-danger .msg').html(data.msg);
				$('.attendance-record-result .info-msg .alert-danger').show();
				$('#breakclass').hide();
				$('#stopbreakclass').attr('disabled', 'disabled');
			}
			submitBtn.attr('value', butText);
		},"json");
		event.preventDefault();
		return false;
	});

	$( ".form-attendance-logout" ).submit(function( event ) 
	{
		var $this = $(this);
		var data =  $this.serialize();
		var submitBtn = $this.find('.submit');
		var butText = submitBtn.attr('value');
		submitBtn.attr('disabled', 'disabled');
		submitBtn.attr('value', submitBtn.attr('data-svalue') );
		$.post( $this.attr('action') , data, function(data) {
			if( data.error === false ) {
				$('#breaktimer').hide();
				$('.attendance-record-result .info-msg').show();
				$('#boxbodymain').load(location.href+" #boxbody");
				$('#detailed-data').load(location.href+" #refresh-detailed-data");
				$('.attendance-record-result .info-msg .alert-danger').hide();
				$('.attendance-record-result .info-msg .alert-success .msg').html(data.msg);
				$('.attendance-record-result .info-msg .alert-success').show();
				// $('#loginbtn').attr('disabled', 'disabled');
				$('#logoutbtn').attr('disabled', 'disabled');
				$('#breakbtn').attr('disabled', 'disabled');
				$('#stopbreakbtn').attr('disabled', 'disabled');
			} else {
				$('#breaktimer').hide();
				$('.attendance-record-result .info-msg').show();
				$('#boxbodymain').load(location.href+" #boxbody");
				$('#detailed-data').load(location.href+" #refresh-detailed-data");
				$('.attendance-record-result .info-msg .alert-success').hide();
				$('.attendance-record-result .info-msg .alert-danger .msg').html(data.msg);
				$('.attendance-record-result .info-msg .alert-danger').show();
				// $('#loginbtn').attr('disabled', 'disabled');
				$('#logoutbtn').attr('disabled', 'disabled');
				$('#breakbtn').attr('disabled', 'disabled');
				$('#stopbreakbtn').attr('disabled', 'disabled');
			}
			// submitBtn.removeAttr("disabled");
			submitBtn.attr('value', butText);
		},"json");
		event.preventDefault();
		return false;
	});
	
	$( "#form-login" ).submit(function( event ) {
		var data =  $(this).serialize();
		var submitBtn = $('#form-login .submit');
		var butText = submitBtn.attr('value');
		submitBtn.attr('disabled', 'disabled');
		submitBtn.attr('value', submitBtn.attr('data-svalue') );

		$.post(host+'login', data, function(data) {
			if( data.error === false ) {
				$('.info-msg').show();
				$('.info-msg .alert-danger').hide();
				$('.info-msg .alert-success .msg').html(data.msg);
				$('.info-msg .alert-success').show();
				// if ( data.redirect === true )
				// window.location.href = host+data.redirect_to;
			} else {
				$('.info-msg').show();
				$('.info-msg .alert-success').hide();
				$('.info-msg .alert-danger .msg').html(data.msg);
				$('.info-msg .alert-danger').show();
			}
			submitBtn.removeAttr("disabled");
			submitBtn.attr('value', butText);
		},"json");
		event.preventDefault();
		return false;
	});


	$( "#form-forgot-password" ).submit(function( event ) {
		var data =  $(this).serialize();
		var submitBtn = $('#form-forgot-password .submit');
		var butText = submitBtn.attr('value');
		submitBtn.attr('disabled', 'disabled');
		submitBtn.attr('value', submitBtn.attr('data-svalue') );

		$.post(host+'recover/password', data, function(data) {
			if( data.error === false ){
				$('.info-msg').show();
				$('.info-msg .alert-danger').hide();
				$('.info-msg .alert-success .msg').html(data.msg);
				$('.info-msg .alert-success').show();
				if ( data.redirect === true )
				window.location.href = host+data.redirect_to;
			} else {
				$('.info-msg').show();
				$('.info-msg .alert-success').hide();
				$('.info-msg .alert-danger .msg').html(data.msg);
				$('.info-msg .alert-danger').show();
			}
			submitBtn.removeAttr("disabled");
			submitBtn.attr('value', butText);
		},"json");
		event.preventDefault();
		return false;
	});


	$( "#form-forgot-password-new" ).submit(function( event ) {
		var data =  $(this).serialize();
		var submitBtn = $('#form-forgot-password-new .submit');
		var butText = submitBtn.attr('value');
		submitBtn.attr('disabled', 'disabled');
		submitBtn.attr('value', submitBtn.attr('data-svalue') );

		$.post(host+'forgot/password/new_password', data, function(data) {
			if( data.error === false ){
				$('#form-forgot-password-new input[type="password"]').hide();
				$('#form-forgot-password-new .form-login-heading').hide();
				submitBtn.hide();
				$('#form-forgot-password-new .login').show();


				$('.info-msg').show();
				$('.info-msg .alert-danger').hide();
				$('.info-msg .alert-success .msg').html(data.msg);
				$('.info-msg .alert-success').show();
				if ( data.redirect === true )
				window.location.href = host+data.redirect_to;
			} else {
				$('.info-msg').show();
				$('.info-msg .alert-success').hide();
				$('.info-msg .alert-danger .msg').html(data.msg);
				$('.info-msg .alert-danger').show();
			}
			submitBtn.removeAttr("disabled");
			submitBtn.attr('value', butText);
		},"json");
		event.preventDefault();
		return false;
	});
});


function seconds_to_words(seconds){

	var sec = parseInt(seconds);
	var min = 0;
	var hr = 0;

	if( sec >3600 ){
		hr = parseInt(sec / 3600)
		sec = sec - ( hr * 3600);
	}

	if( sec > 60 ){
		min = parseInt(sec / 60)
		sec = sec - ( min * 60 );
	}

	return hr + "hours " + min + " mins " + sec +" secs";

}