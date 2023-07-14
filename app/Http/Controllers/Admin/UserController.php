<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->get();
        return $users;
    }

    public function store()
    {
        request()->validate([
            'email' => 'required|unique:users,email',
        ]);
        
        $user = User::create([
            'name' => request('name'),
            'email' => request('email'),
            'password' => request('password')
        ]);

        return $user;
    }

    public function update(User $user)
    {
        request()->validate([
            'email' => 'required|unique:users,email,' . $user->id,
        ]);

        $user->update([
            'name' => request('name'),
            'email' => request('email'),
            'password' => request('password') ? bcrypt(request('password')) : $user->password,
        ]);

        return $user;
    }
}
