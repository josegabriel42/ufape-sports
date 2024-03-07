<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Produto;
use App\Models\Promocao;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
     * Retorna um objeto produto com dados adicionais referentes as suas promoções
     * 
     * @param Produto $produto
     * @return Produto
     */
    private function getDadosPromocionaisProduto(Produto $produto) {
        $promocoes = $produto->promocoes()->get();
        $preco_com_desconto = $produto->preco;

        foreach($promocoes as $promocao) {
            $data_inicio = Carbon::create($promocao->data_inicio);
            $data_fim = Carbon::create($promocao->data_fim);
            $data_hoje = Carbon::today();
            if($data_hoje->gte($data_inicio) && $data_hoje->lte($data_fim)) {
                $preco_com_desconto *= ((100 - $promocao->percentagem)/100);
                $produto['promocao_ativa'] = true;
            }
        }

        $produto['preco_com_desconto'] = $preco_com_desconto;

        return $produto;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $produtos = collect();
        foreach(Produto::all() as $produto)
            $produtos->push($this->getDadosPromocionaisProduto($produto));

        return view('produto.consultar', [
            'produtos' => $produtos,
            'promocoes' => Promocao::all(),
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
        $promocao = $request['promocao'];
        $marca = $request['marca'];
        $preco_minimo = $request['preco_minimo'];
        $preco_maximo = $request['preco_maximo'];
        $peso_minimo = $request['peso_minimo'];
        $peso_maximo = $request['peso_maximo'];
        $promocao_id = $request['promocao_id'];

        if(is_null($promocao_id)) {
            $busca = Produto::where('id', '>', 0);
        }else {
            $busca = Produto::whereDoesntHave('promocoes', function (Builder $query) use ($promocao_id) {
                $query->where('promocao_id', $promocao_id);
            });
        }

        if ($nome)
            $busca = $busca->where('nome', 'like', '%'.$nome.'%');
        
        if ($categoria)
            $busca = $busca->where('categoria_id', $categoria);

        if ($promocao) {
            $busca = $busca->whereHas('promocoes', function (Builder $query) use ($promocao) {
                $query->where('promocao_id', $promocao)->where('data_fim', '>=', Carbon::today());
            });
        }
        
        if ($marca)
            $busca = $busca->where('marca', 'like', '%'.$marca.'%');

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

        $produtos = collect();
        foreach($busca->get() as $produto)
            $produtos->push($this->getDadosPromocionaisProduto($produto));

        if(is_null($promocao_id)) {
            return view('produto.consultar', [
                'produtos' => $produtos,
                'promocoes' => Promocao::all(),
                'categorias' => Categoria::all(),
            ]);
        } else {
            $promocao = Promocao::find($promocao_id);
            $produtos_promocao = collect();
            foreach($promocao->produtos()->get() as $produto)
                $produtos_promocao->push($this->getDadosPromocionaisProduto($produto));

            return view('produto.consultar', [
                'promocao' => $promocao,
                'produtos_promocao' => $produtos_promocao,
                'produtos' => $produtos,
                'promocoes' => Promocao::all(),
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
        //Bloqueia o acesso à usuários sem privilégio
        if(Auth::user()->email !='adm@adm')
            return redirect('/');
        
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
        //Bloqueia o acesso à usuários sem privilégio
        if(Auth::user()->email !='adm@adm')
            return redirect('/');

        $data = $request->all();
        $validator =  Validator::make($data, [
            'nome' => ['required', 'string', 'max:255', 'unique:produtos'],
            'descricao' => ['required', 'string', 'max:255'],
            'marca' => ['required', 'string'],
            'cor' => ['required', 'string'],
            'preco' => ['required', 'numeric', 'min:0', 'regex:/^\d+(\.\d{1,2})?$/'],
            'peso' => ['required', 'numeric', 'min:0.01', 'regex:/^\d+(\.\d{1,2})?$/'],
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

        return redirect('/cadastroProduto')->with('mensagem_status', 'Produto cadastrado');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Produto  $produto
     * @return \Illuminate\Http\Response
     */
    public function show(Produto $produto)
    {
        $categoria = $produto->categoria()->first();
        $promocoes = $produto->promocoes()->get();
        $promocoes_valendo = collect();
        $produtos_mesma_categoria = Produto::where('categoria_id', $categoria->id)->get();
        $preco_com_desconto = $produto->preco;

        foreach($promocoes as $promocao) {
            $data_inicio = Carbon::create($promocao->data_inicio);
            $data_fim = Carbon::create($promocao->data_fim);
            $data_hoje = Carbon::today();
            if($data_hoje->gte($data_inicio) && $data_hoje->lte($data_fim)) {
                $promocoes_valendo->push($promocao);
                $preco_com_desconto *= ((100 - $promocao->percentagem)/100);
            }
        }

        $produto['preco_com_desconto'] = $preco_com_desconto;

        $tmp = collect();
        foreach($produtos_mesma_categoria as $produto_m_c)
            $tmp->push($this->getDadosPromocionaisProduto($produto_m_c));
        $produtos_mesma_categoria = $tmp;

        return view('produto.visualizar', [
            'produto_atual' => $produto,
            'nome_categoria' => $categoria->nome,
            'produtos_mesma_categoria' => $produtos_mesma_categoria,
            'promocoes_valendo' => $promocoes_valendo,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Produto  $produto
     * @return \Illuminate\Http\Response
     */
    public function edit(Produto $produto)
    {
        //Bloqueia o acesso à usuários sem privilégio
        if(Auth::user()->email !='adm@adm')
            return redirect('/');
        
        return view('produto.cadastro', [
            'produto' => $produto, 
            'categorias' => Categoria::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Produto  $produto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //Bloqueia o acesso à usuários sem privilégio
        if(Auth::user()->email !='adm@adm')
            return redirect('/');

        $produto = Produto::find($request['produto_id']);
        if($produto->nome == $request['nome']) {
            $request['nome'] = 'nao avaliar';
        }else {
            $produto['nome'] = $request['nome'];
        }

        $data = $request->all();
        $validator =  Validator::make($data, [
            'nome' => ['required', 'string', 'max:255', 'unique:produtos'],
            'descricao' => ['required', 'string', 'max:255'],
            'marca' => ['required', 'string'],
            'cor' => ['required', 'string'],
            'preco' => ['required', 'numeric', 'min:0', 'regex:/^\d+(\.\d{1,2})?$/'],
            'peso' => ['required', 'numeric', 'min:0.01', 'regex:/^\d+(\.\d{1,2})?$/'],
            'estoque' => ['required', 'numeric', 'integer', 'min:0'],
            'categoria' => ['required', 'exists:categorias,id'],
        ]);

        $produto['descricao'] = $request['descricao'];
        $produto['marca'] = $request['marca'];
        $produto['cor'] = $request['cor'];
        $produto['preco'] = $request['preco'];
        $produto['peso'] = $request['peso'];
        $produto['estoque'] = $request['estoque'];
        $produto['categoria_id'] = $request['categoria'];

        if($validator->fails()) {
            $request['nome'] = $produto['nome'];    
            return redirect('/atualizaProduto/' . $produto->id)->withErrors($validator)->withInput();
        }

        $request['nome'] = $produto['nome'];
        $produto->save();

        return redirect()->back()->with('mensagem_status', 'Dados atualizados');
    }
}
