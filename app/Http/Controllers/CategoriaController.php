<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoriaController extends Controller
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
     * Create a new categoria instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\Categoria
     */
    protected function create()
    {
        return view('categoria.cadastro');
    }

    /**
     * Create a new categoria instance after a valid registration.
     *
     * @param   Request $request
     * @return \App\Models\Categoria
     */
    protected function store(Request $request)
    {
        $data = $request->all();
        $validator =  Validator::make($data, [
            'nome' => ['required', 'string', 'max:255', 'unique:categorias'],
            'descricao' => ['required', 'string', 'max:255'],
        ]);

        if($validator->fails()) {
            return redirect('/cadastroCategoria')->withErrors($validator)->withInput();
        }

        Categoria::create([
            'nome' => $data['nome'],
            'descricao' => $data['descricao'],
        ]);

        return redirect('/cadastroCategoria');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function show(Categoria $categoria)
    {
        return $categoria;
    }
}
