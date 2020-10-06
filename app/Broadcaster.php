<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Broadcaster extends Model
{
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $guarded = ['id'];

    protected $table = 'broadcasters';

    protected $fillable = ['name', 'twitch_id', 'description', 'text'];

    public function history()
    {
        return $this->belongsToMany(StreamHistory::class);
    }
}
