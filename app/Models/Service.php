<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'category_id',
        'image',
        'attachments',
        'price',
        'duration',
        'description',
        'short_description',
        'is_active',
        'category_id',
        'user_id'
    ];

    protected $casts = ['attachments' => 'array'];


    public function category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
