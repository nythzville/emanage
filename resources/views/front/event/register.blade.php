@extends('layouts.pages')

@section('content')
	<div class="container main-wrap home">

		<div class="col-xs-12 text-center">
			<h2 style ="text-align:left;font-size: 30px;">{{$page_title}}</h2>
		</div>

{{-- 		<div class="col-md-12">
		<ol class="breadcrumb">
		  <li><a href="#">Select Category</a></li>
		  <li><a href="#">Event Signup</a></li>
		  <li class="active">Event Registration</li>
		</ol>
		</div> --}}

		<div class="col-md-8 col-md-offset-2" style="font-size:13px;">

			<div class="col-sm-12" style="margin-top: 50px;">
			    @if( $msg && !$error )
			        <div class="info-msg">
			            <div class="alert alert-success">
			                <strong>Success! </strong>  <br/> <span class="msg"><?php echo $msg ?></span>
			            </div>
			        </div>
			    @endif

			    @if( $msg && $error )
			        <div class="info-msg" >
			            <div class="alert alert-danger">
			                <strong>Please check the fields: </strong> <br/> <span class="msg"><?php echo $msg ?></span>
			            </div>
			        </div>
			    @endif

			    @if( Session::get('flash_error') or Session::get('msg') )
						<div class="alert alert-{{ Session::get('flash_error') ? 'danger':'info' }}">
							@if( Session::get('flash_error') )
						    <span class="msg">{{ Session::get('flash_error') }}</span>
						  @else
						  	<span class="msg">{{ Session::get('msg') }}</span>
						  @endif
						</div>
					@endif
			</div>


		    <div class="info-msg" style="display: none">

				<div class="alert alert-danger">
				    <strong>Error!</strong> <span class="msg"></span>
				</div>

				<div class="alert alert-success">
				    <strong>Success!</strong> <span class="msg"></span>
				</div>

			</div>

			{!! Form::open( array('url' => '/events/register/'.$event->id.'/'.$product->id, 'class'=>'form-login', 'id'=>'event-registration-new-participant', 'method'=>'post') ) !!}

			<div class="col-md-12">
				<h3><b>Event Name:</b> {{ $event->event_name }} | {{ $product->product_name }} </h3>
				<hr/>
			</div>

			<div class="col-md-12">
				<h3>Participant Information</h3>
				<hr/>
			</div>

			<div class="form-group">
				<label class="col-md-6 control-label">First Name</label>
				<div class="col-md-6">
					<input type="text" class="form-control" name="firstname" value="{{ $user->user_firstname }}">
				</div>
			</div>

			<div class="form-group">
				<label class="col-md-6 control-label">Last Name</label>
				<div class="col-md-6">
					<input type="text" class="form-control" name="lastname" value="{{ $user->user_lastname }}">
				</div>
			</div>


			<div class="form-group">
				<label class="col-md-6 control-label">Date of Birth</label>
				<div class="col-md-6">
					<div class="row">
						<div class="col-xs-4">
							<select name="birth_year" class="form-control">
							@for( $i = date('Y'); $i > date('Y') - 70; $i--)
								<option value="{{ $i }}">{{ $i }}</option>
							@endfor
							</select>
						</div>
						<div class="col-xs-4">
							<select name="birth_month" class="form-control">
								@for( $i = 1; $i <= 12; $i++ )
									<option value="{{ $i }}">{{ $i }}</option>
								@endfor
							</select>
						</div>
						<div class="col-xs-4">
							<select name="birth_day" class="form-control">
								@for( $i = 1; $i <= 31; $i++ )
									<option value="{{ $i }}">{{ $i }}</option>
								@endfor
							</select>
						</div>
					</div>
				</div>
			</div>

			<div class="form-group">
				<label class="col-md-6 control-label">Gender</label>
				<div class="col-md-6">
					<select name="gender" class="form-control">
						<option value="male">Male</option>
						<option value="female">Female</option>
					</select>
				</div>
			</div>

			<div class="form-group">
				<label class="col-md-6 control-label">Age on Event Day</label>
				<div class="col-md-6">
					<input type="text" class="form-control" name="age" value="{{ Input::get('age') }}">
				</div>
			</div>

			<div class="form-group">
				<label class="col-md-6 control-label">Email Address</label>
				<div class="col-md-6">
					<input type="text" class="form-control" name="email" value="{{ $user->user_email }}">
				</div>
			</div>

			<div class="form-group">
				<label class="col-md-6 control-label">Phone</label>
				<div class="col-md-6">
					<input type="text" class="form-control" name="phone" value="{{ Input::get('phone') }}">
				</div>
			</div>

			<div class="form-group">
				<label class="col-md-6 control-label">Event</label>
				<div class="col-md-6">

					<?php $selected_product = $product->id; //echo $product->id; echo $selected_product; ?>
					<select name="product_id" class="form-control">
					@foreach($products as $product)
						<option class="product-select" value="{{ $product->id }}" <?php echo $selected_product == $product->id ? 'selected':'' ?> /> {{ $product->product_name }} - $ {{ $product->product_price }} <br/>
					@endforeach
					</select>
				</div>
			</div>

			<div class="col-md-12">
				<h3>Address</h3>
				<hr/>
			</div>

			<div class="form-group">
				<label class="col-md-6 control-label">Country</label>
				<div class="col-md-6">
					<?php $selected_country = Input::get('country'); ?>
					<select name="country" class="form-control">
						<option>Select Country</option>
						@foreach ($countries as $country)
						<option value="{{$country->country_id}}" <?php echo $selected_country == $country->country_id ? 'selected':'' ?> >{{$country->country_name}}
						@endforeach
					</select>
				</div>
			</div>

			<div class="form-group">
				<label class="col-md-6 control-label">Address</label>
				<div class="col-md-6">
					<textarea name="address" class="form-control" >{{ Input::get('address') }}</textarea>
				</div>
			</div>

			<div class="form-group">
				<label class="col-md-6 control-label">Address 2</label>
				<div class="col-md-6">
					<textarea name="address2" class="form-control">{{ Input::get('address2') }}</textarea>
				</div>
			</div>

			<div class="form-group">
				<label class="col-md-6 control-label">City</label>
				<div class="col-md-6">
					<input type="text" class="form-control" name="city" value="{{ Input::get('city') }}">
				</div>
			</div>

			<div class="form-group">
				<label class="col-md-6 control-label">State/Province</label>
				<div class="col-md-6">
					<input type="text" name="province" class="form-control" value="{{ Input::get('province') }}">
				</div>
			</div>

			<div class="form-group">
				<label class="col-md-6 control-label">Zip/Postal Code</label>
				<div class="col-md-6">
					<input type="text" class="form-control" name="zip" value="{{ Input::get('zip') }}">
				</div>
			</div>

			<div class="form-group">
				<label class="col-md-6 control-label">Emergency Contact Name</label>
				<div class="col-md-6">
					<input type="text" class="form-control" name="emergency_name" value="{{ Input::get('emergency_name') }}">
				</div>
			</div>

			<div class="form-group">
				<label class="col-md-6 control-label">Emergency Contact Phone</label>
				<div class="col-md-6">
					<input type="text" class="form-control" name="emergency_phone" value="{{ Input::get('emergency_phone') }}">
				</div>
			</div>

			<div class="form-group">
				<div class="col-md-12">
					<input type="submit" name="submit" name="" class="btn btn-warning pull-right" value="Continue">
				</div>
			</div>

			<div class="col-md-12">&nbsp;</div>

		</form>
		</div>

		<div class="data">

			<div class="why">


			</div>
		</div>
	</div>
@endsection