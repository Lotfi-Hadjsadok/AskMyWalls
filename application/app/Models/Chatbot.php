<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Chatbot extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'primary_color',
        'include_not_available_property',
        'welcome_message',
        'headline',
    ];

    protected $casts = [
        'include_not_available_property' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
