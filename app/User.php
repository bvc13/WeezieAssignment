<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $fillable=[
        'name',
        'date_of_birth',
        'email',
        'country',
        'phone_number',
    ];

    protected $hidden=[
        'pivot'
    ];
}
