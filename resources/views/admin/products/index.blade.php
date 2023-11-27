@extends('admin.layouts.app')
@section('title', 'Danh sách sản phẩm')
@section('content')
<a href="/admin/products/create" class="btn btn-success mb-3">Thêm sản phẩm</a>
<table class="table table-hover">
    <tr>
        <th>ID</th>
        <th>Image</th>
        <th>Category</th>
        <th>Name</th>
        <th>Price</th>
        <th>Description</th>
        <th>Action</th>
    </tr>
    @foreach ($products as $product)
    <tr>
        <td>{{ $product->id }}</td>
        <td><img src="/upload/products/{{ $product->avt }}" width="120px" height="120px" alt=""></td>
        <td>{{ $product->category->name_category }}</td>
        <td>{{ $product->name_product }}</td>
        <td>{{ number_format($product->price, 0, '.', '.') }} VND</td>
        <td>{{ $product->description }}
        <td>
            <a href="/admin/products/detail/{{ $product->id }}" class="btn btn-primary">Detail</a>
            <a href="/admin/products/update/{{ $product->id }}" class="btn btn-warning">Edit</a>
            <form id="delete-form" action="/admin/products/destroy/{{ $product->id }}" method="POST" style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="button" class="btn btn-delete btn-danger" onclick="confirmDelete()">Delete</button>
            </form>

            <script>
                function confirmDelete() {
                    if (confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')) {
                        document.getElementById('delete-form').submit();
                    }
                }
            </script>


        </td>
    </tr>
    @endforeach

</table>
{{ $products->links() }}
@endsection