<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MailConnection extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'email',
        'password',
        'ciphertext',
        'host',
        'port',
        'subject'
    ];

    public function user()
    {
        return $this->belongsTo('\App\Models\User');
    }
}
