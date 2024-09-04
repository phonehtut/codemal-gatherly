<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';

    protected $fillable = [
      'name',
    ];

    public function events()
{
    // Each category has many events
    return $this->hasMany(Event::class, 'category_id', 'id');
}

// public function events() {
//   return $this->hasMany(Event::class);
// }


}
