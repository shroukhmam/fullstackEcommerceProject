<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Blogger extends Model
{
    //
    protected $table='bloggers';
    protected $fillable=[
        'name',
        'image',
        'pharagraph',
        
    ];
}
