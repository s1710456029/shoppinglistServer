<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Shoppinglist extends Model
{

    protected $fillable = ['title', 'due_date', 'final_sum', 'seeker_id', 'volunteer_id'];

    public function items():HasMany{
    return $this->hasMany(Item::class);
}

    public function seeker():BelongsTo{
        return $this->belongsTo(User::class);
    }

    public function volunteer():BelongsTo{
        return $this->belongsTo(User::class);
    }

    public function comments():HasMany{
        return $this->hasMany(Comment::class);
    }
}
