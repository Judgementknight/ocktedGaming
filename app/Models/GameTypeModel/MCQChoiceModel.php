<?php

namespace App\Models\GameTypeModel;

use Illuminate\Database\Eloquent\Model;
use App\Models\GameTypeModel\MCQQuestionModel;

class MCQChoiceModel extends Model
{
    protected $table = 'mcq_options';

    protected $primaryKey = 'option_id';

    public $timestamps = true;

    protected $fillable = [
        'mcq_id',
        'option_text',
    ];

    public function question()
    {
        return $this->belongsTo(MCQQuestionModel::class, 'mcq_id', 'mcq_id');
    }
}
