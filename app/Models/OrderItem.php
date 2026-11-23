<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class OrderItem extends Model {
    protected $fillable = ['order_id', 'fish_seed_size_id', 'quantity', 'price'];
    public function order(): BelongsTo {
        return $this->belongsTo(Order::class);
    }
    public function fishSeedSize(): BelongsTo {
        return $this->belongsTo(FishSeedSize::class);
    }
}
