@extends('layouts.pages')

@section('content')
	<main id="main" class="site-main" role="main">

		<article id="post-80" class="post-80 page type-page status-publish hentry">

			<div class="container">
				<h1>{{Input::get('q') ? 'Search Result for: ' . Input::get('q') : 'Events'}}</h1>
				<hr />
			</div>

			<div class="entry-content">

				<div class="interior">

				<div class="container">

				<div class="row">

				@if( Session::get('flash_error') or Session::get('msg') )
				<div class="col-md-12">
					<div class="alert alert-{{ Session::get('flash_error') ? 'danger':'info' }}">
						@if( Session::get('flash_error') )
					    <span class="msg">{{ Session::get('flash_error') }}</span>
					  @else
					  	<span class="msg">{{ Session::get('msg') }}</span>
					  @endif
					</div>
				</div>
				@endif


					<div class="col-md-8">
						<div class="row">
							<div id="filter-panel" class="col-md-4" style="margin:10px 0">
								{!! Form::open(array('method'=>'GET', 'style'=>'margin-top: 10px;')) !!}
						          	<div class="input-group">
                        				<input type="hidden" name="q" value="{{Input::get('q')}}">
						          	  	<span class="input-group-addon">Row per page</span>
						          	  	<select id="perpage" name="perpage" class="form-control">
						          	  		<?php
						          	  			$perpages = array(1,2,10,15,120,30,40,50,100);
						          	  		?>
						          	  		@foreach($perpages as $perpage )
						          	  			<option value="{{$perpage}}" {{ $events->perPage() == $perpage ? 'selected' : '' }}>{{$perpage}}</option>
						          	  		@endforeach
	                            		</select>
						          	  	<span class="input-group-btn">
				          	          		<button class="btn btn-primary" type="submit">Go!</button>
				          	        	</span>
						          	</div>
							    </form>
							</div>
							<div class="col-md-8 text-right" style="margin-top: 7px">
								<?php echo $events->appends( Input::except('page') )->render() ?>
						    </div>
					    </div>

					    <div class="row">
							<div class="col-md-12">
							@if( !$events->isEmpty() )
							  @foreach($events as $event)
							  	<table class="table table-hover">
							        <tbody>
							          <tr>
							            <td>
							            <div class="col-xs-2">
							  				<span style="font-size:15px;">{{ date('M d, Y', strtotime(str_replace('-', '', $event->event_date_start))) }}</span>
										</div>
							            <div class="col-xs-4">
							            	<a href="/events/{{ $event->id }}" style="font-weight:600;">{{ $event->event_name }}</a><br/>
							            </div>
							            <div class="col-xs-6">
							  				<span>{{ $event->event_address1 }}, {{ $event->state->state_code or '' }}, {{ $event->country->country_name}}</span>
							  			</div>
							            </td>
							          </tr>
							        </tbody>
						        </table>
							  @endforeach
							@endif
							</div>
						</div>
						<div class="text-right">
							<?php echo $events->appends( Input::except('page') )->render() ?>
						</div>
					</div>

					@include('includes.front.right-sidebar')

					
				</div>

				</div>

				</div>

				</div>

				</div>

			</div><!-- .entry-content -->

		</article><!-- #post-## -->

	</main>
@endsection