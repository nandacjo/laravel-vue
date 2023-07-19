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
        // ->map(function ($user) {
        // dd($user->created_at->toFormattedDate());
        //     return [
        //         'id' => $user->id,
        //         'name' => $user->name,
        //         'email' => $user->email,
        //         // 'created_at' => $user->created_at->format('Y-m-d'),
        //         // 'created_at' => $user->created_at->config('app.date.format'),
        //         'created_at' => $user->created_at->toFormattedDate(),
        //     ];
        // });
        return $users;
    }

    public function store()
    {
        request()->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required|min:8'
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
            'name' => 'required',
            'email' => 'required|unique:users,email,' . $user->id,
            'password' => 'sometimes|min:8'
        ]);

        $user->update([
            'name' => request('name'),
            'email' => request('email'),
            'password' => request('password') ? bcrypt(request('password')) : $user->password,
        ]);

        return $user;
    }

    public function destroy(User $user)
    {
        $user->delete();

        return response()->noContent();
    }
}
