<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Produto;
class ItensPedido extends Model
{
    protected $fillable = ['id','preco','produto_id','quantidade','pedido_id','created_at','updated_at'];

    function getImagem(){
        return Produto::find(($this->produto_id))->imagem;
    }

    function getNome(){
        return Produto::find(($this->produto_id))->nome;
    }
}
