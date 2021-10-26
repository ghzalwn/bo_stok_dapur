<?php

namespace App\Http\Controllers;

use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;
use Ramsey\Uuid\Uuid;

class ProvinceController extends Controller
{
    //
    public function index()
    {
        return view('manager.province.index');
    }

    public function list(Request $request)
    {
        if ($request->ajax()) {
            $data = Province::latest()->get();
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
            'province' => 'required'
        ]);

        $dataPost = $request->all();
        $dataPost['id'] = Uuid::uuid4()->toString();

        $save = Province::create($dataPost);

        if ($save->exists) {
            return response()->json(['status' => true, 'message' => 'insert success']);
        } else {
            return response()->json(['status' => false, 'message' => 'insert failed']);
        }
    }

    public function edit($id)
    {
        $province = Province::find($id);
        if (isset($province) && !empty($province)) {
            return response()->json(['status' => true, 'data' => $province, 'message' => 'find data']);
        }
        return response()->json(['status' => false, 'message' => 'cannot find data', 'data' => []]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id' => 'required',
            'province' => 'required'
        ]);

        $save = Province::where('id', $id)->update($request->all());

        if ($save->exists) {
            return response()->json(['status' => true, 'message' => 'update success']);
        } else {
            return response()->json(['status' => false, 'message' => 'update failed']);
        }
    }

    public function destroy($id)
    {
        Province::find($id)->delete();

        return response()->json(['status' => true, 'message' => 'delete success']);
    }
}
