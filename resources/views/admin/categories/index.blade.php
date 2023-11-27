@extends('admin.layouts.app')
@section('title', 'Quản lý danh mục')
@section('content')
<form action="" method="POST">
    <div class="form-group">
        <label for="category">Tên danh mục</label>
        <div class="d-flex">
            <input type="text" name="name_category" class="form-control" placeholder="Nhập tên danh mục">
            <button type="submit" class="btn btn-primary">Thêm</button>
        </div>
    </div>
    @csrf
</form>
<table class="table table-hover">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Action</th>
    </tr>
    @foreach ($categories as $category)
    <tr>
        <td>{{ $category->id }}</td>
        <td>{{ $category->name_category }}</td>
        <td>
            <a href="/admin/categories/update/' .$category->id.'" class="btn btn-warning">Edit</a>
            <button class="btn btn-delete btn-danger">Delete</button>
        </td>
    </tr>
    @endforeach

</table>
{{ $categories->links() }}
@endsection