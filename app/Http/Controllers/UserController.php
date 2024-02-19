<?php

namespace App\Http\Controllers;

use App\Models\Endereco;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        //Bloqueia o adm de acessar essa tela
        if(Auth::user()->email =='adm@adm')
            return redirect('/');

        $endereco = Endereco::where('user_id', Auth::user()->id)->first();
        return view('auth.register', [
            'user' => Auth::user(), 
            'endereco' => $endereco,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //Bloqueia o adm de acessar essa tela
        if(Auth::user()->email =='adm@adm')
            return redirect('/');
        
        $user = User::find(Auth::user()->id);
        $endereco = Endereco::find($request['endereco_id']);

        if($user->email == $request['email']){
            $request['email'] = 'nao@avaliar.com';
        }else{
            $user['email'] = $request['email'];
        }

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'confirmed'],
            'cpf' => ['required', 'string', 'regex:/^[0-9]+$/'],
            'telefone' => ['required', 'string', 'regex:/^[0-9]+$/'],

            'estado' => ['required', 'string', 'max:255'],
            'cidade' => ['required', 'string', 'max:255'],
            'bairro' => ['required', 'string', 'max:255'],
            'logradouro' => ['required', 'string', 'max:255'],
            'cep' => ['required', 'string', 'regex:/^[0-9]+$/'],
        ]);

        $user['name'] = $request['name'];
        $user['cpf'] = $request['cpf'];

        $endereco['estado'] = $request['estado'];
        $endereco['cidade'] = $request['cidade'];
        $endereco['bairro'] = $request['bairro'];
        $endereco['logradouro'] = $request['logradouro'];
        $endereco['cep'] = $request['cep'];

        if ($validator->fails()) {
            $request['email'] = $user['email'];    
            return redirect('/editar')
                        ->withErrors($validator)
                        ->withInput()
                        ->with([
                            'user' => $user, 
                            'endereco' => $endereco, 
                        ]);
        }

        $request['email'] = $user['email'];
        $user->save();
        $endereco->save();

        return redirect()->back()->with('mensagem_status', 'Dados atualizados');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
