@extends('layouts.pages')

@section('content')
	<div class="container main-wrap">

			@if(Session::has('flash_notice'))
		    	<div class="alert alert-success alert-dismissable">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
					<h4><i class="icon fa fa-check"></i> Success!</h4>
					{{ Session::get('flash_notice') }}
				</div>
			@endif

			@if(Session::has('flash_error'))
		    	<div class="alert alert-danger alert-dismissable">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
					<h4><i class="icon fa fa-check"></i> Error!</h4>
					{{ Session::get('flash_error') }}
				</div>
			@endif

			<div class="row">
				<div class="col-xs-12 col-md-3">
				    <div class="panel panel-primary">
				    	<div class="cnrflash">
				            <div class="cnrflash-inner hide">
				                <span class="cnrflash-label">MOST
				                    <br>
				                    POPULAR</span>
				            </div>
				        </div>
				        <div class="panel-heading">
				            <h3 class="panel-title">
				                Free</h3>
				        </div>
				        <div class="panel-body">
				            <div class="the-price">
				                <h1>
				                    Free<span class="subscript"></span></h1>
				                <small>1 month FREE trial</small>
				            </div>
				            <table class="table">
				                <tr>
				                    <td>
				                        1 Account
				                    </td>
				                </tr>
				                <tr class="active">
				                    <td>
				                        1 Project
				                    </td>
				                </tr>
				                <tr>
				                    <td>
				                        100K API Access
				                    </td>
				                </tr>
				                <tr class="active">
				                    <td>
				                        100MB Storage
				                    </td>
				                </tr>
				                <tr>
				                    <td>
				                        Custom Cloud Services
				                    </td>
				                </tr>
				                <tr class="active">
				                    <td>
				                        Weekly Reports
				                    </td>
				                </tr>
				            </table>
				        </div>
				        <div class="panel-footer">
				        	<a href="/subscription" class="btn btn-primary">FREE</a>
				        </div>
				    </div>
				</div>
				@if( $plans )
					@foreach ($plans as $plan)

						<div class="col-xs-12 col-md-3">
						    <div class="panel panel-primary">
						    	<div class="cnrflash">
						            <div class="cnrflash-inner hide">
						                <span class="cnrflash-label">MOST
						                    <br>
						                    POPULAR</span>
						            </div>
						        </div>
						        <div class="panel-heading">
						            <h3 class="panel-title">
						                {{ $plan->plan_name }}</h3>
						        </div>
						        <div class="panel-body">
						            <div class="the-price">
						                <h1>
						                    {{ $plan->plan_amount }}<span class="subscript">/{{ $plan->plan_interval }}</span></h1>
						                <small>1 month FREE trial</small>
						            </div>
						            <table class="table">
						                <tr>
						                    <td>
						                        1 Account
						                    </td>
						                </tr>
						                <tr class="active">
						                    <td>
						                        1 Project
						                    </td>
						                </tr>
						                <tr>
						                    <td>
						                        100K API Access
						                    </td>
						                </tr>
						                <tr class="active">
						                    <td>
						                        100MB Storage
						                    </td>
						                </tr>
						                <tr>
						                    <td>
						                        Custom Cloud Services
						                    </td>
						                </tr>
						                <tr class="active">
						                    <td>
						                        Weekly Reports
						                    </td>
						                </tr>
						            </table>
						        </div>
						        <div class="panel-footer">
						        	{!! Form::open( array('url' => 'subscription/charge/'.$plan->plan_stripe_id.'/'.$plan->plan_gateway_type, 'method'=>'post') ) !!}

						        	  <script
						        	    src="https://checkout.stripe.com/checkout.js" class="stripe-button"
						        	    data-key="{{ Config::get('services.stripe.publishable') }}"
						        	    data-image="/images/just-logo.png"
						        	    data-name="SHIELDGUARD.ORG"
						        	    data-description="2 widgets"
						        	    data-amount="{{ $plan->plan_amount*100 }}">
						        	  </script>
						        	{!! Form::close() !!}
						        </div>
						    </div>
						</div>

					@endforeach
				@endif
			</div>
	</div>
@endsection