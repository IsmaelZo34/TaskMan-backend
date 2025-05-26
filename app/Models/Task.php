<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    protected $fillable = [
        'titre',
        'description',
        'importance',
        'accomplie',
        'echeance_date',
        'user_id'
    ];
    public function users(){
        return $this->belongTo(User::class);
    }
}
