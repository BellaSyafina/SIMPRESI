<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoginActivity extends Model
{
    protected $table = 'login_activities';

    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
