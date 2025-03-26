<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class OcktedScoreModel extends Model
{
    protected $table = 'ockted_score';
    protected $primaryKey = 'score_id';
    public $timestamps = true;

    protected $fillable = [
        'ocktedgaming_id', // This will be automatically handled by morphs
        'ockted_type', // This will store either 'App\Models\OcktedStudentModel' or 'App\Models\OcktedTeacherModel'
        'game_code',
        'score',
    ];

    public function ocktedgaming(): MorphTo
    {
        return $this->morphTo();
    }
}
