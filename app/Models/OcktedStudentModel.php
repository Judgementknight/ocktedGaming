<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\OcktedScoreModel;
use App\Models\ClassroomModel;
use Illuminate\Database\Eloquent\Relations\MorphMany;


class OcktedStudentModel extends Model
{
    protected $table = 'ockted_students';

    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'student_id',
        'student_name',
        'school_code',
        'student_status',
        'profile_picture',
        'rank',
        'game_token',
        'last_active_at'
    ];

    public function scores()
    {
        return $this->hasMany(OcktedScoreModel::class, 'student_id','student_id');
    }

    public function classrooms()
    {
        return $this->belongsToMany(
            ClassroomModel::class,
            'classroom_mapping',
            'student_id',         // This pivot column references the student
            'classroom_code',      // This pivot column references the gameroom
            'student_id',         // Local key on the student model
            'classroom_code'       // Local key on the gameroom model
        );
    }
}
