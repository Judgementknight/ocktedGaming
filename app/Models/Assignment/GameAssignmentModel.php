<?php

namespace App\Models\Assignment;

use Illuminate\Database\Eloquent\Model;
use App\Models\OcktedGameModel;

class GameAssignmentModel extends Model
{
    protected $table = 'game_assignments';

    protected $primaryKey = 'assignment_id';

    public $timestamps = true;

    protected $fillable = [
        'game_assignment_code',
        'game_code',
        'classroom_code',
        'assignment_title',
        'due_date',
    ];

    public function game()
    {
        return $this->belongsTo(OcktedGameModel::class, 'game_code', 'game_code');
    }

}
