<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ViaCEP;
use App\Models\Diarista;

class BuscaDiaristaCep extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, ViaCEP $viaCEP)
    {
        //função com uma única ação (invoke), uma action por controller
        

        //entrada o cep
        // saida código ibge

        $endereco = $viaCEP->buscar($request->cep);
         //entra com o código do ibge
        //retorna lista de diaristas filtrada pelo código
        if($endereco === false){
            return response()->json(['erro' => 'Cep inválido'], 400);
        }

        return [
            'diaristas' => Diarista::buscaPorCodigoIbge($endereco['ibge']),
            'quantidade_diaristas' => Diarista::quantidadePorCodigoIbge($endereco['ibge'])       
        ];
              
    }
}
