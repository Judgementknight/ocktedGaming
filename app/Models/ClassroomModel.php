<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\GameroomModel;
use App\Models\Assignment\CustomGameAssignmentModel;

class ClassroomModel extends Model
{
    protected $table = 'classrooms';

    protected $primaryKey = 'classroom_id';

    public $timestamps = true;

    protected $fillable = [
        'classroom_title',
        'classroom_description',
        'teacher_id',
        'school_code',
        'classroom_code',
        'class_level',
        'classroom_color',
    ];

    public function teacher()
    {
        return $this->belongsTo(OcktedTeacherModel::class,'teacher_id','teacher_id');
    }

    public function students()
    {
        return $this->belongsToMany(
            OcktedStudentModel::class, // The related model
            'classroom_mapping',     // The pivot table
            'classroom_code',           // Foreign key on the pivot table referencing this gameroom
            'student_id',              // Foreign key on the pivot table referencing the student
            'classroom_code',           // Local key on the gameroom model (here, using gameroom_code instead of id)
            'student_id'               // Local key on the student model (using the student_id column)
        );
    }

    public function gamerooms()
    {
        return $this->hasMany(GameroomModel::class, 'classroom_code', 'classroom_code');
    }

    public function assignments()
    {
        return $this->hasManyThrough(
            CustomGameAssignmentModel::class, // Final model
            GameroomModel::class,        // Intermediate model
            'classroom_code',            // Foreign key on GameroomModel that links to ClassroomModel
            'gameroom_code',             // Foreign key on GameAssignmentModel that links to GameroomModel
            'classroom_code',            // Local key on ClassroomModel
            'gameroom_code'              // Local key on GameroomModel
        );
    }
}
