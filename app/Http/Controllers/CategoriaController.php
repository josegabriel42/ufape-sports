<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        //Bloqueia o acesso à usuários sem privilégio
        if(Auth::user()->email !='adm@adm')
            return redirect('/');
        
        return view('categoria.cadastro', ['categorias' => Categoria::all()]);
    }

    /**
     * Create a new categoria instance after a valid registration.
     *
     * @param   Request $request
     * @return \App\Models\Categoria
     */
    protected function store(Request $request)
    {
        //Bloqueia o acesso à usuários sem privilégio
        if(Auth::user()->email !='adm@adm')
            return redirect('/');

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

        return redirect('/cadastroCategoria')->with('mensagem_status', 'Categoria cadastrada');
    }

    /* Show the form for editing the specified resource.
    *
    * @param  \App\Models\Categoria  $categoria
    * @return \Illuminate\Http\Response
    */
   public function edit(Categoria $categoria)
   {
        //Bloqueia o acesso à usuários sem privilégio
        if(Auth::user()->email !='adm@adm')
            return redirect('/');

       return view('categoria.cadastro', [
            'categoria' => $categoria,
            'categorias' => Categoria::all()
        ]);
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //Bloqueia o acesso à usuários sem privilégio
        if(Auth::user()->email !='adm@adm')
            return redirect('/');
        
        $categoria = Categoria::find($request['categoria_id']);
        if($categoria->nome == $request['nome']) {
            $request['nome'] = 'nao avaliar';
        }else {
            $categoria['nome'] = $request['nome'];
        }

        $data = $request->all();
        $validator =  Validator::make($data, [
            'nome' => ['required', 'string', 'max:255', 'unique:categorias'],
            'descricao' => ['required', 'string', 'max:255'],
        ]);

        $categoria['descricao'] = $request['descricao'];

        if($validator->fails()) {
            $request['nome'] = $categoria['nome'];    
            return redirect('/atualizaCategoria/' . $categoria->id)->withErrors($validator)->withInput();
        }

        $request['nome'] = $categoria['nome'];
        $categoria->save();

        return redirect()->back()->with('mensagem_status', 'Dados atualizados');
    }
}
