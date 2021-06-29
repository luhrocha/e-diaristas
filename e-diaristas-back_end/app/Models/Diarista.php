<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diarista extends Model
{
    use HasFactory;

/** Define os campos que podem ser gravados no banco de dados */
    protected $fillable = ['nome_completo', 'cpf', 'email', 'telefone', 'logradouro', 'numero', 
    'bairro', 'complemento', 'cidade', 'estado', 'cep', 'codigo_ibge', 'foto_usuario'];

/** Define os campos que serão usados na serialização */
    protected $visible = ['nome_completo', 'cidade', 'foto_usuario','reputacao'];

    /** Adiciona campo na serialização */
    protected $appends = ['reputacao'];

    /** Monta a url da imagem */
    public function getFotoUsuarioAttribute(string $valor)
    {
        return config('app.url') . '/' . $valor;
    }
/** retorna a reputação randomica */
    public function getReputacaoAttribute($valor)
    {
        return mt_rand(1, 5);
    }

/** Busca diaristas por código ibge */
    static public function buscaPorCodigoIBGE(int $codigoIbge)
    {
        //Outro jeito de fazer o mesmo: self::where('codigo_ibge') .....
        return Diarista::where('codigo_ibge', $codigoIbge)->limit(6)->get();
    }

/** Retorna a quantidade de diaristas */
    static public function quantidadePorCodigoIbge(int $codigoIbge)
    {
        //Outro jeito de fazer o mesmo: self::where('codigo_ibge') .....
        $quantidade = Diarista::where('codigo_ibge', $codigoIbge)->count();

        return $quantidade > 6 ? $quantidade - 6 : 0;
    }

}
