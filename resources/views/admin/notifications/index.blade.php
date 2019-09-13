@extends('admin.layout.app')
@section('title')
Send Notification
@endsection

@section('content')
@component('admin.layout.header', ['nav_title' => 'ارسال اشعار'])
@endcomponent
      <div class="content">
        <div class="container-fluid">
          <div>
            <div>
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title">ارسال اشعار</h4>
                </div>
                <div class="card-body">
                  <form method="POST" action="{{ route('admin.sendNotification') }}">
                      {{ csrf_field() }}

                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label class="bmd-label-floating">عنوان الإشعار</label>
                          <input type="text" class="form-control" value="{{ old('title') }}" name="title">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label class="bmd-label-floating">نص الإشعار</label>
                          <input type="text" class="form-control" value="{{ old('body') }}" name="body">
                        </div>
                      </div>
                    </div>
                    <button type="submit" class="btn btn-primary pull-right">ارسال</button>
                    <div class="clearfix"></div>
                  </form>
                </div>
                @if ($errors->any())
                  <div class="alert alert-danger">
                    <ul>
                  @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                    </ul>
                  </div>
                @endif
              </div>
            </div>
          </div>
        </div>
      </div>
@endsection
