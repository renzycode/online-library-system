@extends('librarian/template')

@section('content-title')
    Dashboard
@endsection

@section('navigation-active')
    @php
        $active = 'dashboard';
    @endphp
@endsection

@section('content')
<div class="m-4">
    <h2 class="mb-4 text-dark">
        <span class="page-title">
        Dashboard
        </span>
        <br>
        <hr>
    </h2>
</div>

<!-- end modal add books -->
@endsection