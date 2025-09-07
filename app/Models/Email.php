<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    use HasFactory;
    protected $fillable = [
        'message_id', 'from_name', 'from_email', 'subject', 'body', 'headers', 'lead_id'
    ];
    protected $casts = [
        'headers' => 'array',
    ];
    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }
    public function ticket()
    {
        return $this->hasOne(Ticket::class);
    }
}
