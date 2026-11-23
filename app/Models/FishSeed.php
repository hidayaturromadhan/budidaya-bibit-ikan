<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class FishSeed extends Model {
    protected $fillable = ['name', 'description', 'image', 'category', 'is_active'];

    public function sizes(): HasMany {
        return $this->hasMany(FishSeedSize::class);
    }

    public function orderItems(): HasManyThrough {
        return $this->hasManyThrough(OrderItem::class, FishSeedSize::class);
    }

    public function getTotalSoldAttribute(): int {
        return (int) $this->orderItems()
            ->whereHas('order', function ($query) {
                $query->where('status', 'selesai');
            })
            ->sum('order_items.quantity');
    }
}
