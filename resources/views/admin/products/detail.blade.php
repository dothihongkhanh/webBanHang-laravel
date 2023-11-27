@extends('admin.layouts.app')
@section('title', $product->name_product)
@section('content')

<p><a href="/admin/products/list">Danh sách sản phẩm </a>/ <b>{{ $product->name_product }}</b></p>
<form action="" method="POST" enctype="multipart/form-data">
    <div class="form-group">
        <label>Thêm chi tiết sản phẩm</label>
        <div id="detail-container">
            <div class="row detail-row">
                <div class="col-sm-2">
                    <div class="form-group">
                        <label>Size</label>
                        <input type="number" class="form-control" name="details[0][size]" placeholder="Nhập size">
                        @error('details.*.size')
                        <span class="text-danger"> {{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label>Màu sắc</label>
                        <input type="text" class="form-control" name="details[0][color]" placeholder="Nhập màu sắc">
                        @error('details.*.color')
                        <span class="text-danger"> {{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label>Số lượng</label>
                        <input type="number" class="form-control" name="details[0][inventory_number]" placeholder="Nhập số lượng">
                        @error('details.*.inventory_number')
                        <span class="text-danger"> {{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-sm-3">
                    <label>Hình ảnh</label>
                    <input type="file" name="details[0][image_detail_upload]" accept="image/*" class="image-input-detail form-control" data-image-id="detail-image-0">
                    <input type="hidden" name="details[0][avt_detail_hidden]" id="avt-detail-hidden-0" value="">
                    <img src="" class="show-image-detail" alt="" width="80px">
                </div>
                <div class="col-sm-1">

                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-3">
                <a href="javascript:;" class="btn btn-success" id="add-new-detail">Thêm</a>
            </div>
        </div>
    </div>
    <div style="border-top: 1px solid rgba(0, 0, 0);">
        <button type="submit" class="btn btn-primary mt-3">Thêm Chi tiết</button>
    </div>
    @csrf
</form>
@if ($product->details->isNotEmpty())
<table class="table table-hover">
    <tr>
        <th>Image</th>
        <th>Size</th>
        <th>Color</th>
        <th>Inventory</th>
        <th>Action</th>
    </tr>
    @foreach ($product->details as $detail)
    <tr>
        <td><img src="/upload/products/details/{{ $detail->avt_detail }}" width="100px" height="100px" alt=""></td>
        <td>{{ $detail->size }}</td>
        <td>{{ $detail->color }}</td>
        <td>{{ $detail->inventory_number }}
        <td>
            <form action="/admin/products/delete-details/{id}" method="POST" style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="button" class="btn btn-delete btn-danger" onclick="confirmDelete('{{ $detail->id }}')">Delete</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>
<form action="/admin/products/delete-all-details/{id}" method="POST" style="display: inline;" id="deleteAllForm">
    @csrf
    @method('DELETE')
    <button type="button" class="btn btn-delete btn-danger" onclick="confirmDeleteAll('{{ $product->id }}')">Delete all</button>
</form>
@else
<p>Không có thông tin chi tiết cho sản phẩm này!</p>
@endif
<script>
    function confirmDelete(detailId) {
        if (confirm('Are you sure you want to delete this detail?')) {
            var form = document.createElement('form');
            form.action = `/admin/products/delete-details/${detailId}`;
            form.method = 'POST';
            form.style.display = 'none';

            var csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';
            form.appendChild(csrfToken);

            var methodField = document.createElement('input');
            methodField.type = 'hidden';
            methodField.name = '_method';
            methodField.value = 'DELETE';
            form.appendChild(methodField);

            document.body.appendChild(form);
            form.submit();
        }
    }

    function confirmDeleteAll(productId) {
        if (confirm('Are you sure you want to delete all details?')) {
            var form = document.getElementById('deleteAllForm');
            form.action = "/admin/products/delete-all-details/" + productId;
            form.submit();
        }
    }
</script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="/template/admin/js/product.js"></script>
@endsection