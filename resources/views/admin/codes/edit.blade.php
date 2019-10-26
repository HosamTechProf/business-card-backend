@extends('admin.layout.app')
@section('title')
Edit Advertisement
@endsection

@section('content')
@component('admin.layout.header', ['nav_title' => 'تعديل اعلان'])
@endcomponent
      <div class="content">
        <div class="container-fluid">
          <div>
            <div>
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title">تعديل اعلان</h4>
                </div>
                <div class="card-body">
                  <form method="POST" action="{{ route('admin.advertisementSave', ['id' => $advertisement->id]) }}" enctype="multipart/form-data">
                    <div class="row">
                      {{ csrf_field() }}
                      <div class="col-md-12">
                        <div class="form-group">
                          <label class="bmd-label-floating">الإسم</label>
                          <input type="text" class="form-control" value="{{ $advertisement->name }}" name="name">
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label class="bmd-label-floating">اللينك</label>
                          <input type="text" class="form-control" value="{{ $advertisement->link }}" name="link">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label class="bmd-label-floating" for="customFile">الصورة</label>
                          <div class="custom-file">
                            <input onchange="document.getElementById('output').src = window.URL.createObjectURL(this.files[0])" type="file" name="photo" class="custom-file-input" id="customFile">
                            <label class="custom-file-label" for="customFile">اختار صورة الاعلان</label>
                          </div>
                            <img id="output" src="{{$advertisement->photo}}" class="img-fluid">
                        </div>
                      </div>
                    </div>
                    <button type="submit" class="btn btn-primary pull-right">تعديل</button>
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
