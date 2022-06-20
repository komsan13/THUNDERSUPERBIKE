<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TranslateModel extends Model
{
    use HasFactory;
    protected $table = 'tb_translate';
    protected $primaryKey = 'id';
    protected $fillable = ['comment','name_th','name_en','sort','status','delete_status','created','updated','deleted'];
    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';
    public $timestamp = false;
}
