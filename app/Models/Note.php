<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;
    protected $fillable = [
        'lead_id', 'ticket_id', 'note'
    ];
    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }
    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
}
