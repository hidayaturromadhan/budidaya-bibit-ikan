<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
class FishSeedSize extends Model {
    protected $fillable = ['fish_seed_id', 'size_label', 'price'];
    public function fishSeed(): BelongsTo {
        return $this->belongsTo(FishSeed::class);
    }
    public function stock(): HasOne {
        return $this->hasOne(Stock::class);
    }
}
