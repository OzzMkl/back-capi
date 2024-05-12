<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class direcciones extends Model
{
    use HasFactory;
    protected $table = 'direcciones';
    protected $primaryKey = 'idDireccion';

    protected $fillable = [
        'idContactoFk',
        'estado',
        'ciudad',
        'colonia',
        'calle',
        'numero',
        'codigo_postal',
    ];

    public function contacto()
    {
        return $this->belongsTo(contactos::class, 'idContactoFk', 'idContacto');
    }
}
