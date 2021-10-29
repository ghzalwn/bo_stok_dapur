<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\StatusOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;
use Yajra\DataTables\DataTables;

class StatusOrderController extends Controller
{
    public function index()
    {
        return view('manager.status-order.index');
    }

    public function list(Request $request)
    {
        if ($request->ajax()) {
            $data = StatusOrder::latest()->get();
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
            'status' => 'required'
        ]);

        $dataPost = $request->all();
        $dataPost['id'] = Uuid::uuid4()->toString();

        $save = StatusOrder::create($dataPost);

        if ($save->exists) {
            return response()->json(['status' => true, 'message' => 'insert success']);
        } else {
            return response()->json(['status' => false, 'message' => 'insert failed']);
        }
    }

    public function edit($id)
    {
        $statusOrder = StatusOrder::find($id);
        if (isset($statusOrder) && !empty($statusOrder)) {
            return response()->json(['status' => true, 'data' => $statusOrder, 'message' => 'find data']);
        }
        return response()->json(['status' => false, 'message' => 'cannot find data', 'data' => []]);
    }

    public function update($id, Request $request)
    {
        $request->validate([
            'id' => 'required',
            'status' => 'required'
        ]);

        DB::beginTransaction();
        try {
            StatusOrder::where('id', $id)->update($request->except(['_token']));
            DB::commit();
            return response()->json(['status' => true, 'message' => 'update success']);
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollback();
            return response()->json(['status' => false, 'message' => 'update failed']);
        }
    }

    public function destroy($id)
    {
        StatusOrder::find($id)->delete();

        return response()->json(['status' => true, 'message' => 'delete success']);
    }
}
