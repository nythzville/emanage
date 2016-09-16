@extends('layouts.users.default')

@section('content')
	<!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <?php echo ucfirst($user->user_name) ?> | 
            <small>Change Email</small>
        </h1>
    </section>

    <ol class="breadcrumb">
        <li><a href="{{ BASE_URL }}/dashboard"><i class="fa fa-home"></i> Dashboard</a></li>
        <li class="active">Change Email</li>
    </ol>

    <section class="content">
        <div class="col-md-6">
            {!! Form::open( array('id'=>'form-change-email', 'method'=>'post') ) !!}
                <!-- text input -->
                <div class="form-group">
                    <label>Please provide a working email:</label>
                    <input type="email" class="form-control" name="user_email" value="" placeholder="New Email">
                </div>

                <div class="info-msg" style="display: none">
                    <div class="alert alert-danger">
                        <strong>Error!</strong> <span class="msg"></span>
                    </div>
                    <div class="alert alert-success">
                        <strong>Success!</strong> <span class="msg"></span>
                    </div>
                </div>
                <input data-svalue="Please wait.." value="Change" type="submit" class="btn btn-primary submit">
            </form>
        </div>
    </section>
@endsection