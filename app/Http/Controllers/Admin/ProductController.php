<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\CreateDetailProductRequest;
use App\Http\Requests\Product\CreateProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ProductController extends Controller
{
    protected $category;
    protected $product;

    public function __construct(Product $product, Category $category)
    {
        $this->product = $product;
        $this->category = $category;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = $this->product->with('category')->oldest('id')->paginate(3);

        return view('admin.products.index', compact('products'), [
            'title' => 'Danh sách sản phẩm'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = $this->category->get(['id', 'name_category']);

        return view('admin.products.create', compact('categories'),  [
            'title' => 'Thêm sản phẩm'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateProductRequest $request)
    {
        $file_name = null;
        $mainProductSaved = false;

        try {
            // Process main product data (e.g., image upload)
            if ($request->hasFile('image_upload')) {
                $file = $request->file('image_upload');
                $ext = $file->extension();
                $file_name = 'product-' . uniqid() . '.' . $ext;;
                $file->move(public_path('upload/products'), $file_name);
            }

            $request->merge(['avt' => $file_name]);

            // Start transaction
            DB::beginTransaction();

            // Save main product
            $product = Product::create([
                'id_category' => $request->input('id_category'),
                'name_product' => $request->input('name_product'),
                'price' => $request->input('price'),
                'description' => $request->input('description'),
                'avt' => $request->input('avt')
            ]);

            $id_product = $product->id;

            // Process product details
            if ($request->has('details')) {
                $details = $request->input('details', []);

                foreach ($details as $index => $detail) {
                    $file_detail = $request->file('details.' . $index . '.image_detail_upload');

                    // Process detail data (e.g., image upload)
                    if ($file_detail) {
                        $ext = $file_detail->extension();
                        $file_name_detail = 'product-detail-' . uniqid() . '.' . $ext;;
                        $file_detail->move(public_path('upload/products/details'), $file_name_detail);
                    } else {
                        $file_name_detail = $request->input('avt');
                        $currentPath = public_path('upload/products') . '/' . $file_name_detail;
                        $newPath = public_path('upload/products/details') . '/' . $file_name_detail;
                        \File::copy($currentPath, $newPath);
                    }

                    $productDetail = ProductDetail::create([
                        'id_product' => $id_product,
                        'size' => $detail['size'],
                        'color' => $detail['color'],
                        'avt_detail' => $file_name_detail,
                        'inventory_number' => $detail['inventory_number'],
                    ]);

                    $productDetail->product()->associate($product);
                    $productDetail->save();
                }
            }

            DB::commit();

            // Indicate that the main product is successfully saved
            $mainProductSaved = true;

            Session::flash('success', 'Thêm Sản phẩm thành công');
        } catch (\Exception $err) {
            // Rollback transaction in case of any error
            DB::rollBack();

            // If an error occurs and the main product is not saved, return with an input
            if (!$mainProductSaved) {
                Session::flash('error', 'Thêm Sản phẩm lỗi');
                \Log::error($err->getMessage());
                //dd($err->getMessage());
                return redirect()->back()->withInput();
            }

            // If an error occurs after the main product is saved, redirect back
            Session::flash('error', 'Thêm Sản phẩm lỗi');
            \Log::error($err->getMessage());
            //dd($err->getMessage());
            return redirect()->back();
        }

        return redirect()->back();
    }

    public function storeDetail(CreateDetailProductRequest $request, $id)
    {
        $mainProductSaved = false;

        try {
            $product = Product::with('details')->findOrFail($id);

            $id_product = $product->id;
            $avt_product = $product->avt;

            // Process product details
            if ($request->has('details')) {
                $details = $request->input('details', []);

                foreach ($details as $index => $detail) {
                    $file_detail = $request->file('details.' . $index . '.image_detail_upload');

                    // Process detail data (e.g., image upload)
                    if ($file_detail) {
                        $ext = $file_detail->extension();
                        $file_name_detail = 'product-detail' . uniqid() . '.' . $ext;
                        $file_detail->move(public_path('upload/products/details'), $file_name_detail);
                    } else {
                        $file_name_detail = $avt_product;
                        $currentPath = public_path('upload/products') . '/' . $file_name_detail;
                        $newPath = public_path('upload/products/details') . '/' . $file_name_detail;
                        \File::copy($currentPath, $newPath);
                    }

                    $productDetail = ProductDetail::create([
                        'id_product' => $id_product,
                        'size' => $detail['size'],
                        'color' => $detail['color'],
                        'avt_detail' => $file_name_detail,
                        'inventory_number' => $detail['inventory_number'],
                    ]);

                    $productDetail->product()->associate($product);
                    $productDetail->save();
                }
            }

            DB::commit();

            // Indicate that the main product is successfully saved
            $mainProductSaved = true;

            Session::flash('success', 'Thêm Sản phẩm thành công');
        } catch (\Exception $err) {
            // Rollback transaction in case of any error
            DB::rollBack();

            // If an error occurs and the main product is not saved, return with an input
            if (!$mainProductSaved) {
                Session::flash('error', 'Thêm Sản phẩm lỗi');
                \Log::error($err->getMessage());
                dd($err->getMessage());
                return redirect()->back()->withInput();
            }

            // If an error occurs after the main product is saved, redirect back
            Session::flash('error', 'Thêm Sản phẩm lỗi');
            \Log::error($err->getMessage());
            //dd($err->getMessage());
            return redirect()->back();
        }

        return redirect()->back();
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $product = Product::with('details')->findOrFail($id);
        return view('admin.products.detail', compact('product'), [
            'title' => 'Chi tiết sản phẩm'
        ]);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $categories = $this->category->get(['id', 'name_category']);
        $product = Product::with('details')->findOrFail($id);
        return view('admin.products.update', compact(['categories', 'product']), [
            'title' => 'Cập nhật sản phẩm'
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, string $id)
    {
        //dd($request->all());
        try {
            // Lấy thông tin sản phẩm cần cập nhật
            $product = Product::findOrFail($id);
            $file_name = $product->avt;
            // Xử lý upload ảnh
            if ($request->hasFile('image_upload')) {
                $file = $request->file('image_upload');
                $ext = $file->extension();
                $file_name = 'product-' . uniqid() . '.' . $ext;;
                $file->move(public_path('upload/products'), $file_name);


                // Cập nhật tên ảnh mới cho sản phẩm
                $product->avt = $file_name;
            }

            // Cập nhật thông tin sản phẩm
            $product->id_category = $request->input('id_category');
            $product->name_product = $request->input('name_product');
            $product->price = $request->input('price');
            $product->description = $request->input('description');
            $product->save();

            // Cập nhật thông tin chi tiết sản phẩm
            if ($request->has('details')) {
                $details = $request->input('details', []);
                foreach ($details as $index => $detail) {
                    $file_detail = $request->file('details.' . $index . '.image_detail_upload');

                    // Process detail data (e.g., image upload)
                    if ($file_detail) {
                        $ext = $file_detail->extension();
                        $file_name_detail = 'product-detail' . uniqid() . '.' . $ext;;
                        $file_detail->move(public_path('upload/products/details'), $file_name_detail);
                    } else {
                        $file_name_detail =  $detail['avt_detail_hidden'];
                    }

                    // Tìm chi tiết sản phẩm cụ thể cần cập nhật
                    $productDetail = ProductDetail::findOrFail($detail['id']);

                    // Cập nhật thông tin chi tiết sản phẩm
                    $productDetail->update([
                        'size' => $detail['size'],
                        'color' => $detail['color'],
                        'avt_detail' => $file_name_detail,
                        'inventory_number' => $detail['inventory_number'],
                    ]);
                }
            }

            Session::flash('success', 'Cập nhật Sản phẩm thành công');
        } catch (\Exception $err) {
            Session::flash('error', 'Cập nhật Sản phẩm lỗi');
            \Log::error($err->getMessage());
            dd($err->getMessage());
            return redirect()->back()->withInput();
        }

        return redirect()->back();
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $product = Product::findOrFail($id);
            $product->delete();

            return redirect()->back()->with('success', 'Xóa sản phẩm thành công');
        } catch (\Exception $e) {
            // Nếu có lỗi, xử lý nó tại đây
            return redirect()->back()->with('error', 'Xóa sản phẩm thất bại');
        }
    }

    public function destroyDetail($id, $deleteAll = false)
    {
        try {
            $detail = ProductDetail::findOrFail($id);
            $detail->delete();

            return redirect()->back()->with('success', 'Xóa chi tiết sản phẩm thành công');
        } catch (\Exception $e) {
            // Nếu có lỗi, xử lý nó tại đây
            return redirect()->back()->with('error', 'Xóa chi tiết sản phẩm thất bại');
        }
    }
    public function destroyAllDetail($id)
    {
        try {
            // Xóa tất cả chi tiết của sản phẩm
            ProductDetail::where('id_product', $id)->delete();

            return redirect()->back()->with('success', 'Tất cả chi tiết đã được xóa thành công!');
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return redirect()->back()->with('error', 'Xóa chi tiết thất bại.');
        }
    }
}
