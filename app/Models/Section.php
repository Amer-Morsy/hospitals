<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use Translatable;

    protected $fillable =['name'];

    public $translatedAttributes = ['name'];
}
