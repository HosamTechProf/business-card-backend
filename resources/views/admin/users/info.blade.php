@extends('admin.layout.app')
@section('title')
User Page
@endsection

@section('content')
@component('admin.layout.header', ['nav_title' => 'صفحة عضو'])
@endcomponent
<div class="row">
<div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">
                <a href="{{ route('admin.userSave', ['id' => $userData->id]) }}" style="display: inline-block;float: left;color: black" class="btn btn-secondary pull-right">تعديل بيانات العضو</a>
                  <h4 class="card-title ">تعديل البيانات</h4>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table">
                      <thead class=" text-primary">
                        <tr><th>
                          #
                        </th>
					             	<td>{{$userData->id}}</td>
                      </tr>
                      <tr>
                        <th>
                          الاسم
                        </th>
					             	<td>{{$userData->name}}</td>
                      </tr>
                      <tr>
                        <th>
                          البريد الالكتروني
                        </th>
						            <td>{{$userData->email}}</td>
                      </tr>
                      <tr>
                        <th>
                          رقم الجوال
                        </th>
                        <td>{{$userData->mobile}}</td>
                      </tr>
                      <tr>
                        <th>
                          رقم الهاتف
                        </th>
                        <td>{{$userData->phone}}</td>
                      </tr>
                      <tr>
                        <th>
                          المنشأة
                        </th>
                        <td>{{$userData->company}}</td>
                      </tr>
                      <tr>
                        <th>
                          نبذة تعريفية
                        </th>
                        <td>{{$userData->desc}}</td>
                      </tr>
                      <tr>
                        <th>
                          حالة البطاقة
                        </th>
                        <td>
                          {{ $userData->isPublic ? 'عامة' : 'خاصة'}}
                        </td>
                      </tr>
                      </tr></thead>
                    </table>
                  </div>
                </div>
              </div>
            </div>
            </div>


<div class="row">
<div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">
                <a href="{{ route('admin.addusertoGet', ['id' => $userData->id]) }}" style="display: inline-block;float: left;color: black" class="btn btn-secondary pull-right">اضافة بطاقة</a>
                  <h4 class="card-title ">بطاقات العضو</h4>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table">
                      <thead class=" text-primary">
                        <tr><th>
                          #
                        </th>
                        <th>
                          الاسم
                        </th>
                        <th>
                          البريد الالكتروني
                        </th>
                        <th>
                          رقم الجوال
                        </th>
                        <th>
                          حذف
                        </th>
                      </tr></thead>
                      <tbody>
          @foreach($userFriends as $user)
          <tr>
            <td><a class="tableAnchor" href="{{ route('admin.userInfo', ['id' => $user->id]) }}">{{$user->id}}</a></td>
            <td><a class="tableAnchor" href="{{ route('admin.userInfo', ['id' => $user->id]) }}">{{$user->name}}</a></td>
            <td><a class="tableAnchor" href="{{ route('admin.userInfo', ['id' => $user->id]) }}">{{$user->email}}</a></td>
            <td><a class="tableAnchor" href="{{ route('admin.userInfo', ['id' => $user->id]) }}">{{$user->mobile}}</a></td>
            <td class="td-actions text-right">
              <a href="{{ route('admin.deleteFollow', ['followed' => $user->id, 'follower' => $userData->id]) }}" rel="tooltip" class="btn btn-danger btn-link btn-sm" data-original-title="حذف">
                <i class="material-icons">close</i>
              </a>
            </td>
          </tr>
          @endforeach
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
            </div>
<div class="row">
<div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title ">البطاقات المفضلة للعضو</h4>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table">
                      <thead class=" text-primary">
                        <tr><th>
                          #
                        </th>
                        <th>
                          الاسم
                        </th>
                        <th>
                          البريد الالكتروني
                        </th>
                        <th>
                          رقم الجوال
                        </th>
                        <th>
                          حذف
                        </th>
                      </tr></thead>
                      <tbody>
          @foreach($userFavourites as $user)
          <tr>
            <td><a class="tableAnchor" href="{{ route('admin.userInfo', ['id' => $user->id]) }}">{{$user->id}}</a></td>
            <td><a class="tableAnchor" href="{{ route('admin.userInfo', ['id' => $user->id]) }}">{{$user->name}}</a></td>
            <td><a class="tableAnchor" href="{{ route('admin.userInfo', ['id' => $user->id]) }}">{{$user->email}}</a></td>
            <td><a class="tableAnchor" href="{{ route('admin.userInfo', ['id' => $user->id]) }}">{{$user->mobile}}</a></td>
            <td class="td-actions text-right">
              <a href="{{ route('admin.deleteFavourite', ['favourited' => $user->id, 'favouriter' => $userData->id]) }}" rel="tooltip" class="btn btn-danger btn-link btn-sm" data-original-title="حذف">
                <i class="material-icons">close</i>
              </a>
            </td>
          </tr>
          @endforeach
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
            </div>
@endsection
