<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StreamHistory extends Model
{
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $table = 'stream_history';

    protected $fillable = ['twitch_id', 'date_start', 'date_end', 'average_num_viewers', 'categories', 'broadcaster_id'];

    public function broadcaster()
    {
        return $this->belongsTo(Broadcaster::class);
    }
}
