<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class telefonos extends Model
{
    use HasFactory;
    protected $table = 'telefonos';
    protected $primaryKey = 'idTelefono';

    protected $fillable = [
        'idContactoFk',
        'telefono',
    ];

    public function contacto()
    {
        return $this->belongsTo(contactos::class, 'idContactoFk', 'idContacto');
    }
}
