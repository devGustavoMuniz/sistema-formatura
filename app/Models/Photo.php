<?php

namespace App\Models;

use App\Interfaces\iSubject;
use App\Traits\Subjectable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Photo extends Model implements iSubject
{
    use HasFactory, Subjectable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'student_id',
        'path',
        'filesize',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'filesize' => 'integer',
        ];
    }

    /**
     * Get the student that owns the photo.
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }
}
