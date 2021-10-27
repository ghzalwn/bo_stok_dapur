<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;
use Yajra\DataTables\DataTables;

class DistrictController extends Controller
{
    public function index()
    {
        $in['provinces'] = Province::all();
        return view('manager.district.index', $in);
    }

    public function list(Request $request)
    {
        if ($request->ajax()) {
            $data = District::latest()->get();
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
            'province_id' => 'required',
            'city_id' => 'required',
            'district' => 'required'
        ]);

        $dataPost = $request->all();
        $dataPost['id'] = Uuid::uuid4()->toString();

        $save = District::create($dataPost);

        if ($save->exists) {
            return response()->json(['status' => true, 'message' => 'insert success']);
        } else {
            return response()->json(['status' => false, 'message' => 'insert failed']);
        }
    }

    public function edit($id)
    {
        $city = District::find($id);
        if (isset($city) && !empty($city)) {
            return response()->json(['status' => true, 'data' => $city, 'message' => 'find data']);
        }
        return response()->json(['status' => false, 'message' => 'cannot find data', 'data' => []]);
    }

    public function update($id, Request $request)
    {
        $request->validate([
            'id' => 'required',
            'province_id' => 'required',
            'city_id' => 'required',
            'district' => 'required'
        ]);

        DB::beginTransaction();
        try {
            District::where('id', $id)->update($request->except(['_token']));
            DB::commit();
            return response()->json(['status' => true, 'message' => 'update success']);
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollback();
            return response()->json(['status' => false, 'message' => 'update failed']);
        }
    }

    public function destroy($id)
    {
        District::find($id)->delete();

        return response()->json(['status' => true, 'message' => 'delete success']);
    }
}
