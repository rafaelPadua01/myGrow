<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlbumImage extends Model
{
    use HasFactory;
    protected $fillable = ['image_name', 'image_size', 'image_extension', 'id_user', 'id_album'];
}
