@extends('layouts.app', ['pageName' => 'Clientes'])

@section('content')

<div class="col-12">
    <form method="POST" action="{{route('produto.update',$produto->id)}}" enctype="multipart/form-data">
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
            <input name="nome" id="nome" class="form-control form-control-lg" type="text" required value="{{isset($produto->nome) ? $produto->nome : old('nome')}}">
        </div>

        <div class="form-group">
            <label for="descricao">Descricao</label>
            <input name="descricao" id="descricao" class="form-control form-control-lg" type="text" value="{{isset($produto->descricao) ? $produto->descricao : old('descricao')}}">
        </div>

        <div class="form-group">
            <label for="preco">Preço *</label>
            <input name="preco" id="preco" class="form-control form-control-lg" type="text" value="{{isset($produto->preco) ? $produto->preco : old('preco')}}" required>
        </div>

        <div class="form-group">
            <label for="vendendo">Colocar à venda *</label>
            <select name="vendendo" id="vendendo" class="form-control form-control-lg" required>
                <option value="1" {{ ($produto->vendendo == 1)? "selected" : '' }} >Sim</option>
                <option value="0" {{ ($produto->vendendo == 0)? "selected" : '' }} >Não</option>
            </select>
        </div>

        <div class="form-group">
            <label for="imagem">Imagem</label>
            <input name="imagem" id="imagem" class="form-control form-control-lg" type="file">
            <div id="previaImagem">
                @if (isset($produto->imagem))
                    <img alt="imagem do produto" src="{{Storage::url($produto->imagem)}}"\>
                @endif
            </div>
        </div>

        <h4 class="text-info">* Campos obrigatórios</h4>

        <div class="text-center">
            <button type="submit" class="btn btn-primary mr-2">Enviar</button>
            <a href="{{route('produto.index')}}" class="btn btn-secondary">Voltar</a>
        </div>
        
    </form>
</div>
@section('script')
    <script>
        $('#preco').mask("#.##0.00", {reverse: true});
        
        $("#imagem").change(function(e){
            if($("#previaImagem img")){
                $("#previaImagem").children().remove();
            }
            if (this.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#previaImagem').append("<img src='' width='auto' height='auto' alt='Imagem do produto'\>");
                    $("#previaImagem img").attr('src',e.target.result);
                }
                reader.readAsDataURL(this.files[0]);
            }

});
    </script>
@endsection
@endsection
