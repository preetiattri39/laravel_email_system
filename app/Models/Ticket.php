<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;
    protected $fillable = [
        'lead_id', 'email_id', 'zoho_ticket_id', 'priority'
    ];
    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }
    public function email()
    {
        return $this->belongsTo(Email::class);
    }
    public function notes()
    {
        return $this->hasMany(Note::class);
    }
}
