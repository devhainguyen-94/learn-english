<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLearnCard extends Model
{
    use HasFactory;
    protected $table = 'user_learn_cards';
    protected $fillable = ['user_id', 'group_card_id','card_detail_id','time_remind','const_q','times_learn_again','timme_learn'];
}
