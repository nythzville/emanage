@extends('layouts.pages')

@section('content')
	<main id="main" class="site-main" role="main">

		<article id="post-80" class="post-80 page type-page status-publish hentry">

			<header class="entry-header">
				<div class="interior-head">
				<div class="col-md-12"></div>
					<div class="interior-head-content">

					<div class="col-md-12">
						<div class="col-md-3">
							<img alt="Aa6c97f5-f121-4464-96e1-571f869889cc" src="http://photos-images.active.com/file/3/1/original/aa6c97f5-f121-4464-96e1-571f869889cc.png" style="display: inline;">
						</div>

						<div class="col-md-8">
							<h1>Tag: {{ $tag->tag_name }}</h1>
						</div>

						{{--<div class="col-md-4">
								<a href="/event/{{$category->id}}/products"class="btn btn-warning" style="color:#fff;width:100%;font-weight:bold;text-transform:uppercase;font-size:25px;" >Join this Event!</a>
						</div> --}}
					</div>

					</div>	
				</div>



			</header><!-- .entry-header -->

			<div class="entry-content">

				<div class="interior">

				<div class="container">

				<div class="row">

				@if( Session::get('msg') )
					<div class="alert alert-{{ Session::get('error') ? 'danger':'info' }}">
					    <span class="msg">{{ Session::get('msg')}}</span>
					</div>
				@endif

				<h2></h2>
					<div class="col-md-8">
						<div class="row">
							<div id="filter-panel" class="col-md-4" style="margin:10px 0">
								{!! Form::open(array('method'=>'GET', 'style'=>'margin-top: 10px;')) !!}
						          	<div class="input-group">
						          	  	<span class="input-group-addon">Row per page</span>
						          	  	<select id="perpage" name="perpage" class="form-control">
						          	  		<?php 
						          	  			$perpages = array(1,2,10,15,120,30,40,50,100);
						          	  		?>
						          	  		@foreach($perpages as $perpage )
						          	  			<option value="{{$perpage}}" {{ $eventtags->perPage() == $perpage ? 'selected' : '' }}>{{$perpage}}</option>
						          	  		@endforeach
	                            		</select>          
						          	  	<span class="input-group-btn">
				          	          		<button class="btn btn-primary" type="submit">Go!</button>
				          	        	</span>
						          	</div>
							    </form>
							</div>
							<div class="col-md-8 text-right" style="margin-top: 7px">
						    	<?php echo $eventtags->appends(['perpage' => $eventtags->perPage() ])->render() ?>
						    </div>
					    </div>

					    <div class="row">
							<div class="col-md-12">

							  @foreach($eventtags as $eventtag)
							  	<table class="table table-hover">
							        <tbody>
							          <tr>
							            <td>
							            <div class="col-xs-2">
							  				<span style="font-size:15px;">{{ date('M d, Y', strtotime(str_replace('-', '', $eventtag->event->event_date_start))) }}</span>
										</div>
							            <div class="col-xs-4">
							            	<a href="/event/{{ $eventtag->event->id }}" style="font-weight:600;">{{ $eventtag->event->event_name }}</a><br/>
							            </div>
							            <div class="col-xs-6">
							  				<span>{{ $eventtag->event->event_address1 }}, {{ $eventtag->event->state->state_name }}, {{ $eventtag->event->country->country_name }}</span>
							  			</div>
							            </td>
							          </tr>
							        </tbody>
						        </table>
							  @endforeach
							  	
							</div>
						</div>
						<div class="text-right">
							<?php // echo $events->appends(['perpage' => $events->perPage() ])->render() ?>
						</div>
					</div>

					<div class="col-md-4">
					<div class="panel panel-primary">
						<div class="panel-heading">
						<h3 class="panel-title" id="panel-title">Events<a class="anchorjs-link" href="#panel-title"><span class="anchorjs-icon"></span></a></h3>
						</div>

						<div class="panel-body">
						<p style="font-size:13px;">
						{{--  --}}
						</p>
						</div>
					</div>
					
					</div>

				</div>

				</div>

				</div>

				</div>

				</div>

			</div><!-- .entry-content -->

		</article><!-- #post-## -->

	</main>
@endsection