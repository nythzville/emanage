@extends('layouts.users.default')

@section('content')
	<!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <?php echo ucfirst($user->user_name) ?> | 
            <small>Subscription</small>
        </h1>
        
    </section>
    <ol class="breadcrumb">
        <li><a href="{{ BASE_URL }}/dashboard"><i class="fa fa-home"></i> Dashboard</a></li>
        <li class="active">Subscription</li>
    </ol>

   

    <section class="content clearfix">

        @if(Session::has('flash_notice'))
            <div class="info-msg">
                <div class="alert alert-success">
                    <strong>Succes!</strong> <span class="msg">{{ Session::get('flash_notice') }}</span>
                </div>
            </div>
        @endif

        @if(Session::has('flash_error'))
            <div class="info-msg" >
                <div class="alert alert-danger">
                    <strong>Error!</strong> <span class="msg">{{ Session::get('flash_error') }}</span>
                </div>
            </div>
        @endif
        <div class="col-sm-12">
            <div class="box box-solid box-primary">
                <div class="box-header">
                  <h3 class="box-title">My Current Subscription</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <p>Plan: <strong>{{ $user->user_plan_type == 'FREE' ? 'FREE' : $user->stripe_plan }}</strong></p>
                  <p>Subscription renewal date: <strong>{{ $user->user_plan_type == 'FREE' ? date('Y-m-d',strtotime(date("Y-m-d", strtotime($user->created_at)) . " + 1 year")):$user->subscription_ends_at }}</strong></p>
                </div><!-- /.box-body -->
            </div>
        </div>

        <div class="col-md-4 col-sm-6 col-xs-12">
              <div class="info-box">
                <span class="info-box-icon bg-red"><i class="fa fa-cc-stripe"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">FREE</span>
                  <span class="info-box-number"></span>
                  <p>
                    
                  </p>
                </div><!-- /.info-box-content -->
              </div><!-- /.info-box -->
            </div>
        </div>

        @if( $plans )
            @foreach ($plans as $plan)
            <div class="col-md-4 col-sm-6 col-xs-12">
                  <div class="info-box">
                    <span class="info-box-icon bg-red"><i class="fa fa-cc-stripe"></i></span>
                    <div class="info-box-content">
                      <span class="info-box-text">{{ $plan->plan_name }}</span>
                      <span class="info-box-number">{{ $plan->plan_currency }} {{ $plan->plan_amount }} / {{ $plan->plan_interval }}</span>
                      <p>
                        @if( $plan->plan_stripe_id !== $user->stripe_plan )
                        {!! Form::open( array('url' => 'subscription/charge/'.$plan->plan_stripe_id.'/'.$plan->plan_gateway_type, 'method'=>'post') ) !!}
                          <script
                            src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                            data-key="{{ Config::get('services.stripe.publishable') }}"
                            data-image="/images/just-logo.png"
                            data-name="SHIELDGUARD.ORG"
                            data-description="{{ $plan->plan_name }}"
                            @if($user_current_plan)
                              @if( $user_current_plan->plan_weight < $plan->plan_weight || $user->user_plan_type == 'FREE')
                                data-label="Upgrade"
                              @else
                                data-label="Downgrade"
                              @endif
                            @else
                                data-label="Upgrade"
                            @endif
                            data-amount="{{ $plan->plan_amount*100 }}">
                          </script>
                        {!! Form::close() !!}
                        @endif
                      </p>
                    </div><!-- /.info-box-content -->
                  </div><!-- /.info-box -->
                </div>
            </div>
            @endforeach                       
        @endif
        @if( count($plantransactions) > 0 )
        <div class="col-sm-12">
           

            <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Invoices History</h3>
                </div><!-- /.box-header -->
                <div class="box-body no-padding">
                  
                  <table class="table table-condensed transaction-list table-stripe">
                    <tr>
                      <th>Plan</th>
                      <th>Subscription</th>
                      <th>Interval</th>
                      <th>Amount</th>
                      <th>Gateway</th>
                      <th>Action</th>
                      <th>Transaction Date</th>
                    </tr>
                    @if( $plantransactions )
                        @foreach( $plantransactions as $plantransaction )
                            <tr>
                                <td>{{ $plantransaction->plan_stripe_plan }}</td>
                                <td>{{ $plantransaction->plan_stripe_subscription }}</td>
                                <td>{{ $plantransaction->plan_interval }}</td>
                                <td>{{ $plantransaction->plan_currency.' '.$plantransaction->plan_amount }}</td>
                                <td>{{ $plantransaction->plan_gateway_type }}</td>
                                <td><span class="label label-{{ $plantransaction->action == 'upgraded' ? 'info': ($plantransaction->action == 'downgraded' ? 'danger':'success') }}">{{ $plantransaction->action }}</span></td>
                                <td>{{ date('Y-m-d H:i:s', strtotime($plantransaction->created_at) ) }}</td>
                            </tr>
                        @endforeach                       
                    @endif
                   </table>
                </div><!-- /.box-body -->
              </div>

        </div>
        @else
          <div class="col-xs-12" style="padding: 50px 20px;">
          <p>There is no invoice to list just yet.</p>
          </div>
        @endif
    </section>
@endsection