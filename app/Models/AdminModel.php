<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminModel extends Model
{
    protected $table = 'admin';

    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'username',
        'password',
        'api_token',
        'remember_token',
    ];
}
