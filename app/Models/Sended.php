<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sended extends Model
{
    use HasFactory;
    protected $table = 'sended';
    protected $fillable = ['user_id','email','is_done','created_at'];
   
    // disable timestamps
    public $timestamps = false;
}
