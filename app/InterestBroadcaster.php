<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InterestBroadcaster extends Model
{
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $guarded = ['id'];

    protected $table = 'interest_broadcasters';

    protected $fillable = ['name'];
}
