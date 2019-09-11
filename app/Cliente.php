<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $fillable = ['id','nome','apelido','endereco','cpf','email','telefone','created_at','updated_at'];
}
