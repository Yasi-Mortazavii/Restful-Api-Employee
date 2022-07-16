<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $fillable = [
        'name',
        'comment',
        'state',
        'time',
    ];

    public function user(){

        return $this->belongsTo(User::class);
    }
 
}
