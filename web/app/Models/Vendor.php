<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Vendor extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'created_at',
        'updated_at'
    ];

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function delays(): HasManyThrough
    {
        return $this->hasManyThrough(DelayReport::class,Order::class)
            ->where('delay_reports.created_at','>',Carbon::now()->subDays(7));
    }
}
