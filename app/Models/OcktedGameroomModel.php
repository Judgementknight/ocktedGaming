<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OcktedGameroomModel extends Model
{
    protected $table = 'ockted_gameroom';

    protected $primaryKey = 'gameroom_id';

    public $timestamps = true;

    protected $fillable = [
        'teacher_id',
        'school_code',
        'gameroom_code',
        'class_level_gameroom',
        'school_code',
    ];

    public function teacher()
    {
        return $this->belongsTo(OcktedTeacherModel::class,'teacher_id','teacher_id');
    }

    public function students()
    {
        return $this->belongsToMany(
            OcktedStudentModel::class, // The related model
            'gameroom_assignment',     // The pivot table
            'gameroom_code',           // Foreign key on the pivot table referencing this gameroom
            'student_id',              // Foreign key on the pivot table referencing the student
            'gameroom_code',           // Local key on the gameroom model (here, using gameroom_code instead of id)
            'student_id'               // Local key on the student model (using the student_id column)
        );
    }
}
