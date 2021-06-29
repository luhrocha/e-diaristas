<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Diarista;
use App\Services\ViaCEP;
use App\Http\Requests\DiaristaRequest;

class DiaristaController extends Controller
{
/** Versão anterior ao php 8 */
    //protected ViaCEP $viaCep;

    // public function __construct(ViaCEP $viaCep)
     //   {
     //      $this->viaCep = $viaCep;
      //  }

      /** Versão a partir do php 8 */
    public function __construct(protected ViaCEP $viaCep)
        {
           
        }
    /**
     *  Lista as diaristas 
     */
    
    public function index()
    {
        $diaristas = Diarista::get();

        return view('index', [
            'diaristas'=> $diaristas
        ]);
    }

    /**
     * Mostra o formulário de criação
     */
    public function create()
    {
        # code...
        return view('create');
    }

    /**
     * Cria uma diarista no banco de dados
     */
    public function store(DiaristaRequest $request)
    {
        $dados = $request->except('_token');
        /** código de minha autoria if */
        //if(isset($dados['foto_usuario'])){
            $dados['foto_usuario'] = $request->foto_usuario->store('public');
        //}
        
        
        $dados['cpf'] = str_replace(['.', '-'], '', $dados['cpf']);
        $dados['cep'] = str_replace('-', '', $dados['cep']);
        $dados['telefone'] = str_replace(['(', ')', ' ', '-'], '', $dados['telefone']);
        $dados['codigo_ibge'] = $this->viaCep->buscar($dados['cep'])['ibge'];
        
        Diarista::create($dados);

        return redirect()-> route('diaristas.index');
        //dd($request->all());
    }
/** 
 * mostra o formulário de edição populado
 * 
 */
    public function edit(int $id)
    {
        # code...
        $diarista = Diarista::findOrFail($id);
        return view('edit', [
            'diarista' => $diarista
        ]);
    }
/**
 * Atualiza uma diarista no banco de dados
 */
    public function update(int $id, DiaristaRequest $request)
    {
       $diarista = Diarista::findOrFail($id);

       $dados = $request->except('_token','_method');

       $dados['cpf'] = str_replace(['.', '-'], '', $dados['cpf']);
       $dados['cep'] = str_replace('-', '', $dados['cep']);
       $dados['telefone'] = str_replace(['(', ')', ' ', '-'], '', $dados['telefone']);
       $dados['codigo_ibge'] = $this->viaCep->buscar($dados['cep'])['ibge'];

       if($request->hasFile('foto_usuario')){
           $dados['foto_usuario'] = $request->foto_usuario->store('public');
       }

       $diarista->update($dados);

       return redirect()->route('diaristas.index');
    }
/**
 * Apaga uma diarista no banco de dados
 */
    public function destroy(int $id)
    {
        $diarista = Diarista::findOrFail($id);
        $diarista->delete();

        return redirect()->route('diaristas.index');
    }
}
