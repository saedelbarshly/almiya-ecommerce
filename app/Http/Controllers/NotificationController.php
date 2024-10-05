<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $admin = Admin::first();
        return view('notification', compact('admin'));
    }
}
