<?php

namespace App\Models\GameTypeModel;

use Illuminate\Database\Eloquent\Model;
use App\Models\Assignment\CustomGameAssignmentModel;

class MathQuestionModel extends Model
{
    protected $primaryKey = 'math_game_id';

    protected $table = 'math_game';

    public $timestamps = true;

    protected $fillable = [
        'custom_game_assignment_code',
        'question',
        'img',
        'correct',
    ];

    public function assignment()
    {
        return $this->belongsTo(CustomGameAssignmentModel::class, 'custom_game_assignment_code', 'custom_game_assignment_code');
    }
}
