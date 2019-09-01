@extends('admin.layout.app')
@section('title')
Add User To
@endsection

@section('content')
@component('admin.layout.header', ['nav_title' => 'اضافة عضو عند عضو'])
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
						<td>{{$user->id}}</td>
						<td>{{$user->name}}</td>
						<td>{{$user->email}}</td>
            <td class="td-actions text-right">
              <a href="{{ route('admin.adduserto', ['friendid' => $user->id, 'id' => $id]) }}" rel="tooltip" class="btn btn-primary btn-link btn-sm" data-original-title="اضافة">
                <i class="material-icons">add</i>
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
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>

<script type="text/javascript">
$('#search').on('keyup',function(){
$value=$(this).val();
$.ajax({
type : 'get',
url : '{{URL::to('admin/users/adduserto/search')}}',
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
