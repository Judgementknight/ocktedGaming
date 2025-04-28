<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\OcktedStudentModel;
use App\Models\ClassroomModel;

class ClassroomMappingModel extends Model
{
    protected $table = 'classroom_mapping';

    protected $primaryKey = 'classroom_mapping_id';

    public $timestamps = true;

    protected $fillable = [
        'student_id',
        'classroom_code',
    ];

    public function student()
    {
        return $this->belongsTo(OcktedStudentModel::class, 'student_id', 'student_id');
    }

    public function classroom()
    {
        return $this->belongsTo(ClassroomModel::class, 'classroom_code', 'classroom_code');
    }
}
