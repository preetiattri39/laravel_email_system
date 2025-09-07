<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timeline extends Model
{
    use HasFactory;
    protected $fillable = [
        'lead_id', 'type', 'message'
    ];
    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }
}
