<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Category;
use App\Model\Image;
use App\Model\Review;
use App\Model\Color;
use App\Model\Size;
class Product extends Model
{
    //
    protected $table='products';
    protected $fillable=[
        'category_id',
        'name',
        'slug',
        'description',
        'status',
        'title',
        'metakeyword',
        'metadescription',
        'brand',
        'qty',
        'sellingPrice',
        'originalPrice',
        'image',
        'feature',
        'popular',
    ];

 protected $with=['category','image','review','color','size'];
    public function category(){
        return $this->belongsTo(Category::class,'category_id');
    }
    public function image(){
        return $this->hasMany(Image::class,'product_id');
    }
    public function review(){
        return $this->hasMany(Review::class,'product_id');
    }
    public function color(){
        return $this->hasMany(Color::class,'product_id');
    }
    public function size(){
        return $this->hasMany(Size::class,'product_id');
    }
}
