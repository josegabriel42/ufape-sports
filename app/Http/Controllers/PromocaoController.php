<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Produto;
use App\Models\Promocao;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PromocaoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //Bloqueia o acesso à usuários sem privilégio
        if(Auth::user()->email !='adm@adm')
            return redirect('/');
        
        return view('promocao.cadastro', ['promocoes' => Promocao::all()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Bloqueia o acesso à usuários sem privilégio
        if(Auth::user()->email !='adm@adm')
            return redirect('/');

        $data = $request->all();
        $validator =  Validator::make($data, [
            'nome' => ['required', 'string', 'max:255', 'unique:promocoes'],
            'descricao' => ['required', 'string', 'max:255'],
            'data_inicio' => ['required', 'date', 'after_or_equal:today'],
            'data_fim' => ['required', 'date', 'after_or_equal:data_inicio'],
            'percentagem' => ['required', 'numeric', 'min:0', 'max:100', 'regex:/^\d+(\.\d{1,2})?$/'],
        ]);

        if($validator->fails()) {
            // dd($validator);
            return redirect('/cadastroPromocao')->withErrors($validator)->withInput();
        }

        Promocao::create([
            'nome' => $data['nome'],
            'descricao' => $data['descricao'],
            'data_inicio' => $data['data_inicio'],
            'data_fim' => $data['data_fim'],
            'percentagem' => $data['percentagem'],
        ]);

        return view('promocao.cadastro', ['promocoes' => Promocao::all()]);
    }

    /**
     * Prepara o array de dados que será usado na view 'produto.consultar'
     *
     * @param  \App\Models\Promocao  $promocao
     * @param integer $produto_id
     * @return array
     */
    private function getDadosParaTelaDeConsulta(Promocao $promocao)
    {
        $produtos_promocao = $promocao->produtos()->get();
        $produtos = Produto::all()->diff($produtos_promocao);

        $dados = [
            'promocao' => $promocao,
            'produtos_promocao' => $produtos_promocao,
            'produtos' => $produtos,
            'categorias' => Categoria::all(),
        ];

        return $dados;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Promocao  $promocao
     * @return \Illuminate\Http\Response
     */
    public function show(Promocao $promocao)
    {
        return view('produto.consultar', $this->getDadosParaTelaDeConsulta($promocao));
    }

    /**
     * Aplica ou remove uma promoção de um produto
     *
     * @param  \App\Models\Promocao  $promocao
     * @return \Illuminate\Http\Response
     */
    public function aplicarOuRemoverPromocao(Request $request)
    {
        //Bloqueia o acesso à usuários sem privilégio
        if(Auth::user()->email !='adm@adm')
            return redirect('/');

        $promocao = Promocao::find($request['promocao_id']);
        $promocao_aplicada = $promocao->produtos()->where('produto_id', $request['produto_id'])->get()->count();

        if($promocao_aplicada) {
            $promocao->produtos()->detach($request['produto_id']);
        }else {
            $promocao->produtos()->attach($request['produto_id']);
        }

        return view('produto.consultar', $this->getDadosParaTelaDeConsulta($promocao));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Promocao  $promocao
     * @return \Illuminate\Http\Response
     */
    public function edit(Promocao $promocao)
    {
        //Bloqueia o acesso à usuários sem privilégio
        if(Auth::user()->email !='adm@adm')
            return redirect('/');
        
        return view('promocao.cadastro', [
            'promocao' => $promocao,
            'promocoes' => Promocao::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Promocao  $promocao
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Promocao $promocao)
    {
        //Bloqueia o acesso à usuários sem privilégio
        if(Auth::user()->email !='adm@adm')
            return redirect('/');

        //Evita que tente validar o nome caso não tenha mudado (necessário para evitar erro)
        $promocao = Promocao::find($request['promocao_id']);
        if($promocao->nome == $request['nome']) {
            $request['nome'] = 'nao avaliar';
        }else {
            $promocao['nome'] = $request['nome'];
        }

        //Evita que tente validar a data de início caso não tenha mudado (necessário para evitar erro)
        if($promocao->data_inicio == $request['data_inicio']) {
            $request['data_inicio'] = Carbon::today();

            if($promocao->data_fim == $request['data_fim'])
                $request['data_fim'] = Carbon::today();
            else
                $promocao['data_fim'] = $request['data_fim'];
        }else {
            $promocao['data_inicio'] = $request['data_inicio'];
            $promocao['data_fim'] = $request['data_fim'];
        }

        $data = $request->all();
        $validator =  Validator::make($data, [
            'nome' => ['required', 'string', 'max:255', 'unique:promocoes'],
            'descricao' => ['required', 'string', 'max:255'],
            'data_inicio' => ['required', 'date', 'after_or_equal:today'],
            'data_fim' => ['required', 'date', 'after_or_equal:data_inicio'],
            'percentagem' => ['required', 'numeric', 'min:0', 'max:100', 'regex:/^\d+(\.\d{1,2})?$/'],
        ]);

        $promocao['descricao'] = $request['descricao'];
        $promocao['percentagem'] = $request['percentagem'];

        if($validator->fails()) {
            $request['nome'] = $promocao['nome'];    
            $request['data_inicio'] = $promocao['data_inicio'];
            $request['data_fim'] = $promocao['data_fim'];
            return redirect('/atualizaPromocao/' . $promocao->id)->withErrors($validator)->withInput();
        }

        $request['nome'] = $promocao['nome'];
        $request['data_inicio'] = $promocao['data_inicio'];
        $request['data_fim'] = $promocao['data_fim'];
        $promocao->save();

        return redirect()->back()->with('mensagem_status', 'Dados atualizados');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Promocao  $promocao
     * @return \Illuminate\Http\Response
     */
    public function destroy(Promocao $promocao)
    {
        //
    }
}
