<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\OcktedStudentModel;
use App\Models\OcktedGameroomModel;

class GameRoomAssignmentModel extends Model
{
    protected $table = 'gameroom_assignment';

    protected $primaryKey = 'gameroom_assignment_id';

    public $timestamps = true;

    protected $fillable = [
        'student_id',
        'gameroom_code',
    ];

    public function student()
    {
        return $this->belongsTo(OcktedStudentModel::class, 'student_id', 'student_id');
    }

    public function gameroom()
    {
        return $this->belongsTo(OcktedGameroomModel::class, 'gameroom_code', 'gameroom_code');
    }
}
