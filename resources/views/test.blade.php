<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<form action="{{ route('admin.sentnot') }}" method="POST">
	{{csrf_field()}}
	<input type="text" name="title">
	<input type="text" name="body">
	<input type="submit">
</form>
</body>
</html>
