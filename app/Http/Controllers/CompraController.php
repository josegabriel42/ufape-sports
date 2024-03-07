<?php

namespace App\Http\Controllers;

use App\Models\Compra;
use App\Models\CompraProduto;
use App\Models\Produto;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

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
     * Retorna as compras efetuadas pelo usuário na data específica
     * 
     * 
     */
    private function getDadosClienteCompra($compras) {
        $tmp = collect();
        foreach($compras as $compra) {
            $compra['cpf_cliente'] = $this->maskCpf($compra->user()->first()->cpf);
            $tmp->push($compra);
        }
        return $tmp;
    }

    /**
     * Retorna as compras efetuadas pelo usuário na data específica
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function historico(Request $request) {
        if(Auth::user()->email =='adm@adm') {
            // Filtra por cpf
            $cpf = $request['cpf'];
            if(!is_null($cpf)) {
                $compras = Compra::whereHas('user', function (Builder $query) use ($cpf) {
                    $query->where('cpf', 'like', '%'.$cpf.'%');
                })->where('concluida', true);
            }else {
                $compras = Compra::where('concluida', true);
            }
        }
        else
            $compras = Auth::user()->compras()->where('concluida', true);

        // Filtra pela data
        if(!is_null($request['data_inicio'])) {
            if(!is_null($request['data_fim']))
                $compras = $compras->whereBetween('data_compra', [$request['data_inicio'], $request['data_fim']]);
            else
                $compras = $compras->where('data_compra', '>=', $request['data_inicio']);
        } else {
            if(!is_null($request['data_fim']))
                $compras = $compras->where('data_compra', '<=', $request['data_fim']);
        }

        // Filtra pelo total
        if(!is_null($request['preco_minimo'])) {
            if(!is_null($request['preco_maximo']))
                $compras = $compras->whereBetween('total', [$request['preco_minimo'], $request['preco_maximo']]);
            else
                $compras = $compras->where('total', '>=', $request['preco_minimo']);
        } else {
            if(!is_null($request['preco_maximo']))
                $compras = $compras->where('total', '<=', $request['preco_maximo']);
        }
        
        $compras = $compras->get();

        // Adiciona um versão censurado do cpf de cliente as info da compra
        if(Auth::user()->email =='adm@adm')
            $compras = $this->getDadosClienteCompra($compras);

        return view('compra.historico', ['compras' => $compras]);
    }

    /**
     * Faz o calculo do desconto que um produto receberá com base nas
     * promoções à ele associadas
     *
     * @param  \Illuminate\Http\Request  $request
     */
    private function getDescontoProdutoNoCarrinho(Produto $produto, $quantidade)
    {
        $promocoes = $produto->promocoes()->get();
        $preco_com_desconto = $produto->preco * $quantidade;

        foreach($promocoes as $promocao) {
            $data_inicio = Carbon::create($promocao->data_inicio);
            $data_fim = Carbon::create($promocao->data_fim);
            $data_hoje = Carbon::today();
            if($data_hoje->gte($data_inicio) && $data_hoje->lte($data_fim)){
                $preco_com_desconto *= ((100 - $promocao->percentagem)/100);
            }
        }

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
        //Bloqueia o adm de acessar essa tela
        if(Auth::user()->email =='adm@adm')
            return redirect('/');
        
        $produto = Produto::find($request['produto_id']);
        $estoque_ok = true;
        
        if($request['quantidade'] < 0) {
            return redirect()->back()->with('mensagem_status_erro', 'Quantidade inválida do produto.');
        }else if ($request['quantidade'] > $produto->estoque) {
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
            $item->preco_com_desconto = round((float) $item->preco_com_desconto, 2);
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

        
        // Só salva o preço após fazer a verificação das promoções
        $compra->total = $total_da_compra;
        $compra->save();

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
        //Bloqueia o adm de acessar essa tela
        if(Auth::user()->email =='adm@adm')
            return redirect('/');

        return view('compra.carrinho', $this->getDadosCarrinho());
    }

    /**
     * Censura o cpf fornecido
     * 
     * @param string $cpf
     * @return string
     */
    private function maskCpf($cpf) {
            $cpf_length = Str::length($cpf);
            for($i = 0; $i < $cpf_length/2; $i++)
                $cpf[$i] = '*';

            return $cpf;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Compra  $compra
     * @return \Illuminate\Http\Response
     */
    public function show(Compra $compra)
    {
        $itens_carrinho = collect();

        foreach($compra->produtos()->get() as $produto){
            $item = $produto->pivot;
            $item['nome'] = $produto->nome;
            $item['preco_venda'] = ($item->preco_total/$item->quantidade);
            $item['preco_atual'] = $produto->preco;
            $itens_carrinho->push($produto->pivot);
        }

        if(Auth::user()->email =='adm@adm') 
            $compra['cpf_cliente'] = $this->maskCpf($compra->user()->first()->cpf);
            
        return view('compra.visualizar', [
            'compra' => $compra,
            'pagamento' => $compra->pagamento()->first(),
            'itens_carrinho' => $itens_carrinho,
        ]);
    }
}
