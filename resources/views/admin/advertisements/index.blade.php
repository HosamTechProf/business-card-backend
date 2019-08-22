@extends('admin.layout.app')
@section('title')
Advertisements Page
@endsection

@section('content')
@component('admin.layout.header', ['nav_title' => 'صفحة الاعلانات'])
@endcomponent
<div class="row">
<div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">
                <a href="{{ route('admin.addAdvertisementGet') }}" style="display: inline-block;float: left;color: black" class="btn btn-secondary pull-right">اضافة اعلان</a>
                  <h4 class="card-title ">كل الاعلانات</h4>
                  <p style="display: inline-block;" class="card-category">هنا يمكنك حذف وتعديل الاعلانات</p>
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
                          اللينك
                        </th>
                        <th>
                          الصورة
                        </th>
                        <th>
                          تعديلات
                        </th>
                      </tr></thead>
                      <tbody>
 					@foreach($advertisements as $advertisement)
					<tr>
						<td>{{$advertisement->id}}</td>
						<td>{{$advertisement->name}}</td>
						<td>{{$advertisement->link}}</td>
            <td><img src="{{$advertisement->photo}}" width="140px"></td>
            <td class="td-actions text-right">
              <a href="{{ route('admin.advertisementEditGet', ['id' => $advertisement->id]) }}" rel="tooltip" class="btn btn-primary btn-link btn-sm" data-original-title="تعديل">
                <i class="material-icons">edit</i>
              </a>
              <a href="{{ route('admin.advertisementDelete', ['id' => $advertisement->id]) }}" rel="tooltip" class="btn btn-danger btn-link btn-sm" data-original-title="حذف">
                <i class="material-icons">close</i>
              </a>
            </td>
					</tr>
 					@endforeach
                      </tbody>
                    </table>
                  </div>
                <div class="clearfix">{{$advertisements->links()}}</div>
                </div>
              </div>
            </div>
            </div>
@endsection
