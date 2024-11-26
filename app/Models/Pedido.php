<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $fillable = ['usuario_id','total','fecha_pedido'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function productos(){
        return $this->belongsTo(Producto::class, 'detalle_pedido')
                    ->withPivot('cantidad','precio')
                    ->withTimestamps();
    }
}
