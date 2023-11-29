<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    
    protected $fillable =[
        'category_name',
        'user_id',
        'image'
    ];
    protected $casts = [
        'image' => 'string', // Make sure the image attribute is cast to the appropriate type
    ];

    public function user(){
        return this->hasOne(user::class,'id', 'user_id');
    }
}
