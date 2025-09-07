<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    use HasFactory;
    protected $fillable = ['uuid', 'name', 'email'];

    public function emails()
    {
        return $this->hasMany(Email::class);
    }
    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
    public function timelines()
    {
        return $this->hasMany(Timeline::class);
    }
    public function notes()
    {
        return $this->hasMany(Note::class);
    }
}
