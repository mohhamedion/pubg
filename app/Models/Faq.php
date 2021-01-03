<?php

namespace App\Models;

use App;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Faq
 *
 * @property int $id
 * @property string $question_ru
 * @property string $answer_ru
 * @property string $question_en
 * @property string $answer_en
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read mixed $answer
 * @property-read mixed $question
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Faq whereAnswerEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Faq whereAnswerRu($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Faq whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Faq whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Faq whereQuestionEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Faq whereQuestionRu($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Faq whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Faq extends Model
{

    protected $guarded = ['id'];

    protected $appends = [
        'question',
        'answer',
    ];

    public function getQuestionAttribute(): string
    {
        if (App::isLocale('en') && !empty($this->question_en)) {
            return $this->question_en;
        }

        return $this->question_ru;
    }

    public function getAnswerAttribute(): string
    {
        if (App::isLocale('en') && !empty($this->answer_en)) {
            return $this->answer_en;
        }

        return $this->answer_ru;
    }
}
