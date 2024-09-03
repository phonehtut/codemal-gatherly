<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    use HasFactory;

    protected $table = 'events';

    protected $fillable = [
      'title',
      'description',
      'image',
      'start_date',
      'end_date',
      'org_name',
      'org_email',
      'org_phone',
      'org_logo',
      'category_id',
      'rating',
      'limit',
      'location',
      'plaform',
      'created_by',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function users(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function user(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'histories', 'event_id', 'user_id');
    }

    public function ratings(): HasMany
    {
        return $this->hasMany(Rating::class);
    }
}
