<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\OcktedScoreModel;

class OcktedGameModel extends Model
{
    protected $primaryKey = 'game_id';

    protected $table = 'ockted_games';

    public $timestamps = true;

    protected $fillable = [
        'game_source',
        'game_code',
        'game_title',
        'game_description',
        'game_banner',
        'game_url',
        'game_status',
    ];

    public function scores()
    {
        return $this->hasMany(OcktedScoreModel::class, 'game_code', 'game_code');
    }
}
