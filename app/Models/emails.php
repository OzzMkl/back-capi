<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class emails extends Model
{
    use HasFactory;
    protected $table = 'emails';
    protected $primaryKey = 'idEmail';

    protected $fillable = [
        'idContactoFk',
        'email',
    ];

    public function contacto()
    {
        return $this->belongsTo(contactos::class, 'idContactoFk', 'idContacto');
    }
}
