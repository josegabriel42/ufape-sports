<?php

namespace App\Http\Controllers;

use App\Models\Compra;
use App\Models\CompraProduto;
use App\Models\Endereco;
use App\Models\Pagamento;
use App\Models\Produto;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PagamentoController extends Controller
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
     * Retorna o endereço completo do usuário em forma de string
     *
     * @return string
     */
    private function getEnderecoUser(){
        $e = Auth::user()->enderecos()->first();
        $endereco_str = $e['estado'] . ' | ' . $e['cidade'] . ' | ' . $e['bairro'] . ' | ' . $e['logradouro'] . ' | ' . $e['cep'];
        return $endereco_str;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //Bloqueia o adm de acessar essa tela
        if(Auth::user()->email =='adm@adm')
            return redirect('/');
        
        $compra = Compra::find($request['compra_id']);
        $pagamento = $compra->pagamento()->first();

        if(!$pagamento) {
            $pagamento = $compra->pagamento()->make([
                'nome_titular' => "XXXXX",
                'data_vencimento_cartao' => "XX/XX",
                'numero_cartao' => "00000000",
                'cod_seguranca' => '000',
                'endereco_entrega' => $this->getEnderecoUser(),
            ]);
        }

        return view('pagamento.cadastrar', [
            'pagamento' => $pagamento, 
            'compra_id' => $compra->id,
            'total' => $request['total'],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Bloqueia o adm de acessar essa tela
        if(Auth::user()->email =='adm@adm')
            return redirect('/');

        $compra = Compra::find($request['compra_id']);
        $pagamento = $compra->pagamento()->make([
            'nome_titular' => "XXXXX",
            'data_vencimento_cartao' => "XX/XX",
            'numero_cartao' => "00000000",
            'cod_seguranca' => '000',
            'endereco_entrega' => $request['endereco_entrega'],
        ]);;
        $itens_carrinho = [];

        $validator = Validator::make($request->all(), [
            'nome_titular' => ['required', 'string', 'max:256'],
            'data_vencimento_cartao' => ['required', 'string', 'max:255'],
            'numero_cartao' => ['required', 'string', 'regex:/^[0-9]+$/'],
            'cod_seguranca' => ['required', 'string', 'regex:/^[0-9]+$/', 'max:3'],
            // 'endereco_entrega' => ['required', 'string', 'regex:/^[0-9]+$/'],
        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with([
                'pagamento' => $pagamento, 
                'compra_id' => $compra->compra_id,
                'total' => $request['total'],
            ]);
        }

        // Reduz os itens comprados do estoque
        $itens_carrinho = CompraProduto::where('compra_id', $compra->id)->get();
        foreach($itens_carrinho as $item) {
            $produto = Produto::find($item->produto_id);
            $produto->estoque -= $item->quantidade;
            $produto->save();
        }

        // Marca compra como concluída e cria um novo objeto compra para futuras operações
        $compra->concluida = true;
        $compra->data_compra = Carbon::now();
        $compra->total = $request['total'];
        $compra->save();
        Auth::user()->compras()->create([
            'concluida' => false,
        ]);

        // Salva as informações de pagamento
        $pagamento->nome_titular = $request['nome_titular'];
        $pagamento->data_vencimento_cartao = $request['data_vencimento_cartao'];
        $pagamento->numero_cartao = $request['numero_cartao'];
        $pagamento->save();

        return redirect('produtos')->with(['mensagem_status' => 'Pagamento efetuado!']);
    }
}
