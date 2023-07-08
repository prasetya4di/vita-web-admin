<?php

namespace App\Http\Controllers\User;

use App\Actions\Fortify\CreateNewUser;
use App\Http\Controllers\Controller;
use App\Models\UserAccount;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Fortify\Rules\Password;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $data = UserAccount::orderBy('id', 'DESC')->where('role', 'user')->get();
        // dd($data);
        if ($request->ajax()) {
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<a href="javascript:void(0)" class="table-action edit_user" data-id="'.$row->id.'" data-toggle="tooltip" data-original-title="Edit User"><i class="fas fa-user-edit"></i></a>';
                    $btn .= '<a href="javascript:void(0)" class="table-action delete_user" data-id="'.$row->id.'" data-toggle="tooltip" data-original-title="Delete User"><i class="fas fa-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('user.user');
    }

    public function storeUser(Request $request) {
        if ($request->action == 'create') {
            $newUser = new CreateNewUser();
            $user = $newUser->create($request->all());
        } else {
            if ($request->password) {
                $validator = $this->validate(
                    $request,
                    [
                        'nama_user' => 'required',
                        'username' => 'required|unique:users,username,'.$request->user_id,
                        'email' => 'email|nullable|unique:users,email,'.$request->user_id,
                        'password' => (new Password)->length(8)->requireNumeric(),
                    ]
                );

                $user = UserAccount::updateOrCreate(
                    ['id' => $request->user_id],
                    [
                        'name' => $request->nama_user,
                        'username' => $request->username,
                        'email' => $request->email,
                        'birth_date' => $request->birthdate,
                        'password' => Hash::make($request->password),
                    ]
                );
            } else {
                $validator = $this->validate(
                    $request,
                    [
                        'nama_user' => 'required',
                        'username' => 'required|unique:users,username,'.$request->user_id,
                        'email' => 'email|nullable|unique:users,email,'.$request->user_id,
                    ],
                    [
                        'phone.unique' => "This phone number already taken by other user"
                    ]
                );

                $user = UserAccount::updateOrCreate(
                    ['id' => $request->user_id],
                    [
                        'name' => $request->nama_user,
                        'username' => $request->username,
                        'email' => $request->email,
                        'birth_date' => $request->birthdate
                    ]
                );
            }
        }

        return response()->json(['response' => $user]);
    }

    public function fetchUser($id) {
        $user = UserAccount::find($id);
        return response()->json($user);
    }

    public function deleteUser($id) {
        UserAccount::find($id)->delete();
        return response()->json(['success' => 'Data deleted successfully.']);
    }
}
