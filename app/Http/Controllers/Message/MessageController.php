<?php

namespace App\Http\Controllers\Message;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;
use DataTables;

class MessageController extends Controller
{
    public function index(Request $request) {
        $data = Message::with(['users'])->orderBy('id', 'DESC')->get();
        
        if ($request->ajax()) {
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('email', function($row){
                    $email = $row->users->email;
                    return $email;
                })
                ->addColumn('action', function($row){
                    $btn = '<a href="javascript:void(0)" class="table-action delete_message" data-id="'.$row->id.'" data-toggle="tooltip" data-original-title="Delete Message"><i class="fas fa-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('message.message');
    }

    public function deleteMessage($id) {
        Message::find($id)->delete();
        return response()->json(['success' => 'Data deleted successfully.']);
    }
}
