<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccountModel extends Model
{
    protected $primaryKey = 'user_id';

    protected $table = 'user_accounts';

    public $timestamps = true;

    protected $fillable = [
        'username',
        'email',
        'password',
    ];
}
