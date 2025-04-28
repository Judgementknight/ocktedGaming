<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestModel extends Model
{
    protected $table = 'test';

    protected $primaryKey = 'test_id';

    public $timestamps = true;

    protected $fillable = [
        'username',
        'encrypted_session_key',
    ];
}
