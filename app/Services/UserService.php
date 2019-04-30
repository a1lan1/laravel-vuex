<?php

namespace App\Services;

use App\User;
use Illuminate\Support\Facades\Redis;

class UserService
{
    /**
     * @var User
     */
    private $user;

    /**
     * UserService constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * All users
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUsers()
    {
        if ($users = Redis::get('users.all')) {
            return json_decode($users);
        }

        $users =$this->user->with('roles')->get();

        // store data into redis for next 24 hours
        Redis::setex('users.all', 60 * 60 * 24, $users);

        return response()->json($users);
    }
}
