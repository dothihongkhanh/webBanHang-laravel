<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\CreateCategoryRequest;
use App\Models\Category;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected $category;

    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    public function store(CreateCategoryRequest $request)
    {
        try {
            Category::create([
                'name_category' => $request->input('name_category')
            ]);
    
            Session::flash('success', 'Thêm danh mục thành công');
        } catch (\Exception $err) {
            Session::flash('error', $err->getMessage());
            return false;
        }
    
        return redirect()->back();
    }

    public function index()
    {
        $categories = $this->category->oldest('id')->paginate(4);
        return view('admin.categories.index', compact('categories'),  [
            'title' => 'Danh sách danh mục'
        ]);
    }

   
}
