<?php

namespace App\Http\Controllers;

use App\Models\Compra;
use App\Models\CompraProduto;
use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompraController extends Controller
{

    // !!!!!!!!!!!!!!! TODO !!!!!!!!!!!!!!!
    // A lógica de verificar os produtos deve mudar quando for abrir a tela de carrinho
    // e quando for confirmar a compra e passar para a próxima etapa. Por causa do tempo
    // isso ficará para outra iteração.

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
     * Faz o calculo do desconto que um produto receberá com base nas
     * promoções à ele associadas
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    private function getDescontoProdutoNoCarrinho(Produto $produto, $quantidade)
    {
        $promocoes = $produto->promocoes()->get();
        $preco_com_desconto = $produto->preco * $quantidade;

        foreach($promocoes as $promocao)
            $preco_com_desconto *= ((100 - $promocao->percentagem)/100);

        return $preco_com_desconto;
    }
    
    /**
     * Adiciona um produto ao carrinho
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function adicionarAoCarrinho (Request $request)
    {
        $produto = Produto::find($request['produto_id']);
        $estoque_ok = true;
        
        if($request['quantidade'] < 0) {
            return redirect()->back()->with('mensagem_status_erro', 'Quantidade inválida do produto.');
        }else if ($request['quantidade'] > $produto->estoque) {
            // return redirect()->back()->with('mensagem_status_aviso', 'Quantidade selecionada excede o estoque. Quantidade máxima disponível adicionada ao carrinho');
            $request['quantidade'] = $produto->estoque;
            $estoque_ok = false;
        }

        $compra = Auth::user()->compras()->where('concluida', false)->first();
        $item_em_compra = $compra->produtos()->where('produto_id', $produto->id)->first();
        
        if($item_em_compra) {
            if($request['quantidade']) {
                $item_em_compra = $item_em_compra->pivot;
                $item_em_compra->quantidade = ((int) $request['quantidade']);
                $item_em_compra->preco_total = $produto->preco * $item_em_compra->quantidade;
                $item_em_compra->preco_com_desconto = $this->getDescontoProdutoNoCarrinho($produto, $item_em_compra->quantidade);
                $item_em_compra->save();
            }else {
                $compra->produtos()->detach($produto->id);
            }
        }else {
            $compra->produtos()->attach($produto->id, [
                'quantidade' => ((int) $request['quantidade']),
                'preco_total' => ( $produto->preco * ((int) $request['quantidade'])),
                'preco_com_desconto' => $this->getDescontoProdutoNoCarrinho($produto, ((int) $request['quantidade'])),
            ]);
        }
        
        if($estoque_ok){
            return redirect()->back()->with('mensagem_status', 'Produto adicionado ao carrinho');
        }else{
            return redirect()->back()->with(
                [
                    'mensagem_status' => 'Produto adicionado ao carrinho',
                    'mensagem_status_aviso' => 'Quantidade selecionada excede o estoque. Quantidade máxima disponível selecionada.'
                ],
            );
        }
    }

    /**
     * Verifica se o preço dos produtos no carrinho 
     * foram atualizado conforme as promoções. Se não atualiza.
     * 
     * @param Compra $compra
     * @return 
     */
    private function verificarPromocaoItensCarrinho(Compra $compra) {
        $itens_carrinho = CompraProduto::where('compra_id', $compra->id)->get();
        
        foreach($itens_carrinho as $item){
            $produto = Produto::find($item->produto_id);
            $item->preco_com_desconto = $this->getDescontoProdutoNoCarrinho($produto, $item->quantidade);
            $item->save();
        }

        return $itens_carrinho;
    }

    /**
     * Retorna os dados que serão usados na tela de carrinho.
     *
     * @return array
     */
    private function getDadosCarrinho(){
        $compra = Auth::user()->compras()->where('concluida', false)->first();
        $itens_carrinho = $this->verificarPromocaoItensCarrinho($compra);
        $total_da_compra = 0;

        foreach($itens_carrinho as $item){
            $produto = Produto::find($item->produto_id);
            $item['nome'] = $produto->nome;
            $item['preco'] = $produto->preco;

            //Esses novos atributos servem apenas para controle e não entram no BD
            if($produto->estoque == 0) {
                $item['estoque_zerado'] = true;
                $item->quantidade = 0;
            }elseif($produto->estoque < $item->quantidade) {
                $item['estoque_zerado'] = false;
                $item['estoque_menor'] = true;
                $item->quantidade = $produto->estoque;
            }else {
                $item['estoque_zerado'] = false;
                $item['estoque_menor'] = false;
            }

            $total_da_compra += $item->preco_com_desconto;
        }

        return [
            'compra' => $compra, 
            'itens_carrinho' => $itens_carrinho,
            'total_da_compra' => $total_da_compra,
        ];
    }

    /**
     * Exibe uma lista dos itens adicionaod ao carrinho
     *
     * @return \Illuminate\Http\Response
     */
    public function irParaCarrinho() {
        return view('compra.carrinho', $this->getDadosCarrinho());
    }

    /**
     * Exibe uma lista dos itens adicionaod ao carrinho
     *
     * @return \Illuminate\Http\Response
     */
    public function finalizarCompra() {
        return view('pagamento.efetuarPagamento');
    }

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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Compra  $compra
     * @return \Illuminate\Http\Response
     */
    public function show(Compra $compra)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Compra  $compra
     * @return \Illuminate\Http\Response
     */
    public function edit(Compra $compra)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Compra  $compra
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Compra $compra)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Compra  $compra
     * @return \Illuminate\Http\Response
     */
    public function destroy(Compra $compra)
    {
        //
    }
}
