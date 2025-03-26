<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\OcktedScoreModel;
use Illuminate\Database\Eloquent\Relations\MorphMany;


class OcktedStudentModel extends Model
{
    protected $table = 'ockted_students';

    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'student_id',
        'ocktedgaming_id',
        'student_name',
        'ocktedgaming_student_username',
        'school_code',
        'student_status',
        'profile_picture',
        'rank',
        'game_token',
        'last_active_at'
    ];

    public function scores(): MorphMany
    {
        return $this->morphMany(OcktedScoreModel::class, 'ocktedgaming');
    }

    public function gamerooms()
    {
        return $this->belongsToMany(
            OcktedGameroomModel::class,
            'gameroom_assignment',
            'student_id',         // This pivot column references the student
            'gameroom_code',      // This pivot column references the gameroom
            'student_id',         // Local key on the student model
            'gameroom_code'       // Local key on the gameroom model
        );
    }
}
