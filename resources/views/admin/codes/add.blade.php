@extends('admin.layout.app')
@section('title')
Add Code
@endsection

@section('content')
@component('admin.layout.header', ['nav_title' => 'اضافة كود دولة'])
@endcomponent
      <div class="content">
        <div class="container-fluid">
          <div>
            <div>
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title">اضافة كود</h4>
                </div>
                <div class="card-body">
                  <form method="POST" action="{{ route('admin.addCode') }}" enctype="multipart/form-data">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label class="bmd-label-floating">برجاء اختيار الدولة</label>
                          <select class="form-control form-control-xs selectpicker" name="select_code" data-size="7" data-live-search="true" data-title="Codes" id="state_list" data-width="100%" onchange="changeCode(event)">
                            @foreach($codes as $code)
                            <option value='{ "code":"{{$code->code}}", "dial_code":"{{$code->dial_code}}", "name":"{{$code->name}}" }'>{{$code->name}}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>
                    </div>
                    <br>
                    <div class="row">
                      {{ csrf_field() }}
                      <div class="col-md-12">
                        <div class="form-group" id="test">
                          <label class="bmd-label-floating">الإسم</label>
                          <input type="text" class="form-control" value="{{ old('name') }}" name="name" id="name">
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group" id="test1">
                          <label class="bmd-label-floating">الكود</label>
                          <input type="text" class="form-control" value="{{ old('dial_code') }}" name="dial_code" id="dial_code">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group" id="test2">
                          <label class="bmd-label-floating" for="customFile">الاختصار</label>
                          <input type="text" class="form-control" value="{{ old('code') }}" name="code" id="code">
                        </div>
                      </div>
                    </div>
                    <button type="submit" class="btn btn-primary pull-right">اضافة</button>
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
<script>
  function changeCode(e) {
      var myValue = JSON.parse(e.target.value);
      console.log(myValue)
      document.getElementById("name").value = myValue.name
      document.getElementById("code").value = myValue.code
      document.getElementById("dial_code").value = myValue.dial_code
      document.getElementById("test").className = "form-group is-focused";
      document.getElementById("test1").className = "form-group is-focused";
      document.getElementById("test2").className = "form-group is-focused";
  }
</script>
