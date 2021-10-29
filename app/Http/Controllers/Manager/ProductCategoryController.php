<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use Faker\Provider\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;
use Yajra\DataTables\DataTables;

class ProductCategoryController extends Controller
{
    public function index()
    {
        return view('manager.product-category.index');
    }

    public function list(Request $request)
    {
        if ($request->ajax()) {
            $data = ProductCategory::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="javascript:void(0)" class="edit btn btn-success btn-sm" id="btn-edit" data-id="' . $row->id . '">Edit</a>
                    <a href="javascript:void(0)" class="delete btn btn-danger btn-sm" id="btn-delete" data-id="' . $row->id . '">Delete</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'category' => 'required',
            'category_icon' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'url_category' => 'required',
        ]);

        $dataPost = $request->all();
        $dataPost['category_icon'] = time() . '.' . $request->category_icon->extension();
        $request->category_icon->move(public_path('images') . '/uploads/product_category/', $dataPost['category_icon']);
        $dataPost['id'] = Uuid::uuid4()->toString();

        $save = ProductCategory::create($dataPost);

        if ($save->exists) {
            return response()->json(['status' => true, 'message' => 'insert success']);
        } else {
            return response()->json(['status' => false, 'message' => 'insert failed']);
        }
    }

    public function edit($id)
    {
        $statusOrder = ProductCategory::find($id);
        if (isset($statusOrder) && !empty($statusOrder)) {
            return response()->json(['status' => true, 'data' => $statusOrder, 'message' => 'find data']);
        }
        return response()->json(['status' => false, 'message' => 'cannot find data', 'data' => []]);
    }

    public function update($id, Request $request)
    {
        $request->validate([
            'id' => 'required',
            'category' => 'required',
            'url_category' => 'required',
        ]);

        DB::beginTransaction();
        try {
            ProductCategory::where('id', $id)->update($request->except(['_token']));
            DB::commit();
            return response()->json(['status' => true, 'message' => 'update success']);
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollback();
            return response()->json(['status' => false, 'message' => 'update failed']);
        }
    }

    public function destroy($id)
    {
        ProductCategory::find($id)->delete();

        return response()->json(['status' => true, 'message' => 'delete success']);
    }
}
