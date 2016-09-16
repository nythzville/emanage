@extends('layouts.pages')

@section('content')
	<main id="main" class="site-main" role="main">

		<article id="post-80" class="post-80 page type-page status-publish hentry">

			<header class="entry-header">



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
					<h2>{{ $event->event_name  }}</h2>
					<h4>Make a Selection</h4>
				<hr/>

	            {!! Form::open(array('url' => 'events/'.$event->id.'/product/', 'class' => 'form', 'method' => 'post')) !!}

					<div class="col-md-8">
						<?php $i = 1; ?>
						@foreach($products as $product)
							<input type="radio" class="product-select" name="product" value="{{ $product->id }}" <?php echo $i++ == 1 ? 'checked="checked"':'' ?> /> {{ $product->product_name }} - $ {{ $product->product_price }} <br/>
						@endforeach
						<br/>
						<input type="submit" class="btn btn-default product-selection" data-event_id = "{{ $event->id }}" name="product" value="Continue">
					</div>

				</form>


				</div>

				</div>

				</div>

				</div>

			</div><!-- .entry-content -->

		</article><!-- #post-## -->

	</main>
@endsection