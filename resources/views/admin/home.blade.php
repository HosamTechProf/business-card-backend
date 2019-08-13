@extends('admin.layout.app')
@section('title')
Home Page
@endsection
@push('css')
@endpush

@section('content')
@component('admin.layout.header', ['nav_title' => 'Home Page'])
@endcomponent
@endsection
@push('js')
@endpush
