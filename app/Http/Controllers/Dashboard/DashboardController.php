<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Message;
use Auth;

class DashboardController extends Controller
{
    public function index() {
        $user = User::where('role', 'user')->get();
        $message = Message::get();

        return view('dashboard.dashboard', ['user' => $user, 'message' => $message]);
    }
}
