<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        return User::where('role', 'regular')->paginate(5);
    }

    public function show($id)
    {
        return User::findOrFail($id);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'login' => 'required|unique:users,login',
            'password' => 'required|min:6',
            'role' => 'required|in:admin,regular'
        ]);

        $user = User::create([
            'login' => $request->login,
            'password' => Hash::make($request->password),
            'role' => $request->role
        ]);

        return $user;
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $this->validate($request, [
            'login' => 'required|unique:users,login,'.$id,
            'role' => 'required|in:admin,regular'
        ]);

        $user->login = $request->login;
        if ($request->has('password') && $request->password != '') {
            $user->password = Hash::make($request->password);
        }
        $user->role = $request->role;
        $user->save();

        return $user;
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json(['success' => true]);
    }
}
