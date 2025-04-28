<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use App\Models\OcktedScoreModel;

class OcktedTeacherModel extends Model
{
    protected $table = 'ockted_teachers';

    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'teacher_id',
        'teacher_name',
        'school_code',
        'game_token',
        'profile_picture',
    ];


    // public function scores(): MorphMany
    // {
    //     return $this->morphMany(OcktedScoreModel::class, 'ocktedgaming');
    // }

    public function classrooms()
    {
        return $this->hasMany(ClassroomModel::class, 'teacher_id', 'teacher_id');
    }

    public function gamerooms()
    {
        return $this->hasMany(OcktedGameroomModel::class, 'teacher_id', 'teacher_id');
    }

}
