<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
class FishSeed extends Model {
    protected $fillable = ['name', 'description', 'image', 'category', 'is_active'];
    public function sizes(): HasMany {
        return $this->hasMany(FishSeedSize::class);
    }
}
