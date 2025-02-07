@extends('admin.layout.app')
@section('title')
Users Page
@endsection

@section('content')
@component('admin.layout.header', ['nav_title' => 'تعديل بيانات عضو'])
@endcomponent
      <div class="content">
        <div class="container-fluid">
          <div>
            <div>
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title">تعديل بيانات عضو</h4>
                </div>
                <div class="card-body">
                  <form method="POST" action="{{ route('admin.userSave', ['id'=>$userData['id']]) }}">
                    <div class="row">
                      {{ csrf_field() }}
                      <div class="col-md-5">
                        <div class="form-group">
                          <label class="bmd-label-floating">الإسم</label>
                          <input type="text" class="form-control" value="{{$userData['name']}}" name="name">
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label class="bmd-label-floating">رقم الجوال</label>
                          <input type="text" class="form-control" value="{{$userData['mobile']}}" name="mobile">
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">رقم الهاتف</label>
                          <input type="text" class="form-control" value="{{$userData['phone']}}" name="phone">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">الشركة او النشأة</label>
                          <input type="text" class="form-control" value="{{$userData['company']}}" name="company">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">نبذة تعريفية</label>
                          <input type="text" class="form-control" value="{{$userData['desc']}}" name="desc">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">البريد الإلكتروني</label>
                          <input type="text" class="form-control" value="{{$userData['email']}}" name="email">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">كلمة المرور</label>
                          <input type="password" class="form-control" name="password">
                        </div>
                      </div>
                    </div>
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
                            <label class="bmd-label-floating">حالة البطاقة</label>
                            <select name="isPublic" class="custom-select">
                              <option value="">-----</option>
                              <option value="1" {{ $userData->isPublic ? 'selected' : ''}}>عامة</option>
                              <option value="0" {{ !$userData->isPublic ? 'selected' : ''}}>خاصة</option>
                            </select>
                          </div>
                        </div>
                      </div>
                    <button type="submit" class="btn btn-primary pull-right">تعديل البيانات</button>
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
