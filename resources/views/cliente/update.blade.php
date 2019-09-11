@extends('layouts.app', ['pageName' => 'Clientes'])

@section('content')

<div class="col-12">
    <form method="POST" action="{{route('cliente.update',$cliente->id)}}" class="m-form">
        @method('PUT')
        {{csrf_field()}}
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <div class="form-group">
            <label for="nome">Nome *</label>
            <input name="nome" id="nome" class="form-control form-control-lg" type="text" required value="{{isset($cliente->nome) ? $cliente->nome : old('nome')}}">
        </div>

        <div class="form-group">
            <label for="apelido">Apelido</label>
            <input name="apelido" id="apelido" class="form-control form-control-lg" type="text" value="{{isset($cliente->apelido) ? $cliente->apelido : old('apelido')}}">
        </div>

        <div class="form-group">
            <label for="endereco">Endereço</label>
            <input name="endereco" id="endereco" class="form-control form-control-lg" type="text" value="{{isset($cliente->endereco) ? $cliente->endereco : old('endereco')}}">
        </div>

        <div class="form-group">
            <label for="cpf">CPF *</label>
        <input name="cpf" id="cpf" class="form-control form-control-lg" type="text" required value="{{isset($cliente->cpf) ? $cliente->cpf : old('cpf')}}">
        </div>

        <div class="form-group">
            <label for="email">Email *</label>
            <input name="email" id="email" class="form-control form-control-lg" type="email" required value="{{isset($cliente->email) ? $cliente->email : old('email')}}">
        </div>

        <div class="form-group">
            <label for="telefone">Telefone</label>
            <input name="telefone" id="telefone" class="form-control form-control-lg" type="text" value="{{isset($cliente->telefone) ? $cliente->telefone : old('telefone')}}">
        </div>
        <h3 class="text-info">* Campos obrigatórios</h3>
        <div class="text-center">
            <button type="submit" class="btn btn-primary mr-2">Atualizar</button>
            <a href="{{route('cliente.index')}}" class="btn btn-secondary">Voltar</a>
        </div>
        
    </form>
</div>
@section('script')
    <script>
        $('#cpf').mask('000.000.000-00', {reverse: true, placeholder: "___.___.___-__"});
    </script>
@endsection
@endsection
