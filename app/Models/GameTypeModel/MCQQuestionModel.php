<?php

namespace App\Models\GameTypeModel;

use Illuminate\Database\Eloquent\Model;
use App\Models\GameTypeModel\MCQChoiceModel;
use App\Models\Assignment\CustomGameAssignmentModel;

class MCQQuestionModel extends Model
{
    protected $table = 'mcq_questions';

    protected $primaryKey = 'mcq_id';

    public $timestamps = true;

    protected $fillable = [
        'custom_game_assignment_code',
        'mcq_question',
        'mcq_correct',
    ];

    public function choices()
    {
        return $this->hasMany(MCQChoiceModel::class, 'mcq_id', 'mcq_id');
    }

    public function game_assignment()
    {
        return $this->belongsTo(CustomGameAssignmentModel::class, 'custom_game_assignment_code', 'custom_game_assignment_code');
    }
}
