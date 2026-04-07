@extends('admin.layout')
@section('title','Editar Curso')
@section('page-title','Editar: ' . $curso->titulo)

@section('content')
<form method="POST" action="{{ route('admin.cursos.update', $curso) }}" enctype="multipart/form-data">
    @csrf @method('PUT')
    @include('admin.cursos.form')
</form>
@endsection