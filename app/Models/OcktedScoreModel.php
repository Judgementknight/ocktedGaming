<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\OcktedUserModel;
use App\Models\OcktedGameModel;


class OcktedScoreModel extends Model
{
    protected $table = 'ockted_score';

    protected $primaryKey = 'score_id';

    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'game_code',
        'score',
    ];

    public function user()
    {
        return $this->belongsTo(OcktedUserModel::class, 'user_id', 'user_id');
    }

    public function game()
    {
        return $this->belongsTo(OcktedGameModel::class, 'game_code', 'game_code');
    }
}
