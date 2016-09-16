@extends('layouts.dashboard')

@section('content')
    <!-- Content Header (Page header) -->

    <ol class="breadcrumb">
        <li><a href="{{ BASE_URL }}/events"><i class="fa fa-home"></i> Dashboard</a></li>
        <li class="active">Edit Tag</li>
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

            <a href="/tags" class="btn btn-primary submit"><i class="fa fa-long-arrow-left"></i> Back to List</a>
            <br/><br/>
            
                <form action="/tags/{{ $tag->id }}" id="form-update-product" method="post">
                <?php echo Form::token(); ?>
                <input type="hidden" name="_method" value="put" />
                <input type="hidden" name="tag_id" value="{{$tag->id}}"/>
                <input type="hidden" name="user_id" value="{{$tag->user_id}}"/>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Tag Name:</label>
                            <input required type="text" class="form-control" id="tag_name_edit" name="tag_name" value="{{ $tag->tag_name }}">
                        </div>

                        <div class="form-group">
                            <label>Tag URL:</label>
                            <input type="text" class="form-control" id="tag_url_edit_2" value="{{ $tag->tag_url }}" disabled>
                            <input required type="hidden" class="form-control" id="tag_url_edit" name="tag_url" value="{{ $tag->tag_url }}">
                        </div>

                        <div class="form-group">
                            <input type="submit" class="btn btn-primary" value="Save Tag">
                        </div>
                    </div>

                </div>    
            

            </form>
        </div>

    </section>
@endsection