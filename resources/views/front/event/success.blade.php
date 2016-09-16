@extends('layouts.pages')

@section('content')
<div class="container main-wrap home">
	<div class="col-xs-12 text-center">
	<h2 style ="text-align:left;font-size: 30px;">{{$page_title}}</h2>
	</div>
	<div class="col-md-12 col-sm-12 col-xs-12" style="font-size:14px;padding-bottom:40px;">
		<div class="row">

			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="alert alert-{{ $status=='DECLINED' ? 'danger':'success' }}">
				  <span class="msg">{{ $message }}</span>
				</div>
			</div>

			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="panel panel-{{ $status=='DECLINED' ? 'danger':'success' }}">
					<div class="panel-heading">Transaction Result</div>
				  <div class="panel-body">
				    <div><p><b>Status:</b> {{ $status }} {{ $status=='DECLINED' ? '':'<i class="glyphicon glyphicon-ok" style="color:#5cb85c;"></i>' }}</p></div>
				    <div><p><b>Payment Amount:</b> $ {{ $payment_amount }}</p></div>
						<div><p><b>Transaction ID:</b> {{ $transaction_id }}</p></div>
						<div><p><b>Card Type:</b> {{ $card_type }}</p></div>
						<div><p><b>Account Number:</b> {{ $masked_account }}</p></div>
						@if ( !empty($authorization_code) )
							<div><p><b>Authorization Code:</b> {{ $authorization_code }}</p></div>
						@endif
						<div><a href="/events/{{ $event->id }}" class="btn btn-{{ $status=='DECLINED' ? 'info':'success' }}">Return to event</a></div>
				  </div>
				</div>

			</div>

		</div>
	</div>
</div>
@endsection