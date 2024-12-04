<?php

namespace App\Services\V1;

use App\Models\Demolay;
use App\Models\User;
use App\Services\Service;

class UserService extends Service
{
    public function create(array $data): User
    {
        $user = User::create($data);
        unset($data['email'], $data['password']);
        $demolay = Demolay::findByName($data['name']);

        if (empty($demolay)) {
            $user->demolay()->create($data);
        } else {
            $user->update(['demolay_id' => $demolay->id]);
            $demolay->update(['user_id' => $user->id]);
        }

        return $user;
    }
}
