<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class typeModel extends Model
{
    use HasFactory;
    protected $table = 'tb_type';
    protected $primaryKey = 'id';
    protected $fillable = ['name','status','created','updated'];
    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';
    public $timestamp = false;
}
