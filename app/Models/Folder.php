<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\GroupCard;

class Folder extends Model
{
    use HasFactory;
    protected $fillable =['folder_name'];

    public function groupCard():HasMany
    {
        return $this->hasMany(GroupCard::class);
    }
}
