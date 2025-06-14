<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'institute_id',
        'name',
        'ra',
    ];

    /**
     * Get the user that owns the student profile.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the institute that the student belongs to.
     */
    public function institute(): BelongsTo
    {
        return $this->belongsTo(Institute::class);
    }

    /**
     * Get the photos for the student.
     */
    public function photos(): HasMany
    {
        return $this->hasMany(Photo::class);
    }
}
