<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    // Edit user profile
    public function edit()
    {
        return view('user.profile');
    }

    // Update user profile
    public function update(Request $request)
    {
        // Validate $request

        // Update user in the database and redirect to previous page
        return back();
    }
}
