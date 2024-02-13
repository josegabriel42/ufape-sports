<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProdutoController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('produto.cadastro', ['categorias' => Categoria::all()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $validator =  Validator::make($data, [
            'nome' => ['required', 'string', 'max:255', 'unique:produtos'],
            'descricao' => ['required', 'string', 'max:255'],
            'marca' => ['required', 'string'],
            'cor' => ['required', 'string'],
            'preco' => ['required', 'numeric', 'min:0', 'regex:/^\d+(\.\d{1,2})?$/'],
            'peso' => ['required', 'numeric', 'min:1', 'regex:/^\d+(\.\d{1,2})?$/'],
            'estoque' => ['required', 'numeric', 'integer', 'min:0'],
            'categoria' => ['required', 'exists:categorias,id'],
        ]);

        if($validator->fails()) {
            // dd($validator);
            return redirect('/cadastroProduto')->withErrors($validator)->withInput();
        }


        Produto::create([
            'nome' => $data['nome'],
            'descricao' => $data['descricao'],
            'marca' => $data['marca'],
            'cor' => $data['cor'],
            'preco' => $data['preco'],
            'peso' => $data['peso'],
            'estoque' => $data['estoque'],
            'categoria_id' => $data['categoria'],
        ]);

        return redirect('/cadastroProduto');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Produto  $produto
     * @return \Illuminate\Http\Response
     */
    public function show(Produto $produto)
    {
        return $produto;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Produto  $produto
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
     * @param  \App\Models\Produto  $produto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Produto $produto)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Produto  $produto
     * @return \Illuminate\Http\Response
     */
    public function destroy(Produto $produto)
    {
        //
    }
}
