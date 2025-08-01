<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserOfGroup extends Model
{
    use HasFactory;

    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'users_of_id',
        'groups_of_id',
    ];

    //
    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function group():BelongsTo
    {
        return $this->belongsTo(Group::class);
    }
}
