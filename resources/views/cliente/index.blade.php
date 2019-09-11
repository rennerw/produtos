@extends('layouts.app', ['pageName' => 'Clientes'])

@section('content')

<div class="col-12">
    @if (session('message'))
    <div class="alert alert-{{session('message')['type']}} alert-dismissible fade show" role="alert">
        <strong>{{session('message')['message']}}</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    
    @endif
    <a href="{{route('cliente.create')}}" class="btn btn-primary btn-icon-split float-right mb-5">
    <span class="icon text-white-50">
        <i class="fas fa-user-plus"></i>
    </span>
    <span class="text">Adicionar Cliente</span>
    </a>
    <br><br>
    <table class="table table-bordered clearfix" id="tabelaCliente" width="100%" cellspacing="0">
        <thead>
            <tr  class="text-center">
            <th>Nome</th>
            <th>Apelido</th>
            <th>CPF</th>
            <th>Opções</th>
            </tr>
        </thead>
        <tbody>
            @foreach($clientes as $c)
                <tr class="text-center">
                    <td>{{$c->nome}}</td>
                    <td>{{$c->apelido}}</td>
                    <td>{{$c->cpf}}</td>
                    <td>
                        <a href="{{route('cliente.show',$c->id)}}" target="_blank" class="btn btn-primary btn-icon-split">
                            <span class="icon text-white">
                                <i class="fas fa-eye"></i>
                            </span>
                        </a>

                        <form method="POST" action="{{route('cliente.destroy',$c->id)}}" style="display: inline;" class="destroyCliente">
                            @method('DELETE')
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger">
                                <span class="icon text-white-50">
                                    <i class="fas fa-trash"></i>
                                </span>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@section('script')

    <script>
        $(document).ready(function(){
            $("#tabelaCliente").DataTable({
                "language": {
                    "sSearchPlaceholder": "Buscar cliente",
                    "emptyTable": "Sem dados disponíveis",
                    "info": "Mostrando _START_ de _END_ de _TOTAL_ dados",
                    "infoEmpty": "Mostrando 0 to 0 of 0 dados",
                    "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                    "infoPostFix": "",
                    "thousands": ",",
                    "lengthMenu": "Mostrar _MENU_ dados",
                    "loadingRecords": "Carregando...",
                    "processing": "Processando...",
                    "search": "Buscar:",
                    "zeroRecords": "Nenhum resultado correspondente",
                    "paginate": {
                        "first": "Primeiro",
                        "last": "Último",
                        "next": "Próximo",
                        "previous": "Anterior"
                    },
                }
            });
        });

        $(".destroyCliente").submit(function(event){
            event.preventDefault;
            if(confirm("Deseja realmente remover este cliente?")){
                $(this).unbind('submit').submit();
            }
        });
    </script>
@endsection
@endsection