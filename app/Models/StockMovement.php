<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class StockMovement extends Model {
    protected $fillable = ['fish_seed_size_id', 'type', 'quantity', 'note'];
    public function fishSeedSize(): BelongsTo {
        return $this->belongsTo(FishSeedSize::class);
    }
}
