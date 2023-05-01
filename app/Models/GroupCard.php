<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GroupCard extends Model
{
    protected $table = 'group_cards';
    use HasFactory;
    protected $fillable = [ 'group_name','time_to_complete'];
    /**
     * Relation Detail
     */
    public function cardDetail(): BelongsToMany
    {
        return $this->belongsToMany(CardDetail::class , 'card_detail_group', 'card_detail_id','group_card_id');
    }
}
