<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    protected $fillable = ['id','nome','descricao',
    'preco','imagem','vendendo','created_at','updated_at'];
}
