<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $fillable = ['id','cliente_id','created_at','updated_at'];

    public function itens()
    {
        return $this->hasMany('App\ItensPedido');
    }

    public function cliente()
    {
        return $this->hasOne('App\Cliente','id','cliente_id');
    }
}
