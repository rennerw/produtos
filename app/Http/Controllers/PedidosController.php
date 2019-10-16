<?php

namespace App\Http\Controllers;

use Validator;
use App\Cliente;
use App\Pedido;
use App\Produto;
use App\ItensPedido;
use Illuminate\Http\Request;

class PedidosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pedidos = Pedido::all();
        foreach ($pedidos as $key => $value) {
            $total = 0;
            
            foreach($pedidos[$key]->itens as $k => $val){
                $total = $val->preco * $val->quantidade + $total;
            }
            $pedidos[$key]->total = $total;
            $pedidos[$key]->nome_cliente = $pedidos[$key]->cliente->nome;
        }
        return view('pedido.index')->withPedidos($pedidos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $produtos = Produto::all()->where('vendendo',1);
        $cliente = Cliente::all();
        return view('pedido.create', compact('produtos','cliente'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'item.*.id' => 'required|exists:produtos,id',
            'item.*.quantidade' => 'required|integer|min:1',
            'cliente_id' => 'required','exists:clientes,id'
        ],[ // messages
            'item.*.quantidade.required' => 'Você inseriu algum item sem quantidade',
            'item.*.quantidade.integer' => 'O campo quantidade deve ser inteiro',
            'item.*.id.exists' => 'Você inseriu um item que não existe',
            'cliente_id.required' => 'Selecione um cliente',
            'cliente_id.exists' => 'Você inseriu um cliente que não existe',
        ]);

        if ($validator->fails()) {
            return redirect('/pedido')
                        ->withErrors($validator)
                        ->withInput();
        }
        $message;
        $pedido = [];
        try{
            $pedido['cliente_id'] = $request->cliente_id;
            $pedido = Pedido::create($pedido);
            $itens = $request->item;
            
            foreach ($itens as $key => $value) {
                $i = new ItensPedido;
                $i->pedido_id = $pedido->id;
                $i->preco = Produto::find($value['id'])->preco;
                $i->quantidade = $value['quantidade'];
                $i->produto_id = Produto::find($value['id'])->id;

                $i->save();
            }
            $message = ['type' => 'success', 'message' => 'Pedido realizado com sucesso'];
            
        }
        catch(\Illuminate\Database\QueryException $ex){
            Pedido::find($pedido->id)->delete();
            $message = ['type' => 'danger', 'message' => 'Ocorreu um erro e não foi possível adicionar o pedido'];
        }
        return redirect('pedido/')->withMessage($message);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Pedido  $pedido
     * @return \Illuminate\Http\Response
     */
    public function show(Pedido $pedido)
    {
        $itens = $pedido->itens;
        $total = 0;
        foreach($itens as $key => $item){
            $total = $item->preco * $item->quantidade + $total;
            $itens[$key]->imagem = $item->getImagem();
            $itens[$key]->nome = $item->getNome();
        }
        $pedido->total = $total;
        
        return view("pedido.show",compact('pedido','itens'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Pedido  $pedido
     * @return \Illuminate\Http\Response
     */
    public function edit(Pedido $pedido)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Pedido  $pedido
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pedido $pedido)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Pedido  $pedido
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pedido $pedido)
    {
        //
    }
}
