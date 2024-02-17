<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Users</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
    <div class="container-fluid">

    
@if(session()->has('message'))
<div class="alert alert-success" style="color:green;">
{{ session()->get('message') }}
</div>
@endif
@if (count($errors) > 0)
<div class="alert alert-danger" role="alert" style="color:#fff;background-color:red;">
<strong>Errors:</strong>
<ul style="list-style-type: none">
@foreach($errors->all() as $error)
<li>{{ $error }}</li>
@endforeach  
</div>
@endif
</ul>
<form method="post" action="{{route('createusers')}}">
    @csrf
  <div class="form-group">
    <label for="first_name">First Name</label>
    <input type="text" class="form-control" id="first_name" name="first_name"  placeholder="Enter first Name" value="{{old('first_name')}}">
  </div>
  <div class="form-group">
    <label for="last_name">Last Name</label>
    <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Enter Last name" value="{{old('last_name')}}">
</div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>