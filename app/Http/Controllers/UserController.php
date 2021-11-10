<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserCreationRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function store(UserCreationRequest $request): \Illuminate\Http\RedirectResponse
    {
        $user = User::create($request->all());

        return redirect()->route('users.show', [
           'username' => $user->username
        ]);
    }

    public function show(Request $request) {
        return view('user')->with([
            'user' => User::whereUsername($request->route('username'))->firstOrFail()
        ]);
    }
}
