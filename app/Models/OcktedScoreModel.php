<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\OcktedStudentModel;

class OcktedScoreModel extends Model
{
    protected $primaryKey = 'score_id';

    protected $table = 'ockted_score';

    public $timestamps = true;

    protected $fillable = [
        'student_id',
        'game_code',
        'score',
    ];

    public function student()
    {
        return $this->belongsTo(OcktedStudentModel::class, 'student_id', 'student_id');
    }
}
