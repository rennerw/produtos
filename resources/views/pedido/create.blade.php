@extends('layouts.app', ['pageName' => ''])
@section('content')

<style>
#myTable_filter label, input.great{
    height: 60px !important;
    text-align: center;
    font-size: 35px;
    width: 100% !important;
}

.dataTables_wrapper .dataTables_length {
    float: left;
    display: none;
}
.dataTables_wrapper .dataTables_paginate {
    float: right;
    text-align: right;
    padding-top: 0.25em;
    display:none;
}

#myTable_info{
    display: none;
}

table.dataTable tbody tr.selected{
    background-color: #ccc !important;
}

#myTable tbody tr:hover,#tabelaClientes tbody tr:hover{
    cursor:pointer;
    background-color: #ccc;
}

#sPreco,#sProduto{
    font-weight: 300;
}

#buscarComanda{
    position: fixed;
    bottom: 0px;
    right: 0;
    height: 70px;
    width: 70px;
    border-radius: 50%;
    z-index: 999;
    -webkit-box-shadow: 10px 10px 20px 0px rgba(0,0,0,0.75);
    -moz-box-shadow: 10px 10px 20px 0px rgba(0,0,0,0.75);
    box-shadow: 10px 10px 20px 0px rgba(0,0,0,0.75);
}
.loading{
    position:   fixed;
    z-index:    1000;
    top:        0;
    left:       0;
    height:     100%;
    width:      100%;
    background: rgba( 255, 255, 255, .8 ) 
                url('/img/loading.gif') 
                50% 50% 
                no-repeat;
}
</style>
<div class="container">
    <div class="loading" style="display: none;"></div>
    <h1 class="text-center">Pedidos</h1>
    <div class="row">           
        <div class="col-12">
            <table class="table" id="myTable">
                <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Preço</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($produtos as $p)
                    <tr>
                        <th class="id" data-img="{{$p->imagem}}">{{$p->id}}</th>
                        <td class="produto">{{$p->descricao}}</td>
                        <td class="preco" data-preco="{{$p->preco}}">R$ {{$p->preco}}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot></tfoot>
            </table>
            <br>
        </div>
        <div class="col-12">
            <p class="float-right font-weight-bold d-inline">PRODUTO: <span id="sProduto">---</span>
                <br>  
                PREÇO R$: <span id="sPreco">---</span>
                <br>
                Quantidade: <input type="number" id="sQuantidade" value="1" onclick="$(this).select()"><br>
            </p>
            <img id="imgProduto" src="" style="display: none;" alt="Imagem Produto" class="float-left" width="90" height="90">   
        </div>   
    </div>
    <div class="row justify-content-end">
        <div class="col-12 col-lg-3">
            <input type="button" id="btnInserir" value="Inserir na lista" style="width: 100%;" class="btn btn-success">
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            
            <form method="POST" action="{{route('pedido.store')}}" id="formPedido">
            <div class="col-12">
                <div class="form-group">
                    <label for="cliente">Cliente *</label>
                    <select name="cliente_id" id="cliente" class="form-control form-control-lg" required>
                        @foreach ($cliente as $item)
                            <option value="{{$item->id}}">{{$item->nome}}</option>
                        @endforeach
                    </select>
                </div>    
            </div>  
            <h2>Itens deste pedido</h2>
            <table id="tabelaPedidos" class="table table-striped table-hover">
                <thead class="thead-dark">
                <tr>
                    <th>Nome</th>
                    <th>Quantidade</th>
                    
                </tr>
                </thead>
                <tbody>
                    
                </tbody>
            </table>
            
                {{csrf_field()}}
                 
                <button style="width: 100%" class="btn btn-success" id="finalizarPedido" type="button">Finalizar Pedido</button>
                <button style="width: 100%" class="btn bg-white mt-4 mb-4 border border-danger" id="apagarPedido">Apagar lista</button>
            </form>
            <br>
        </div>
    </div>
</div>
@section('script')
<script>
    $(document).ready(function(){
        var firstChild = true;

        tabelaProduto = $('#myTable').DataTable( {
            ordering: false,
            
            "language": {
                "sSearchPlaceholder": "Buscar produto",
                "emptyTable": "Sem dados disponíveis",
                "info": "Mostrando _START_ de _END_ de _TOTAL_ dados",
                "infoEmpty": "Mostrando 0 to 0 of 0 dados",
                "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Mostrar _MENU_ dados",
                "loadingRecords": "Carregando...",
                "processing": "Processando...",
                "search": "",
                "zeroRecords": "Nenhum resultado correspondente",
                "paginate": {
                    "first": "Primeiro",
                    "last": "Último",
                    "next": "Próximo",
                    "previous": "Anterior"
                },
            }
        });
        
        // Busca tabela Produto 
        
        
        /* Setas tabela */
        $(document).on("keyup",$("input[type='search']")[0],function(event){
            if (event.key == "ArrowDown"){
                if (! $("#myTable tbody tr:first-child").hasClass("selected") && firstChild == true){
                    $("#myTable tbody tr").removeClass("selected");
                    $("#myTable tbody tr:first-child").addClass("selected");
                    firstChild = false;
                }
                else{
                    _this = $("#myTable tbody tr.selected")[0];
                    _next = $($(_this.nextSibling));
                    
                    $($(_this.nextSibling).addClass("selected"));
                    $(_this).removeClass("selected");
                    if (_next.length > 0){
                        
                    }
                    else{
                        firstChild = false;
                        $("#myTable tbody tr").removeClass("selected");
                        $("#myTable tbody tr:first-child").addClass("selected");
                    }
                }
            }
            else if (event.key != "Enter" && event.key != "ArrowDown"){
                $("#myTable tbody tr").removeClass("selected");
                $("#myTable tbody tr:first-child").addClass("selected");
                firstChild = false;
            }

            if (event.key == "Enter"){
                $("#myTable tbody tr.selected").click();
            }
    
        });
        
        
        /* Buscar Cliente */
        
        let produtoSelecionado = null;
        let produtosPedidos = {};
        
        /* Buscar Comanda */
        
        $(document).on("click","#myTable tbody tr",function(key,value){
            $("#myTable tbody tr").removeClass("selected");
            $(this).addClass("selected");
            $("#sQuantidade").val("1");
            $("#sQuantidade").focus().select();
            
            if ($(this).attr("role") == "row"){
                produtoSelecionado = [];
                $(this).children().each(function(key,value) {
                    var $this = $(this).text();
                    if (key == 2) $this = $(this).data("preco");
                    produtoSelecionado.push($this);

                });

                $("#sProduto").text(produtoSelecionado[1]);
                $("#sPreco").text(Number(produtoSelecionado[2]).toFixed(2));
                if ($(this).find('.id').data('img')){
                    $("#imgProduto").show();
                    $("#imgProduto").attr("src","/storage/"+$(this).find('.id').data('img'));
                }
                else{
                    $("#imgProduto").hide();
                }
            }
            
        });
        
        /* Inserir Itens */
        
        $("#btnInserir").click(function(){
            if(verificarInputs() && produtoSelecionado != null){
                inserirItem();
                Swal.fire({
                    position: 'top-end',
                    type: 'success',
                    title: 'Produto adicionado',
                    toast: true,
                    showConfirmButton: false,
                    timer: 1500
                });
                setTimeout(function(){
                    produtoSelecionado = null;
                    $("#sProduto").text("---");
                    $("#sPreco").text("---");
                },50);
                $($("input[type=search]").get(0)).focus().select();
                
            }
        });

        function verificarInputs(){
            var comanda = $("#txtComanda").val();
            if(!$("#sQuantidade").val() > 0){
                $("#sQuantidade").focus();
                alert("Verifique a quantidade do produto");
                return false;
            }
            if(produtoSelecionado == null){
                alert("Selecione um produto");
                return false;
            }
            return true;
        }
        
        function inserirItem(){
            var quantidade = $("#sQuantidade").val();
            var id = produtoSelecionado[0];
            var nome = produtoSelecionado[1];
            
            if (produtosPedidos[id] != undefined){
                var elem = $("#tabelaPedidos tbody tr[data-id='"+ id +"']");
                var novo = $(elem).find(".quantidade").val();
    
                novo = parseFloat(novo) + parseFloat(quantidade);
                
                $(elem).find(".quantidade").val(parseFloat(novo));
                produtosPedidos[id].quantidade = parseFloat(novo);
            }
            else{
                var str = `<tr data-id="${id}">
                        <td>${nome}</td>
                        <td><input type="number" onclick="$(this).select()" class="quantidade mr-1" value="${quantidade}" required>
                        <button class="removeItem">Remover</button></td>
                        </tr>`;
                $("#tabelaPedidos").append($(str).hide().fadeIn(1100));
                //$(".quantidade").mask("#.00",{reverse: true,placeholder: "1.00"});

                produtosPedidos[id] = {
                    "quantidade": $("#sQuantidade").val(),
                    "observacao": " "
                }
            }

            
        }

        $(document).on("keyup","#sQuantidade",function(){
            if (event.key == "Enter"){
                $("#sQuantidade").prop("disabled",true);
                $("#btnInserir").click();
            }
        });
        
        $(document).on("keyup",$("input[type='search']")[0],function(){
            $("#sQuantidade").prop("disabled",false);
        });
        
        // tabela Pedidos
        $(document).on("blur",".quantidade",function(){
            id = $(this).parent().parent().data("id");
            produtosPedidos[id].quantidade = $(this).val();
            
        });
        
        $(document).on("click","#tabelaPedidos tbody button.removeItem",function(){
            if(confirm("Deseja remover este item da lista?")){
                var id = $(this).parent().parent().data("id");
                $(this).parent().parent().fadeOut(1100,function(){
                    $(this).remove();
                });
                delete produtosPedidos[id];
            }
        });
        
        $("#finalizarPedido").click(function(){
            prods = "";
            comanda = $("#txtComanda").val();
            Object.keys(produtosPedidos).forEach(function(key){
                _this = produtosPedidos[key];
                $("#formPedido").append(`<input name="item[${key}][id]" value="${key}" class="d-none">`);
                $("#formPedido").append(`<input name="item[${key}][quantidade]" value="${_this.quantidade}" class="d-none">`);
            });

            if (Object.keys(produtosPedidos).length > 0){
                var quantidade = Object.keys(produtosPedidos).length;
                var cont = 0;
                $("#tabelaPedidos .quantidade").each(function(){
                    if($(this).val() != ""){
                        cont++;
                    }
                })
                if (cont == quantidade){
                    $("#formPedido").unbind('submit').submit();
                }
                else{
                    alert("Insira a quantidade de todos os produtos");
                }
            }
            else{
                alert("Sem itens para inserir");
            }
        });

        $("#formPedido").submit(function(e){
            e.preventDefault();
        });

        
        $("#apagarPedido").click(function(){
            $("#formPedido").find('input.d-none').each(function(){
                $(this).remove();
            });
            $("#tabelaPedidos tbody tr").each(function(){
                id = $(this).data("id");
                delete produtosPedidos[id];
                $(this).fadeOut(1100,function(){
                    $(this).remove();
                });
            });
            tabelaProduto.search('').draw();
            $($("input[type=search]").get(0)).val("");
            $("#sProduto").text("---");
            $("#sPreco").text("---");
            $("#sQuantidade").val("1");
            $("#txtComanda").focus().select();
        });
    });
    
</script>
@endsection
@endsection
