@extends('layouts.app')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ $metadata['page_title'] }}</h1>
                </div>
                <!-- /.col -->
                @if(isset($metadata['breadcumb']) && $metadata['breadcumb'])
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        @foreach ( $metadata['breadcumb'] as $key => $breadcumb ) 
                        <li class="breadcrumb-item {{ $breadcumb['url'] ? '' : 'active' }}">
                            @if(isset($breadcumb['url']) && $breadcumb['url'])
                            <a href="{{ url($breadcumb['url']) }}">{{ $breadcumb['title'] }}</a>
                            @else
                                {{ $breadcumb['title'] }}
                            @endif
                        </li>
                        @endforeach
                    </ol>
                </div>
                @endif
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- right column -->
          <div class="col-md-12">
            <!-- general form elements disabled -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">{{ $metadata['page_title'] }}</h3>
              </div>
              <!-- /.card-header -->
              @if(isset($rows) && !$rows->isEmpty())
                  @foreach ( $rows as $key => $res )
                      <!-- DIRECT CHAT -->
                      <div class="card direct-chat direct-chat-primary">
                        <!-- /.card-header -->
                        <div class="card-body">
                          <!-- Conversations are loaded here -->
                          <div class="direct-chat-messages">
                            <!-- Message. Default to the left -->
                            <div class="direct-chat-msg">
                              <div class="direct-chat-infos clearfix">
                                <span class="direct-chat-name float-left">{{ $res->author->id == 1 ? 'Admin' : $res->author->name }}</span>
                                <span class="direct-chat-timestamp float-right">{{ date('d M, Y h:i A', strtotime($res->created_at)) }}</span>
                              </div>
                              <!-- /.direct-chat-infos -->
                              <img class="direct-chat-img" src="https://adminlte.io/themes/v3/dist/img/AdminLTELogo.png" alt="message user image">
                              <!-- /.direct-chat-img -->
                              <h5>{{ $res->title }}</h5>
                              <div class="direct-chat-text">
                                {{ $res->content }}
                              </div>
                              <!-- /.direct-chat-text -->
                              <ul class="contacts-list">
                                @if(isset($res->comments) && !$res->comments->isEmpty())
                                  @foreach ( $res->comments as $ckey => $cres )
                                    <li>
                                      <a href="#">
                                        <img class="contacts-list-img" src="https://adminlte.io/themes/v3/dist/img/AdminLTELogo.png" alt="User Avatar">

                                        <div class="contacts-list-info">
                                          <span class="contacts-list-name" style="color: black;">
                                            {{ $cres->commentsby->name }}
                                            <small class="contacts-list-date float-right">{{ date('d M, Y h:i A', strtotime($cres->commentsby->created_at)) }}</small>
                                          </span>
                                          <span class="contacts-list-msg">{{ $cres->comment }}</span>
                                        </div>
                                        <!-- /.contacts-list-info -->
                                      </a>
                                    </li>
                                  @endforeach
                                @endif
                              </ul>
                            </div>
                            <!-- /.direct-chat-msg -->
                          </div>
                          <!--/.direct-chat-messages-->
                        </div>
                        <!-- /.card-body -->
                        @if(isset(Auth::user()->id) && Auth::user()->id > 0)
                          <div class="card-footer">
                            <form action="{{ route('comment.store') }}" method="post">
                              @csrf
                              <input type="hidden" name="blog_id" value="{{ $res->id }}">
                              <div class="input-group">
                                <input type="text" name="comment" placeholder="Type comment ..." class="form-control" required="">
                                <span class="input-group-append">
                                  <button type="submit" class="btn btn-primary">Post</button>
                                </span>
                              </div>
                            </form>
                          </div>
                        @endif
                        <!-- /.card-footer-->
                      </div>
                      <!--/.direct-chat -->
                  @endforeach
              @else
                <h2>No record found.</h2>
              @endif
            </div>
            <!-- /.card -->
          </div>
          <!--/.col (right) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection

@section('javascripts')
<script type="text/javascript">
$(document).ready(function() {
    @if(Session::has('flash_data')) 
      @php 
        $flash_data = Session::pull('flash_data');
      @endphp
      toastr.{{ $flash_data['status'] }}("{{ $flash_data['message'] }}");
    @endif    
});
</script>
@endsection
