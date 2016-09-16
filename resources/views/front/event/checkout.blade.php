@extends('layouts.pages')

@section('content')
	<div class="container main-wrap home">

		<div class="col-xs-12 text-center">
		<h2 style ="text-align:left;font-size: 30px;">{{$page_title}}</h2>
		</div>

		<div class="col-md-12 col-sm-12 col-xs-12" style="font-size:14px;padding-bottom:40px;">

			@if( Session::get('flash_error') or Session::get('msg') )
				<div class="alert alert-{{ Session::get('flash_error') ? 'danger':'info' }}">
					@if( Session::get('flash_error') )
				    <span class="msg">{{ Session::get('flash_error') }}</span>
				  @else
				  	<span class="msg">{{ Session::get('msg') }}</span>
				  @endif
				</div>
			@endif

			@if( !empty($msg) )
				<div class="alert alert-danger">
					<span class="msg"><?php echo $msg; ?></span>
				</div>
			@endif

			<div class="info-msg" style="display: none">
				<div class="alert alert-danger">
					<strong>Error!</strong> <span class="msg"></span>
				</div>
				<div class="alert alert-success">
					<strong>Success!</strong> <span class="msg"></span>
				</div>
			</div>

			{!! Form::open( array('url' => '/events/checkout/'.$event->id.'/'.$product->id, 'class'=>'form-login', 'id'=>'event-registration-checkout', 'method'=>'post') ) !!}

			<div class="col-md-12">
				<h3>Order Information</h3>
				<hr/>
			</div>

			<div class="col-md-6 col-sm-6 col-xs-6">
				<div class="pull-left">
					<b>ITEMS</b><br /><br />
					<p>{{ $product->product_name }}</p>
				</div>
			</div>
			<div class="col-md-6 col-sm-6 col-xs-6">
				<div class="pull-right">
					<b>TOTAL</b><br /><br />
					<p>$ {{ $product->product_price }}</p>
				</div>
			</div>
			<div class="col-md-6 col-sm-6 col-xs-12">
				<hr/>
				<h3>BILLING INFORMATION</h3>
				<hr/>
				<p><b>First Name:</b> {{ $user_firstname }}</p>
				<p><b>Last Name:</b> {{ $user_lastname }}</p>
				<p><b>Address1:</b> {{ $user_address }}</p>
				<p><b>Address2:</b> {{ $user_address2 }}</p>
				<p><b>City:</b> {{ $user_city }}</p>
				<p><b>State/Province:</b> {{ $user_province }}</p>
				<p><b>Zip:</b> {{ $user_zip }}</p>
				<p><b>Country:</b> {{ $user_country }}</p>
				<p><b>Phone #:</b> {{ $user_phone }}</p>
				<p><b>Email Address:</b> {{ $user_email }}</p>
				<a href="/events/register/{{ $event->id }}/{{ $product->id }}" class="btn btn-info">Edit billing info</a>

			</div>
			<div class="col-md-6 col-sm-6 col-xs-12">
				<div class="row">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<hr/>
						<h3>PAYMENT INFORMATION</h3>
						<hr/>
					</div>
					<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="form-group">
							<label class="col-sm-4 control-label">Card Number</label>
							<div class="col-sm-8">
								<input type="text" name="cc_number" class="form-control" style="width:29s0px;display:inline;">
								<div style="background-image:url('/images/creditcards.svg');background-position: 0px 0px;width: 193px;height: 30px;background-repeat: no-repeat;background-size: 193px 268px;"></div><br/>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-4 control-label">Expiration</label>
							<div class="col-sm-8">
								<div class="row">
									<div class="col-md-6">
										<select name="cc_month" class="form-control" style="display:inline-block;">
											<option value="">Month</option>
											@for( $i=1; $i < 13; $i++ )
												<option value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}">{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}</option>
											@endfor
										</select>
									</div>
									<div class="col-md-6">
										<select name="cc_year" class="form-control" style="display:inline-block;">
											<option value="">Year</option>
											@for( $i=0; $i < 10; $i++ )
												<option value="{{ date('y')+$i  }}">{{ date('Y')+$i  }}</option>
											@endfor
										</select>
									</div>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-4 control-label">Card CVV2</label>
							<div class="col-sm-8">
								<input type="text" name="cc_cvv2" class="form-control" style="width:29s0px;display:inline;">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-4 control-label">&nbsp;</label>
							<div class="col-sm-8">
								<input type="submit" class="btn btn-primary btn-lg" value="Confirm Checkout">
							</div>
						</div>
					</div>
				</div>
			</div>

			</form>
		</div>
		<div class="data">
			<div class="why">

			</div>
		</div>
	</div>
@endsection