@extends('layouts.pages')
@section('content')
	<main id="main" class="site-main" role="main">
		<article id="post-80" class="post-80 page type-page status-publish hentry">
			<header class="entry-header clearfix">
				<div class="interior-head clearfix" style="background:url(/images/uploads/event/banner/<?php echo empty($event->event_banner) ? 'default.png': $event->event_banner ?>);background-size:cover;background-repeat:no-repeat;">
					<div class="interior-head-content clearfix">
						<div class="row">
							<div class="col-md-3 col-sm-5 text-center">
								<img alt="Aa6c97f5-f121-4464-96e1-571f869889cc" src="/images/uploads/event/logo/<?php echo empty($event->event_image) ? 'default.png': $event->event_image ; ?>"
								style="display: inline;width:188px;height:158px;" class="img-responsive img-thumbnail">
							</div>
							<div class="col-md-5 col-sm-7">
								<h1>{{ $event->event_name }}</h1>
								<p><i class="fa fa-calendar" style="font-size:18px;"></i> &nbsp; <?php $date = $event->event_date_start; echo date("l, F j Y H:i:s", strtotime($date)); ?></p>
								<p><i class="fa fa-location-arrow" style="font-size:18px;"></i>  &nbsp;  {{ $event->event_address1 }} - {{ $event->event_address2 }}</p>
								<p><i class="fa fa-map-marker" style="font-size:18px;"></i> &nbsp;  {{ $event->state->state_name or '' }}, {{ $event->country->country_name }} {{ $event->event_postal }}</p>
								<ul>
									@if( !$event_tags->isEmpty() )
										@foreach($event_tags as $event_tag)
											<li><a href="#"><i class="fa fa-tags"></i>{{ $event_tag->tag->tag_name }}</a></li>
										@endforeach
									@endif
								</ul>
							</div>
							<div class="col-md-4">
							<a href="/events/{{$event->id}}/products" class="btn btn-warning join-event-btn" >Join this Event!</a>
							</div>
						</div>
					</div>
				</div>

				<nav class="navbar navbar-default navbar-static-top">
					<!-- We use the fluid option here to avoid overriding the fixed width of a normal container within the narrow content columns. -->
					<div class="container-fluid">
						<!-- Collect the nav links, forms, and other content for toggling -->
						<div style="width:350px;margin:0 auto;">
							<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-8">
								<ul class="nav navbar-nav nav-blue">
									{{--
									<li><a href="#">Link</a></li>
									<li><a href="#">Link</a></li>
									<li><a href="#">Link</a></li>
									--}}
								</ul>
							</div><!-- /.navbar-collapse -->
						</div>
					</div>
				</nav>
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

							<div class="col-md-8">
								<h2>Make a Selection</h2>
								<div class="row">
									@foreach($products as $product)
										<div class="col-md-12 list-of-products">
											<div class="row">
												<div class="col-sm-5 product_name">
													<p class="product_name">{{ $product->product_name }}</p>
												</div>
												<div class="col-sm-2 col-xs-4">
													<?php
													$datetime1 = date_create('now');
													$datetime2 = date('Y-m-d', strtotime($event->event_date_start));
													$datetime2 = date_create($datetime2);
													$interval = date_diff($datetime1, $datetime2);
													echo "<p>".$interval->format('%a day(s) left')."</p>";
													?>
												</div>
												<div class="col-sm-2 col-xs-4">
													<p>$ {{ $product->product_price }}</p>
												</div>
												<div class="col-sm-3 col-xs-4">
													<a href="/events/signup/{{$event->id}}/{{$product->id}}" class="btn btn-warning" style="padding:5px;">Register Now</a>
												</div>
											</div>
										</div>
									@endforeach
								</div>
								<div class="row">
									<div class="col-md-12 col-sm-12 col-xs-12">
										<h2>About this Activity</h2>
										<div><?php echo $event->event_description; ?></div>
										<h2>Event Details and Schedule</h2>
										<p>{{ $event->event_name }}</p>
										<p><b>Event Starts at: </b><?php $date_start = $event->event_date_start; echo date("l, F j, Y - H:i", strtotime($date_start)); ?></p>
										<p><b>Event Ends at: </b><?php $date_end = $event->event_date_end; echo date("l, F j, Y - H:i", strtotime($date_end)); ?></p>
										<div><?php echo $event->event_details; ?></div>
									</div>
								</div>
							</div>

							 @include('includes.front.right-sidebar')

							<div class="col-md-12">
								<hr>
								<h2>Map & Direction</h2>
								<?php $statecode = (!empty($event->state->state_code))? $event->state->state_code: '';?>
								<iframe
								  width="100%"
								  height="500"
								  frameborder="0" style="border:0"
								  src="https://www.google.com/maps/embed/v1/place?key=AIzaSyD3FjtHciCXU0EDR-MTVyNSwCgq_MYm8lc&q={{ urlencode($event->event_address1.' '.$statecode.' '.$event->country->country_name.' '.$event->event_postal) }}">
								</iframe>
							</div><!-- col-md-12 -->
							<div class="col-md-12 col-sm-12 col-xs-12">
								<hr>
								<h2>Comments</h2>
								<div class="fb-comments" data-href="{{ Request::url() }}" data-width="100%" data-numposts="10" data-colorscheme="light"></div>
							</div>
						</div><!-- row -->
					</div><!-- container -->
				</div><!-- interior -->
			</div><!-- .entry-content -->
		</article><!-- #post-## -->
	</main>
@endsection