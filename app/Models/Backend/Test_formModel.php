<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Test_formModel extends Model
{
    use HasFactory;
    protected $table = 'tb_test_form';
    protected $primaryKey = 'id';
    protected $fillable = ['image','name','detail'
    ,'sort','status','created','updated','deleted'];
    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';
    public $timestamp = false;
}
