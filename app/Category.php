<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $guarded = ['id'];
    protected $fillable = ['name', 'twitch_id', 'image_url'];

    protected $table = 'categories';
}
