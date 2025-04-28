<?php

namespace App\Models\Assignment;

use Illuminate\Database\Eloquent\Model;
use App\Models\OcktedStudentModel;
use App\Models\Assignment\CustomGameAssignmentModel;

class CustomAssignmentCompleteModel extends Model
{
    protected $table = 'custom_assignment_complete';

    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'student_id',
        'custom_game_assignment_code',
        'score',
        'assignment_status',
        'submitted_at',
    ];

    public function student()
    {
        return $this->belongsTo(OcktedStudentModel::class,'student_id','student_id');
    }

    public function assignment()
    {
        return $this->belongsTo(CustomGameAssignmentModel::class,'custom_game_assignment_code', 'custom_game_assignment_code');
    }

}
