<?php

namespace App\Http\Controllers;
use Validator;
use App\Produto;
use Illuminate\Http\Request;

class ProdutosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dados = Produto::all();

        return view('produto.index')->with('produtos',$dados);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('produto.create');
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
            'nome' => 'required|min:3',
            'preco' => 'required|regex:/^[0-9]+(\.[0-9]{1,2})?$/',
            'vendendo' => 'required|bool',
            'imagem' => 'mimes:jpeg,jpg,png'
        ],[ // messages
            'nome.required' => 'O campo Nome é obrigatório',
            'nome.min' => 'O campo Nome deve ter no mínimo 3 caracteres',
            'preco.required' => 'O campo Preço é obrigatório',
            'preco.regex' => 'O Preço deve estar no formato NN.NN',
            'vendendo.required' => 'O campo Vendendo é obrigatório',
            'vendendo.bool' => 'O campo Vendendo não foi preenchido corretamente',
            'imagem.mimes' => 'Imagem deve ser jpg ou png'
        ]);

        if ($validator->fails()) {
            return redirect('/produto/create')
                        ->withErrors($validator)
                        ->withInput();
        }
        $message;
        try{
            $produto = new Produto;
            $produto->fill($request->all());
            if ($request->hasFile('imagem')){
                $produto->imagem = $request->imagem->store('produtos', 'public');

            }
            if ($produto->save()){
                $message = ['type' => 'success', 'message' => 'Produto adicionado'];
            }
            
        }
        catch(\Illuminate\Database\QueryException $ex){
            $message = ['type' => 'danger', 'message' => 'Ocorreu um erro e não foi possível adicionar o produto'];
        }
        return redirect('produto/')->withMessage($message);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Produto  $produto
     * @return \Illuminate\Http\Response
     */
    public function show(Produto $produto)
    {
        return view('produto.update',compact('produto'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Produto  $produto
     * @return \Illuminate\Http\Response
     */
    public function edit(Produto $produto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Produto  $produto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Produto $produto)
    {
        $validator = Validator::make($request->all(),[
            'nome' => 'required|min:3',
            'preco' => 'required|regex:/^[0-9]+(\.[0-9]{1,2})?$/',
            'vendendo' => 'required|bool',
            'imagem' => 'mimes:jpeg,jpg,png'
        ],[ // messages
            'nome.required' => 'O campo Nome é obrigatório',
            'nome.min' => 'O campo Nome deve ter no mínimo 3 caracteres',
            'preco.required' => 'O campo Preço é obrigatório',
            'preco.regex' => 'O Preço deve estar no formato NN.NN',
            'vendendo.required' => 'O campo Vendendo é obrigatório',
            'vendendo.bool' => 'O campo Vendendo não foi preenchido corretamente',
            'imagem.mimes' => 'Imagem deve ser jpg ou png'
        ]);

        if ($validator->fails()) {
            return redirect('/produto/create')
                        ->withErrors($validator)
                        ->withInput();
        }
        else{
            $produto->nome = $request->nome;
            $produto->descricao = $request->descricao;
            $produto->preco = $request->preco;
            $produto->vendendo = $request->vendendo;
        }
        $message;
        try{
            if ($request->hasFile('imagem')){
                $produto->imagem = $request->imagem->store('produtos', 'public');

            }
            if ($produto->update()){
                $message = ['type' => 'success', 'message' => 'Produto atualizado'];
            }
            
        }
        catch(\Illuminate\Database\QueryException $ex){
            $message = ['type' => 'danger', 'message' => 'Ocorreu um erro e não foi possível adicionar o produto'];
        }
        return redirect('produto/')->withMessage($message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Produto  $produto
     * @return \Illuminate\Http\Response
     */
    public function destroy(Produto $produto)
    {
        $message;
        try{
            if ($produto->delete()){
                $message = ['type' => 'success', 'message' => 'Produto excluído!'];
            }
        }
        catch(\Illuminate\Database\QueryException $ex){
            $message = ['type' => 'danger', 'message' => 'Ocorreu um erro e não foi possível realizar a ação'];
        }
        return redirect('produto/')->withMessage($message);
    }
}
