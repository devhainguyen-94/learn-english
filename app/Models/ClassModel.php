<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\User;
class ClassModel extends Model
{
    use HasFactory;

    /**
     * Define table name
     * @var string
     */
    protected $table = 'class';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name'
    ];
    public function users(): HasMany
    {
        return $this->hasMany(User::class,'class_id','id');
    }
}
