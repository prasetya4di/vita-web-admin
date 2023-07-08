<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\UserAccount;
use Auth;

class DashboardController extends Controller
{
    public function index() {
        $user = UserAccount::where('role', 'user')->get();
        $message = Message::get();

        return view('dashboard.dashboard', ['user' => $user, 'message' => $message]);
    }
}
