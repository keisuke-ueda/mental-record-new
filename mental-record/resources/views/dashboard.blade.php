@extends('layouts.app')

@section('title','メニュー')

@section('content')

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<div class="menu-wrap">
    <a href="{{ route('clients.index') }}" class="menu-card">クライエント一覧</a>
    <a href="{{ route('diseases.index') }}" class="menu-card">病名一覧</a>
    <a href="{{ route('symptoms.index') }}" class="menu-card">症状一覧</a>
    <a href="{{ route('medicines.index') }}" class="menu-card">薬品一覧</a>
</div>

@endsection