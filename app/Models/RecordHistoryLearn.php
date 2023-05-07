<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecordHistoryLearn extends Model
{
    use HasFactory;
    protected $table = 'record_history_learns';
    protected $fillable = ['user_id','number_card_learn','status','time_avg'];
}
