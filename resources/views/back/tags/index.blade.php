@extends('layouts.dashboard')

@section('content')
	<!-- Content Header (Page header) -->

    <ol class="breadcrumb">
        <li><a href="{{ BASE_URL }}/dashboard"><i class="fa fa-home"></i> Dashboard</a></li>
        <li class="active">Tags</li>
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

            <a href="/events" class="btn btn-primary"><i class="fa fa-long-arrow-left"></i> Back to List</a>

            <br/><br/>

        <div class="box">
                <div class="box-body no-padding">
                  <table class="table table-condensed">
                    <tbody>
                        <tr class="tbl-head">
                          <th>Tag Name</th>
                          <th>Tag URL</th>
                          <th style="width:20%" colspan="2">Actions</th>
                        </tr>
                    </tbody>
                        <?php $cnt = 1 ?>
                        @if ($tags->isEmpty())
                        <tr>
                            <td colspan="4">
                            <div class="col-md-12">
                                <b>There are no tags added</b>
                            </div>
                            </td>
                        </div>
                        @endif
                        @foreach( $tags as $tag )
                            <tr class="tag {{ $cnt++ % 2 == 0 ? 'even':'' }}" >
                                <td>{{ $tag->tag_name }}</td>
                                <td>{{ $tag->tag_url }}</td>
                                <td style="width: 350px">
                                    <a href="tags/{{ $tag->id }}/edit/" class="btn btn-default" title="Edit tag">
                                       <i class="fa fa-pencil-square-o"></i> Edit
                                    </a>
                                    <a href="#" data-url="categories/{{ $tag->id }}" data-token="{{ csrf_token() }}" class="btn btn-danger tag-delete" title="Delete tag">
                                       <i class="fa fa-trash"></i> Delete
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                   </table>
                </div><!-- /.box-body -->
              </div>

        </div>

    </section>
@endsection