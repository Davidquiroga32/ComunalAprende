@extends('admin.layout')
@section('title','Nuevo Curso')
@section('page-title','Nuevo Curso')

@section('content')
<form method="POST" action="{{ route('admin.cursos.store') }}" enctype="multipart/form-data">
    @csrf
    @include('admin.cursos.form')
</form>
@endsection