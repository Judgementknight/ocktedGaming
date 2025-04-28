<?php

namespace App\Models\Assignment;

use Illuminate\Database\Eloquent\Model;
use App\Models\GameTypeModel\MCQQuestionModel;
use App\Models\GameTypeModel\PictureQuestionModel;
use App\Models\GameTypeModel\MathQuestionModel;
use App\Models\GameroomModel;

class CustomGameAssignmentModel extends Model
{
    protected $table = 'custom_game_assignments';

    protected $primaryKey = 'assignment_id';

    public $timestamps = true;

    protected $fillable = [
        'custom_game_assignment_code',
        'gameroom_code',
        'assignment_title',
        'due_date',
    ];

    public function questions()
    {
        return $this->hasMany(MCQQuestionModel::class, 'custom_game_assignment_code', 'custom_game_assignment_code');
    }

    public function gameroom()
    {
        return $this->belongsTo(GameroomModel::class,'gameroom_code', 'gameroom_code');
    }

    public function pictures()
    {
        return $this->hasMany(PictureQuestionModel::class,'custom_game_assignment_code','custom_game_assignment_code');
    }

    public function maths()
    {
        return $this->hasMany(MathQuestionModel::class,'custom_game_assignment_code','custom_game_assignment_code');
    }

}
