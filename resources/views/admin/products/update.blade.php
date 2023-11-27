@extends('admin.layouts.app')
@section('title', 'Cập nhật sản phẩm - ' . $product->name_product)
@section('content')
<a href="/admin/products/list" class="btn btn-success mb-2">Danh sách sản phẩm</a>
<form action="" method="POST" enctype="multipart/form-data">
    <div class="">
        <div class="form-group">
            <label>Danh mục</label>
            <select class="form-control" name="id_category">
                @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ $product->id_category == $category->id ? 'selected' : '' }}>{{ $category->name_category }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Tên sản phẩm</label>
            <input type="text" name="name_product" class="form-control" placeholder="Nhập tên sản phẩm" value="{{ $product->name_product }}">
            @error('name_product')
            <span class="text-danger"> {{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label>Giá </label>
            <input type="number" name="price" class="form-control" placeholder="Nhập giá" value="{{ $product->price }}">
            @error('price')
            <span class="text-danger"> {{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label>Mô tả </label>
            <textarea name="description" class="form-control">{{ $product->description }}</textarea>
            @error('description')
            <span class="text-danger"> {{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label>Hình ảnh</label>
            <input type="file" accept="image/*" name="image_upload" id="image-input" class="form-control">
            <img src="/upload/products/{{ $product->avt }}" id="show-image" alt="" width="150px">
            @error('image_upload')
            <span class="text-danger"> {{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label>Chi tiết sản phẩm</label>
            <div id="detail-container">
                @foreach ($product->details as $index => $detail)
                <div class="row detail-row">
                    <input type="hidden" name="details[{{ $index }}][id]" value="{{ $detail->id }}">
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Size</label>
                            <input type="number" class="form-control" name="details[{{ $index }}][size]" placeholder="Nhập size" value="{{ $detail->size }}">
                            @error('details.*.size')
                            <span class="text-danger"> {{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Màu sắc</label>
                            <input type="text" class="form-control" name="details[{{ $index }}][color]" placeholder="Nhập màu sắc" value="{{ $detail->color }}">
                            @error('details.*.color')
                            <span class="text-danger"> {{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Số lượng</label>
                            <input type="number" class="form-control" name="details[{{ $index }}][inventory_number]" placeholder="Nhập số lượng" value="{{ $detail->inventory_number }}">
                            @error('details.*.inventory_number')
                            <span class="text-danger"> {{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <label>Hình ảnh</label>
                        <input type="file" name="details[{{ $index }}][image_detail_upload]" accept="image/*" class="image-input-detail form-control">
                        <input type="hidden" name="details[{{ $index }}][avt_detail_hidden]" value="{{ $detail->avt_detail }}">
                        <img src="/upload/products/details/{{ $detail->avt_detail }}" class="show-image-detail" alt="" width="80px">
                    </div>
                    <div class="col-sm-1">

                    </div>
                </div>
                @endforeach

            </div>
        </div>
    </div>

    <div style="border-top: 1px solid rgba(0, 0, 0);">
        <button type="submit" class="btn btn-primary mt-3">Lưu thay đổi</button>
    </div>
    @csrf
</form>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="/template/admin/js/product.js"></script>
@endsection