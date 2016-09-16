@extends('layouts.dashboard')

@section('content')
    <!-- Content Header (Page header) -->

    <ol class="breadcrumb">
        <li><a href="{{ BASE_URL }}/events"><i class="fa fa-home"></i> Dashboard</a></li>
        <li class="active">Edit Product</li>
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
                <!-- text input -->

            <div class="info-msg" style="display: none">
                <div class="alert alert-danger">
                    <strong>Error!</strong> <span class="msg"></span>
                </div>
                <div class="alert alert-success">
                    <strong>Success!</strong> <span class="msg"></span>
                </div>
            </div>

            <a href="/event/{{$event->id}}/products" class="btn btn-primary submit"><i class="fa fa-long-arrow-left"></i> Back to List</a>
            <br/><br/>
            
                <form action="/event/{{$event->id}}/products/{{$product->id}}" id="form-update-product" method="post">
                <?php echo Form::token(); ?>
                <input type="hidden" name="_method" value="put" />
                <input type="hidden" name="event_id" value="{{$event->id}}" />
                <input type="hidden" name="product_id" value="{{$product->id}}" /> 
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Product Name: *</label>
                            <input required type="text" class="form-control" name="product_name" value="{{$product->product_name}}">
                        </div>

                        <div class="form-group">
                            <label>Product Price: *</label>

                            <div class='input-group col-md-2'>
                                <span class="input-group-addon" id="basic-addon1">$</span>
                                <input required type="text" class="form-control" name="product_price" value="{{$product->product_price}}">
                            </div>
                        </div>
                    
                        <div class="form-group">
                            <label>Product Details:</label>
                            <textarea class="form-control" name="product_description" style="min-height: 200px">{{$product->product_description}}</textarea>
                        </div>

                        <div class="form-group">
                            <input type="submit" class="btn btn-primary" value="Save Product">
                        </div>
                    </div>

                </div>    
            

            </form>
        </div>

    </section>
@endsection