@extends('layouts.dashboard')

@section('content')
	<!-- Content Header (Page header) -->

    <ol class="breadcrumb">
        <li><a href="{{ BASE_URL }}/dashboard"><i class="fa fa-home"></i> Dashboard</a></li>
        <li class="active">{{ucwords( $event->event_name ) }} Products</li>
    </ol>

    <div class="col-sm-12">
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
    </div>

    <section class="content">

        <div class="col-sm-12">
            <div class="info-msg" style="display: none">
                <div class="alert alert-danger">
                    <strong>Error!</strong> <span class="msg"></span>
                </div>
                <div class="alert alert-success">
                    <strong>Success!</strong> <span class="msg"></span>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6">
                    <a href="/event/detail/{{$event->id}}/" class="btn btn-primary"><i class="fa fa-long-arrow-left"></i> Back to List</a>
                    @if(Auth::user()->user_type == 'organizer') 
                        <a href="/event/{{$event->id}}/products/create" class="btn btn-primary"><i class="fa fa-plus"></i> Add Product</a>
                    @endif
                    <a href="/export/event/{{$event->id}}/organizer_products" class="btn btn-primary submit">Export CSV - List of Products</a>
                </div>

                <div class="col-sm-6 text-right">
                    {!! Form::open( array('id'=>'form-search', 'method'=>'get') ) !!}
                        <div class="input-group">
                            <input type="hidden" name="perpage" value="{{$products->perPage()}}">
                            <input type="text" class="form-control" name="q" placeholder="Search product..." value="{{Input::get('q')}}">
                            <span class="input-group-btn">
                                <button class="btn btn-primary" type="submit"><span class="fa fa-search"></span> Search</button>
                            </span>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div> {{-- END .row --}}

            <div class="row">
                <div id="filter-panel" class="col-sm-3" style="margin:10px 0">
                    {!! Form::open(array('method'=>'GET', 'style'=>'margin-top: 10px;')) !!}
                        <input type="hidden" name="q" value="{{Input::get('q')}}">
                        <div class="input-group">
                            <span class="input-group-addon">Row per page</span>
                            <select id="perpage" name="perpage" class="form-control">
                                <?php 
                                    $perpages = array(1,2,10,15,120,30,40,50,100);
                                ?>
                                @foreach($perpages as $perpage )
                                    <option value="{{$perpage}}" {{ $products->perPage() == $perpage ? 'selected' : '' }}>{{$perpage}}</option>
                                @endforeach
                            </select>          
                            <span class="input-group-btn">
                                <button class="btn btn-primary" type="submit">Go!</button>
                            </span>
                        </div>
                    </form>
                </div>
                <div class="col-sm-9 text-right">
                    <?php echo $products->appends( Input::except('page') )->render() ?>
                </div>
            </div>

            <div class="box">
                <div class="box-body no-padding">
                  <table class="table table-condensed">
                    <tbody>
                        <tr class="tbl-head">
                          <th>Product Name</th>
                          <th style="width:20%">Product Price</th>
                          <th style="width:20%" colspan="2">Actions</th>
                        </tr>
                    </tbody>
                        <?php $cnt = 1 ?>
                        @foreach( $products as $product )
                            <tr class="{{ $cnt++ % 2 == 0 ? 'even':'' }} product" >
                                <td>{{ $product->product_name }}</td>
                                <td>{{ $product->product_price }}</td>
                                <td style="width: 350px">
                                    <a href="/event/{{$event->id}}/products/{{ $product->id }}/edit/" class="btn btn-default" title="Edit product">
                                       <i class="fa fa-pencil-square-o"></i> Edit
                                    </a>
                                    <a href="#" data-url="/event/{{ $event->id }}/products/{{ $product->id }}" data-token="{{ csrf_token() }}" class="btn btn-danger product-delete" title="Delete Event">
                                       <i class="fa fa-trash"></i> Delete
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                   </table>
                </div><!-- /.box-body -->
            </div>
            <div class="text-right">
                <?php echo $products->appends( Input::except('page') )->render() ?>
            </div>


        </div>

    </section>
@endsection