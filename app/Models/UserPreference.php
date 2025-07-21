<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPreference extends Model
{
    use HasFactory;

    /**
     * Los atributos que son asignables masivamente.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'notifications',
        'dark_mode',
    ];

    /**
     * Los atributos que deben ser convertidos a tipos nativos.
     *
     * @var array
     */
    protected $casts = [
        'notifications' => 'boolean',
        'dark_mode' => 'boolean',
    ];

    /**
     * Obtener el usuario al que pertenecen las preferencias.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
