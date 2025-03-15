<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use Translatable;
    use HasFactory;

    public $fillable = ['email','email_verified_at','password','phone','price','name','appointments','section_id'];
    public $translatedAttributes = ['name', 'appointments'];

    /**
     * Get the Doctor's image.
     */
    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

}
