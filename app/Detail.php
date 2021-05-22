<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Detail extends Model
{
    protected $fillable = [
        'ip_address', 'user_id', 'vote_id', 'candidate_id'
    ];
    
    public function vote(){
        return $this->belongsTo(Vote::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
    
}