@extends('app')

@section('titulo', 'Cadastrar diarista')

@section('conteudo')
    <h1>Cadastrar diarista</h1>
    <form action="{{ route('diaristas.store') }}" method="POST" enctype="multipart/form-data">
     
     @include('_form')   
        
    </form>      

@endsection
