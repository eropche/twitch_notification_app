<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BannedUsersCount extends Model
{
    const CREATED_AT = 'created_at';

    protected $table = 'banned_users_count';
}
