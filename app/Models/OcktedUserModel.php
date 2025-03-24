<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\OcktedScoreModel;

class OcktedUserModel extends Model
{
    protected $table = 'ockted_users';

    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'username',
        'ockted_username',
        'school_code',
        'game_token',
        'profile_picture',
        'rank',
    ];

    public function scores()
    {
        return $this->hasMany(OcktedScoreModel::class, 'user_id', 'user_id');
    }
}
