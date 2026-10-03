<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'instructor_id', 'code', 'title', 'description',
        'units', 'is_active', 'image_path',
    ];

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }

    public function instructor()
    {
        return $this->belongsTo(Instructor::class);
    }
}
