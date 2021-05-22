<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    protected $fillable = [
        'vote_id', 'order', 'name', 'description', 'image','count'
    ];
    
    public function vote(){
        return $this->belongsTo(Vote::class);
    }

    public function getTakeImageAttribute(){
        return 'storage/' . $this->image;
    }
}