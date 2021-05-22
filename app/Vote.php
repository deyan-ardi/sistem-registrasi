<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    protected $fillable = [
        'name', 'deskripsi', 'start', 'end', 'status'
    ];
    
    public function user(){
        return $this->hasMany(User::class);
    }
    
    public function candidate(){
        return $this->hasMany(Candidate::class);
    }

    public function detail(){
        return $this->hasMany(Detail::class);
    }
}