<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['type_email', 'name_system', 'name_comunity', 'image_dashboard', 'image_login', 'image_sidebar'];


}