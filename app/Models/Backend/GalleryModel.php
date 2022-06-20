<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GalleryModel extends Model
{
    use HasFactory;
    protected $table = 'tb_gallery';
    protected $primaryKey = 'id';
    protected $fillable = ['_id','type','image','image_real_name'
    ,'created','updated'];
    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';
    public $timestamp = false;
}
