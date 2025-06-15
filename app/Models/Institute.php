<?php

namespace App\Models;

// 1. Adicione as importações necessárias
use App\Interfaces\iSubject;
use App\Traits\Subjectable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

// 2. Implemente a interface iSubject
class Institute extends Model implements iSubject
{
    // 3. Utilize os traits HasFactory e o Subjectable
    use HasFactory, Subjectable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'cnpj',
        'address',
    ];

    /**
     * Get the students for the institute.
     */
    public function students(): HasMany
    {
        return $this->hasMany(Student::class);
    }

    /**
     * Scope a query to only include institutes of a given search.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  array  $filters
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilter(Builder $query, array $filters): Builder
    {
        return $query->when($filters['search'] ?? null, function (Builder $query, string $search) {
            $query->where(function (Builder $query) use ($search) {
                $query->where('name', 'like', '%'.$search.'%')
                    ->orWhere('cnpj', 'like', '%'.$search.'%');
            });
        });
    }
}