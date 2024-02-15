<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Produto;
use App\Models\Promocao;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        return view('produto.consultar', [
            'produtos' => Produto::all(),
            'categorias' => Categoria::all(),
        ]);
    }

    /**
     * Mostra um listagem dos produtos que correspondem à consulta.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function consulta(Request $request)
    {
        $nome = $request['nome'];
        $categoria = $request['categoria'];
        $marca = $request['marca'];
        $preco_minimo = $request['preco_minimo'];
        $preco_maximo = $request['preco_maximo'];
        $peso_minimo = $request['peso_minimo'];
        $peso_maximo = $request['peso_maximo'];
        $promocao_id = $request['promocao_id'];

        if(is_null($promocao_id)) {
            $busca = DB::table('produtos');
        }else {
            $busca = Produto::doesntHave('promocoes');
        }

        if ($nome)
            $busca = $busca->where('nome', 'like', '%'.$nome.'%');
        
        if ($categoria)
            $busca = $busca->where('categoria_id', $categoria);
        
        if ($marca)
            $busca = $busca->where('nome', 'like', '%'.$marca.'%');

        if (!is_null($preco_minimo) && !is_null($preco_maximo)) {
            $busca = $busca->whereBetween('preco', [$preco_minimo, $preco_maximo]);
        }elseif (!is_null($preco_minimo)) {
            $busca = $busca->where('preco', '>=', $preco_minimo);
        }elseif (!is_null($preco_maximo)) {
            $busca = $busca->where('preco', '<=', $preco_maximo);
        }
        
        if (!is_null($peso_minimo) && !is_null($peso_maximo)) {
            $busca = $busca->whereBetween('peso', [$peso_minimo, $peso_maximo]);
        }elseif (!is_null($peso_minimo)) {
            $busca = $busca->where('peso', '>=', $peso_minimo);
        }elseif (!is_null($peso_maximo)) {
            $busca = $busca->where('peso', '<=', $peso_maximo);
        }

        if(is_null($promocao_id)) {
            return view('produto.consultar', [
                'produtos' => $busca->get(),
                'categorias' => Categoria::all(),
            ]);
        } else {
            $promocao = Promocao::find($promocao_id);
            $produtos_promocao = $promocao->produtos()->get();
            $produtos = $busca->get();

            return view('produto.consultar', [
                'promocao' => $promocao,
                'produtos_promocao' => $produtos_promocao,
                'produtos' => $produtos,
                'categorias' => Categoria::all(),
            ]);
        }

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
