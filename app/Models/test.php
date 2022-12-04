<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class test extends Model
{
    use HasFactory;
    protected $table = 'test';
    // disable timestamps
    public $timestamps = false;
    protected $fillable = ['id','desc'];
}
