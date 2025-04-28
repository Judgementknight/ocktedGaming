<?php

namespace App\Models\Assignment;

use Illuminate\Database\Eloquent\Model;
use App\Models\OcktedStudentModel;
use App\Models\Assignment\GameAssignmentModel;

class GameAssignmentCompleteModel extends Model
{
    protected $table = 'game_assignment_complete';

    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'student_id',
        'game_assignment_code',
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
        return $this->belongsTo(GameAssignmentModel::class,'game_assignment_code', 'game_assignment_code');
    }

}
