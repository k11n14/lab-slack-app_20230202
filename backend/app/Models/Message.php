<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;
    protected $fillable = ['channel_id', 'user_id', 'content'];

    // ミリ秒対応
    protected $dateFormat = 'Y-m-d H:i:s.v';


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function attachments()
    {
        return $this->belongsToMany(Attachment::class);
    }

    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }
}
