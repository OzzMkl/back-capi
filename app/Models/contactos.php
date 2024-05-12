<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class contactos extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'contactos';
    protected $primaryKey = 'idContacto';
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'nombre',
        'apellido_paterno',
        'apellido_materno',
        'fecha_nacimiento',
    ];

    public function telefonos(){
        return $this->hasMany(telefonos::class,'idContactoFk','idContacto');
    }

    public function emails(){
        return $this->hasMany(emails::class,'idContactoFk','idContacto');
    }

    public function direcciones(){
        return $this->hasMany(direcciones::class,'idContactoFk','idContacto');
    }
}
