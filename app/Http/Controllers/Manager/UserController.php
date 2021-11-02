<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Ramsey\Uuid\Uuid;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{
    public function index()
    {
        return view('manager.user.index');
    }

    public function list(Request $request)
    {
        if ($request->ajax()) {
            $data = User::latest()->get();
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
            'user_name' => 'required',
            'password' => 'required'
        ]);

        $dataPost = $request->all();
        $dataPost['id'] = Uuid::uuid4()->toString();
        $dataPost['password'] = bcrypt($dataPost['password']);

        $save = User::create($dataPost);

        if ($save->exists) {
            return response()->json(['status' => true, 'message' => 'insert success']);
        } else {
            return response()->json(['status' => false, 'message' => 'insert failed']);
        }
    }

    public function edit($id)
    {
        $data = User::find($id);
        if (isset($data) && !empty($data)) {
            return response()->json(['status' => true, 'data' => $data, 'message' => 'find data']);
        }
        return response()->json(['status' => false, 'message' => 'cannot find data', 'data' => []]);
    }

    public function update($id, Request $request)
    {
        $request->validate([
            'id' => 'required',
            'user_name' => 'required'
        ]);

        DB::beginTransaction();
        try {
            User::where('id', $id)->update($request->except(['_token']));
            DB::commit();
            return response()->json(['status' => true, 'message' => 'update success']);
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollback();
            return response()->json(['status' => false, 'message' => 'update failed']);
        }
    }

    public function destroy($id)
    {
        User::find($id)->delete();

        return response()->json(['status' => true, 'message' => 'delete success']);
    }

    public function changePassword()
    {
        return view('manager.user.change-password');
    }

    public function submitChangePassword(Request $request)
    {
        $id = Auth::user()->id;
        $user = User::find($id);
        if (!Hash::check($user->password, $request->password_old)) {
            return response()->json(['status' => false, 'message' => 'wrong password !']);
        }

        DB::beginTransaction();
        try {
            User::where('id', $id)->update($request->except(['_token']));
            DB::commit();
            return response()->json(['status' => true, 'message' => 'change password success']);
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollback();
            return response()->json(['status' => false, 'message' => 'change password failed']);
        }
    }
}
