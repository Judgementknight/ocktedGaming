<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ClassroomModel;
use App\Models\Assignment\CustomGameAssignmentModel;

class GameroomModel extends Model
{
    protected $table = 'gamerooms';

    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'gameroom_code',
        'gameroom_type',
        'gameroom_color',
        'classroom_code',
    ];

    public function classrooms()
    {
        return $this->belongsToMany(ClassroomModel::class, 'classroom_code', 'classroom_code');
    }

    public function assignments()
    {
        return $this->hasMany(CustomGameAssignmentModel::class, 'gameroom_code', 'gameroom_code');
    }

    // public function game()
    // {
    //     return $this->belongsTo(OcktedGameModel::class, 'game_code', 'game_code');
    // }
}
