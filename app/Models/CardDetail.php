<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CardDetail extends Model
{
    use HasFactory;
    /**
     * Define table name
     * @var string
     */
    protected $table = 'card_details';

    protected $fillable = [
        'word',
        'spelling',
        'word_type',
        'audio_link',
        'example',
        'type_card',
        'means'

    ];
}
