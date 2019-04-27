<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class WxImageModel extends Model
{
    //
    protected $table="wx_image";
    public $timestamps = false;
    protected $primaryKey="i_id";
}
