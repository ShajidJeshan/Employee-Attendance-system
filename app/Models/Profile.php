<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    // use HasFactory;

    protected $guarded = [];

    public function profileImage()
    {
    	$imagePath = ($this->image) ? $this->image : 'profile/xYbvaRR7aKDweeA4zrbaQhwFAzXnFIwfCfP4MP6o.png';
    	return '/storage/' . $imagePath;
    }
}



