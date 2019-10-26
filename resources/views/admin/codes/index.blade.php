@extends('admin.layout.app')
@section('title')
Codes Page
@endsection

@section('content')
@component('admin.layout.header', ['nav_title' => 'صفحة اكواد الدول'])
@endcomponent
<div class="row">
<div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">
                <a href="{{ route('admin.showCodesForm') }}" style="display: inline-block;float: left;color: black" class="btn btn-secondary pull-right">اضافة كود دولة</a>
                  <h4 class="card-title ">كل الاكواد</h4>
                  <p style="display: inline-block;" class="card-category">هنا يمكنك حذف وتعديل اكواد الدول</p>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table">
                      <thead class=" text-primary">
                        <tr><th>
                          #
                        </th>
                        <th>
                          اسم الدولة
                        </th>
                        <th>
                          الكود
                        </th>
                        <th>
                          الاختصار
                        </th>
                        <th>
                          تعديلات
                        </th>
                      </tr></thead>
                      <tbody>
 					@foreach($codes as $code)
					<tr>
						<td>{{$code->id}}</td>
            <td>{{$code->name}}</td>
						<td>{{$code->dial_code}}</td>
						<td>{{$code->code}}</td>
            <td class="td-actions text-right">
              <a href="{{ route('admin.deleteCode', ['id' => $code->id]) }}" rel="tooltip" class="btn btn-danger btn-link btn-sm" data-original-title="حذف">
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
