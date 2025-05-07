<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GolfParticipant extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'phone', 'play_time', 'document_path'];

    protected static function booted()
    {
        static::creating(function ($participant) {
            $participant->uuid = Str::uuid();
        });
    }
}
