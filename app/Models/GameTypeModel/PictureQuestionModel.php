<?php

namespace App\Models\GameTypeModel;

use Illuminate\Database\Eloquent\Model;
use App\Models\Assignment\CustomGameAssignmentModel;

class PictureQuestionModel extends Model
{
    protected $primaryKey = 'picture_game_id';

    protected $table = 'picture_game';

    public $timestamps = true;

    protected $fillable = [
        'custom_game_assignment_code',
        'question',
        'image_url',
        'correct',
    ];

    public function assignment()
    {
        return $this->belongsTo(CustomGameAssignmentModel::class,'custom_game_assignment_code','custom_game_assignment_code');
    }
}
