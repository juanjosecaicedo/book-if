<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{
    protected $fillable = ['name', 'price', 'stripe_plan_id', 'description'];

}
