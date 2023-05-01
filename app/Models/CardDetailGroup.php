<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CardDetailGroup extends Model
{
    use HasFactory;

    /**
     * Define table name
     * @var string table
     */
    protected $table = 'card_detail_group';

    /**
     * @var string[]
     */
    protected $fillable = ['group_id', 'card_detail_id', 'time_to_complete'];

    public function cardDetail():BelongsTo
    {
        return $this->belongsTo(CardDetail::class , 'card_detail_id');
    }
    public function groupCard():BelongsTo
    {
        return $this->belongsTo(GroupCard::class , 'group_card_id');
    }
}
