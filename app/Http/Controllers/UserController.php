<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function getUsersWithRole3()
{
    $users = User::where('role_id', 3)->get(['id', 'name']);
    return response()->json($users);
}

public function getUsers()
{
    $users = User::all();

    return response()->json(['users' => $users]);
}

public function getUserName2()
{
    $usuarios = User::where('role_id', 2)->get();

    return response()->json($usuarios);
}
}
