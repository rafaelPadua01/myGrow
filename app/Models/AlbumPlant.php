<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlbumPlant extends Model
{
    use HasFactory;
    protected $fillable = ['name_album', 'id_plant', 'id_user'];
}
