<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;
use App\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function users()
    {
        if ($users = Redis::get('users.all')) {
            return json_decode($users);
        }

        $users = User::with('roles')->get();

        // store data into redis for next 24 hours
        Redis::setex('users.all', 60 * 60 * 24, $users);

        return response()->json($users);
    }
}
