<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
        /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'amount', 'category_id', 'description', 'user_id'
    ];
}
