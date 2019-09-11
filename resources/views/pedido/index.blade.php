@extends('layouts.app', ['pageName' => 'Pedidos'])
@section('content')
<div class="col-12">
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
    <a href="{{route('pedido.create')}}" class="btn btn-primary btn-icon-split float-right mb-3">
    <span class="icon text-white-50">
        <i class="fas fa-box-open"></i>
    </span>
    <span class="text">Adicionar Pedido</span>
    </a>
    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
            <tr  class="text-center">
            <th>#</th>
            <th>Cliente</th>
            <th>Total</th>
            <th>Opções</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pedidos as $a)
                <tr class="text-center">
                    <td>{{$a->id}}</td>
                    <td>{{$a->nome_cliente}}</td>
                    <td>{{$a->total}}</td>
                    <td>
                        <a href="{{route('pedido.show',$a->id)}}" target="_blank" class="btn btn-primary btn-icon-split">
                            <span class="icon text-white">
                                <i class="fas fa-eye"></i>
                            </span>
                        </a>

                        <!--<form method="POST" action="{{route('pedido.destroy',$a->id)}}" style="display: inline;" class="destroyProduto">
                            @method('DELETE')
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger">
                                <span class="icon text-white-50">
                                    <i class="fas fa-trash"></i>
                                </span>
                            </button>
                        </form>-->
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@section('script')

    <script>
        
        $(".destroyProduto").submit(function(event){
            event.preventDefault;
            if(confirm("Deseja realmente remover este produto?")){
                $(this).unbind('submit').submit();
            }
        });
    </script>
@endsection
@endsection