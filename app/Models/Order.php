<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
class Order extends Model {
    protected $fillable = ['user_id', 'status', 'total_amount', 'shipping_address_id', 'expedition_name', 'tracking_number', 'shipping_cost', 'shipping_service'];
    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }
    public function items(): HasMany {
        return $this->hasMany(OrderItem::class);
    }
    public function payment(): HasOne {
        return $this->hasOne(Payment::class);
    }
    public function address(): BelongsTo {
        return $this->belongsTo(Address::class, 'shipping_address_id');
    }
}
