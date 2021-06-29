@extends('app')

@section('titulo', 'Página inicial')

@section('conteudo')
<h1>Lista de diaristas</h1>

    <table class="table">
        <thead>
            <tr>
               <th scope="col">ID</th>
               <th scope="col">Nome</th>
               <th scope="col">Telefone</th>
               <th scope="col">Ações</th>
            </tr>
        </thead>
        <tbody>
            
        @forelse ($diaristas as $diarista)
            <tr>
                <th scope="row">{{ $diarista->id}}</th>
                <td>{{ $diarista->nome_completo}}</td>
                <td>{{ 
                        $output = \Clemdesign\PhpMask\Mask::apply($diarista->telefone, '(00) 00000-0000')                   
                    }}</td>
                <td>
                    <a href="{{ route('diaristas.edit', $diarista) }}" class="btn btn-primary">Atualizar</a>
                    <a href="{{ route('diaristas.destroy', $diarista) }}" class="btn btn-danger" onClick="return confirm('tem certeza que deseja apagar?')">Excluir</a>
                </td>
            </tr>
        @empty
            <tr>
                <th></th>
                <td>Nenhum registro cadastrado</td>
                <td></td>
                <td></td>
            </tr>
        @endforelse 


        </tbody>
    </table>

        <a href="{{ route('diaristas.create')}}" class="btn btn-success">Nova Diarista</a>

@endsection


