<?php

namespace App\Http\Controllers;

use Validator;
use App\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dados = Cliente::all();
        return view('cliente.index')->with('clientes',$dados);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cliente.create');
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
            'cpf' => 'required|unique:clientes|regex:/\d{3}\.\d{3}\.\d{3}\-\d{2}/m',
            'email' => 'required|unique:clientes|email'
        ],[ // messages
            'nome.required' => 'O campo Nome é obrigatório',
            'nome.min' => 'O campo Nome deve ter no mínimo 3 caracteres',
            'cpf.required' => 'O campo CPF é obrigatório',
            'cpf.unique' => 'Esse CPF já existe',
            'cpf.regex' => 'O CPF deve estar no formato DDD.DDD.DDD-DD',
            'email.required' => 'O campo Email é obrigatório',
            'email.unique' => 'O campo Email já existe',
            'email.email' => 'Insira um email válido'
        ]);

        if ($validator->fails()) {
            return redirect('/cliente/create')
                        ->withErrors($validator)
                        ->withInput();
        }
        $message;
        try{
            if (Cliente::create($request->all())){
                $message = ['type' => 'success', 'message' => 'Cliente adicionado'];
            }
            
        }
        catch(\Illuminate\Database\QueryException $ex){
            $message = ['type' => 'danger', 'message' => 'Ocorreu um erro e não foi possível adicionar o cliente'];
        }
        return redirect('cliente/')->withMessage($message);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function show(Cliente $cliente)
    {
        return view('cliente.update',compact('cliente'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function edit(Cliente $cliente)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cliente $cliente)
    {
        $validator = Validator::make($request->all(),[
            'nome' => 'required|min:3',
            'cpf' => 'sometimes|required|unique:clientes,cpf,'.$cliente->id.'|regex:/\d{3}\.\d{3}\.\d{3}\-\d{2}/m',
            'email' => 'sometimes|required|unique:clientes,email,'.$cliente->id.'|email'
        ],[ // messages
            'nome.required' => 'O campo Nome é obrigatório',
            'nome.min' => 'O campo Nome deve ter no mínimo 3 caracteres',
            'cpf.required' => 'O campo CPF é obrigatório',
            'cpf.unique' => 'Esse CPF já existe',
            'cpf.regex' => 'O CPF deve estar no formato DDD.DDD.DDD-DD',
            'email.required' => 'O campo Email é obrigatório',
            'email.unique' => 'O campo Email já existe',
            'email.email' => 'Insira um email válido'
        ]);

        if ($validator->fails()) {
            return redirect('/cliente/create')
                        ->withErrors($validator)
                        ->withInput();
        }
        $message;
        try{
            $cliente->update($request->all());
            $message = ['type' => 'success', 'message' => 'Cliente atualizado'];
            
            
        }
        catch(\Illuminate\Database\QueryException $ex){
            $message = ['type' => 'danger', 'message' => 'Ocorreu um erro e não foi possível realizar a ação'];
        }
        return redirect('cliente/')->withMessage($message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cliente $cliente)
    {
        $message;
        try{
            if ($cliente->delete()){
                $message = ['type' => 'success', 'message' => 'Cliente excluído!'];
            }
        }
        catch(\Illuminate\Database\QueryException $ex){
            $message = ['type' => 'danger', 'message' => 'Ocorreu um erro e não foi possível realizar a ação'];
        }
        return redirect('cliente/')->withMessage($message);
    }
}
