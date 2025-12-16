<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataVoters extends Model
{
    protected $fillable = ['voter_palsu'];
    public function ratingBuku(){
        return $this->belongsTo(RatingUser::class, 'voters_id', 'id');
    }
}
