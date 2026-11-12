@extends('layouts.app')
@section('title', 'Edit Agenda')
@section('inline-errors', '1')
@section('head')
<div class="page-head"><div class="container"><h1>Edit agenda</h1></div></div>
@endsection
@section('content')
<div class="container" style="max-width: 920px">
  <div class="card"><div class="card-body p-4">
    @include('admin.agenda._form', ['action' => route('admin.agenda.update', $agenda), 'method' => 'PUT'])
  </div></div>
</div>
@endsection
