<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
{
    use HasFactory, UUID, SoftDeletes;


    protected $fillable = [
        'id_event',
        'sender_name',
        'sender_unique_char',
        'content',
    ];
}
