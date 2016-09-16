<!--	Added by John Eiman Mission
		July 4, 2016
 -->
<?php $birthday_counter = 0;
?>
@extends('layouts.dashboard')
@section('content')
<section class="content-header">
	<h1>
		<small>{{ ucwords($emp->firstname.' '.$emp->lastname) }}</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="/employee/dashboard"><i class="fa fa-home"></i> Dashboard</a></li>
	</ol>
</section>
<section class="content clearfix">
	<div class="col-md-3">
		<div id="clock" class="box box-primary">
			&nbsp;
		</div>
		@foreach ($employees as $emp)
			<?php
				$birthday_counter ++;
				if($birthday_counter > 0){
					break;
				}
			?>
		@endforeach
		@if($birthday_counter > 0)
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title">Upcoming Birthdays</h3>
			</div>
			<div class="box-body no-padding">
				<ul class="users-list clearfix">
					@foreach ($employees as $emp)
					<li data-toggle="tooltip" title='{{ date("M d", strtotime($emp->birthdate)) }}'>
						@if( $emp->photo )
						<?php $emp_photo = str_replace('.jpg', '_50.jpg', $emp->photo) ?>
						<?php $emp_photo = str_replace('.png', '_50.png', $emp_photo) ?>
						<div class="imgsrc">
							<img src="/images/employees/profile_photo/{{ $emp_photo }}?{{ rand(0, 500) }}" class="img-responsive center-block" />
						</div>
						@else
						<div class="imgsrc">
							<img src="/images/employees/profile_photo/{{ $emp->gender == 'male' ? 'male-default-photo-50.jpg' : 'female-default-photo-50.jpg' }}"  class="img-responsive center-block" />
						</div>
						@endif
						<span>{{ $emp->firstname }}</span>
					</li>
					@endforeach
				</ul>
			</div>
		</div>
		@endif
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title">Recent Time Ins</h3>
			</div>
			<div class="box-body no-padding">
				<ul class="users-list clearfix">
					@foreach ($logins as $recent_time_in)
					<li data-toggle="tooltip" title='{{ date("g:i A", strtotime(substr($recent_time_in->login_time,11,14)))}}'>
						@if( $recent_time_in->employee->photo )
						<?php $emp_photo = str_replace('.jpg', '_50.jpg', $recent_time_in->employee->photo) ?>
						<?php $emp_photo = str_replace('.png', '_50.png', $emp_photo) ?>
						<div class="imgsrc">
							<img src="/images/employees/profile_photo/{{ $emp_photo }}?{{ rand(0, 500) }}" class="img-responsive" />
						</div>
						@else
						<div class="imgsrc">
							<img src="/images/employees/profile_photo/{{ $recent_time_in->employee->gender == 'male' ? 'male-default-photo-50.jpg' : 'female-default-photo-50.jpg' }}"  class="img-responsive" />
						</div>
						@endif
						<span>{{ $recent_time_in->employee->firstname }}</span>
					</li>
					@endforeach
				</ul>
			</div>
		</div>
		
	</div>
	<div class="col-md-8">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title">What's on your mind?</h3>
			</div>
			<div class="box-body no-padding">
				<div class="form-group">
					<textarea id="body" class="form-control"></textarea>
				</div>
				<a href="" class="btn btn-primary" id="submit-post" disabled>Post</a>
			</div>
		</div>
		<div class="box box-primary">

			<div class="box-header with-border">
				<h3 class="box-title">What's Up Today!</h3>
			</div>
			<section id="posts">
				<div id="all-posts">
					@foreach($posts as $post)
					<div class="post">
						@if( $post->empl->photo )
						<?php $emp_photo = str_replace('.jpg', '_50.jpg', $post->empl->photo) ?>
						<?php $emp_photo = str_replace('.png', '_50.png', $emp_photo) ?>
						<img class="img-circle dashboardpicture" src="/images/employees/profile_photo/{{ $emp_photo }}?{{ rand(0, 500) }}" />
						@else
						<img class="img-circle dashboardpicture" src="/images/employees/profile_photo/{{ $post->empl->gender == 'male' ? 'male-default-photo-50.jpg' : 'female-default-photo-50.jpg' }}"/>
						@endif
						<span class="disable">
							<strong>{{ $post->empl->firstname.' '.$post->empl->lastname}}</strong>
						@if($post->body == 'logged in' || $post->body == 'is on break' || $post->body == 'ended break' || $post->body == 'logged out')
						
							{{$post->body}} at {{date("g:i A", strtotime($post->created_at))}}.<br/><br/>
						</span>
						@else
						<br/>{{date("g:i A", strtotime($post->created_at))}}</span>
						<div class="well disable" id="{{$post->id}}">
							<span class="postbody">
								@if(Auth::user()->id == $post->employee_id || Auth::user()->account_type == 'admin')
								<a href="" class="delete" id="delete{{$post->id}}"><span class="glyphicon glyphicon-trash deletelink" id="{{$post->id}}"></span></a><a href="" class="edit" id="edit{{$post->id}}"><span class="glyphicon glyphicon-edit editlink" id="{{$post->id}}"></span></a>
								@endif
								<span id="post{{$post->id}}">{!!nl2br(($post->body))!!}</span>
							</span>
						</div>
						@endif
						<hr/>
					</div>
					@endforeach
				</div>
			</section>
		</div>	
	</div>
	<div id="edit-modal" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Edit Post</h4>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="post-body"></label>
						<textarea class="form-control" name="post-body" id="post-body" rows="5"></textarea>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary" id="modal-save">Save</button>
				</div>
			</div>
		</div>
	</div>
	<div id="delete-modal" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Are you sure you want to delete?</h4>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					<button type="button" class="btn btn-primary" id="modal-delete">Delete</button>
				</div>
			</div>
		</div>
	</div>	
</section>
<script>
	// token and createPostUrl are needed to be passed to AJAX method call
	var token = '{{csrf_token()}}';
	var createPostUrl = 'createpost';
	var editPostUrl = 'editpost';
	var deletePostUrl = 'deletepost';
	var postId = 0;
	setInterval('updateClock()', 1000);
	progressBarScript = setInterval(function(){
		if(n<110){
			progressBar();
		}
		else{
			$('#welcomeQuote').fadeOut();
			$('#contents').fadeIn();
			$('#leftsidebar').css({
				minHeight: $(document).height()
			});
			clearInterval(progressBarScript);
		}
	}
	, 100);

	// DEFINED FUNCTIONS APPLICABLE TO THE JUST-CREATED POSTS
	function editRecentPost(x){
		postId = x.id;
		event.preventDefault();
		$('#edit-modal').modal();
		$('body').attr('style', 'overflow: hidden;');
		$('#post-body').val($('span#post' + x.id).html());
	}
	function deleteRecentPost(x){
		postId = x.id;
		event.preventDefault();
		$('#delete-modal').modal();
	}
</script>
@endsection
<div id="welcomeQuote">
	<img id="mavesLogoDashboard" src="/dashboard/images/mavericks-logo.png" width="200px"/>

	<div id="quote"><strong>“{{$quote->quote}}”</strong><span id="quotedBy">—{{$quote->quoted_by}}</span></div>

	<div class="progress" id="progressdiv">
		<div  id="progressbar" class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
	</div>
</div>