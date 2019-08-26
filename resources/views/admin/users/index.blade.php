@extends('admin.layout.app')
@section('title')
Users Page
@endsection

@section('content')
@component('admin.layout.header', ['nav_title' => 'صفحة الأعضاء'])
@endcomponent
<div class="row">
<div class="col-md-12">
  <div class="input-group no-border">
                <input type="text" name="search" id="search" class="form-control" placeholder="بحث...">
                <button type="submit" class="btn btn-default btn-round btn-just-icon">
                  <i class="material-icons">search</i>
                  <div class="ripple-container"></div>
                </button>
              </div>
              <div class="card">
                <div class="card-header card-header-primary">
                <a href="{{ route('admin.addUserGet') }}" style="display: inline-block;float: left;color: black" class="btn btn-secondary pull-right">اضافة عضو</a>
                  <h4 class="card-title ">كل الأعضاء</h4>
                  <p style="display: inline-block;" class="card-category">هنا يمكنك حذف وتعديل الأعضاء</p>
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
                          تعديلات
                        </th>
                      </tr></thead>
                      <tbody>
 					@foreach($users as $user)
					<tr>
						<td><a href="{{ route('admin.userInfo', ['id' => $user->id]) }}">{{$user->id}}</a></td>
						<td><a href="{{ route('admin.userInfo', ['id' => $user->id]) }}">{{$user->name}}</a></td>
						<td><a href="{{ route('admin.userInfo', ['id' => $user->id]) }}">{{$user->email}}</a></td>
            <td class="td-actions text-right">
              <a href="{{ route('admin.userEditGet', ['id' => $user->id]) }}" rel="tooltip" class="btn btn-primary btn-link btn-sm" data-original-title="تعديل">
                <i class="material-icons">edit</i>
              </a>
              <a href="{{ route('admin.userDelete', ['id' => $user->id]) }}" rel="tooltip" class="btn btn-danger btn-link btn-sm" data-original-title="حذف">
                <i class="material-icons">close</i>
              </a>
            </td>
					</tr>
 					@endforeach
                      </tbody>
                    </table>
                  </div>
                <div class="clearfix">{{$users->links()}}</div>
                </div>
              </div>
            </div>
            </div>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>

<script type="text/javascript">
$('#search').on('keyup',function(){
$value=$(this).val();
$.ajax({
type : 'get',
url : '{{URL::to('admin/users/search')}}',
data:{'search':$value},
success:function(data){
$('tbody').html(data);
}
});
})
</script>
<script type="text/javascript">
$.ajaxSetup({ headers: { 'csrftoken' : '{{ csrf_token() }}' } });
</script>
@endsection
