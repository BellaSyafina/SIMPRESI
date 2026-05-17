<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        return view('Admin.settings.index');
    }
    public function password()
    {
        return view('Pages.settings.password');
    }

    public function security()
    {
        return view('Pages.settings.security');
    }

    public function session()
    {
        return view('Pages.settings.session');
    }

    public function notification()
    {
        return view('Pages.settings.notification');
    }

    public function appearance()
    {
        return view('Pages.settings.appearance');
    }
}
