@extends('layouts.app', ['pageName' => 'Itens do pedido'])
@section('content')
<style>
    hr{
        border: 2px solid #2E55C7;
    }
</style>
<div class="col-12">
    @if (session('message'))
    <div class="alert alert-{{session('message')['type']}} alert-dismissible fade show" role="alert">
        <strong>{{session('message')['message']}}</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif
    <div class="col-12" style="min-height: 350px;">
    @foreach ($itens as $item)
       
        <p class="float-right font-weight-bold d-inline mr-5">PRODUTO: {{$item->nome}}
            <br>  
            PREÇO R$: {{$item->preco}}
            <br>
            Quantidade: {{$item->quantidade}}<br>
        </p>
        @if(isset($item->imagem))
        <img class="imgProduto" src="{{Storage::url($item->imagem)}}" alt="Imagem Produto" class="float-left" width="90" height="90">   
        <hr>
        @endif
    @endforeach
    </div> 
    <p class="text-right font-weight-bold mr-5" style="color: black; font-weight:800; font-size: 2em;">
        <br>  
        Total: R$ {{$pedido->total}}
        <br>
    </p>
    <div class="text-center clear">
        <a href="{{route('pedido.index')}}" class="btn btn-secondary pl-4 pr-4">Voltar</a>    
    </div>
</div>

@section('script')

    <script>
        
    </script>
@endsection
@endsection