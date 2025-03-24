<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScoreModel extends Model
{
    protected $primaryKey = 'score_id';

    protected $table = 'scores';

    public $timestamps = true;

    protected $fillable = [
        'game_id',
        'username',
        'game_title',
        'game_description',
        'game_level',
        'game_score',
    ];
}
