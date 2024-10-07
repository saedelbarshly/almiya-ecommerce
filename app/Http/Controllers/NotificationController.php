<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
{
    $admin = Admin::first();
    $notifications = $admin->notifications()->paginate(5); // Paginate notifications, 10 per page
    return view('notification', compact('notifications'));
}

}
