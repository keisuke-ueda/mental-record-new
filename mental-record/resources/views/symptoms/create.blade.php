@extends('layouts.app')

@section('title','症状登録')

@section('content')

<h1>症状登録</h1>

@if ($errors->any())
    <div style="color: red;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('symptoms.store') }}">
    @csrf
    <table class="form-table">
        <tr>
            <th> 症状名</th>
            <td>
                <input type="text" name="symptom">
            </td>
        </tr>
        <tr>
            <th>症状概要</th>
            <td>
                <textarea name="symptom_summary"></textarea>
            </td>
        </tr>
    </table>
    <div class="btn-area">
        <button type="submit" class="update-btn">更新</button>
    </div>
</form>

<div class="footer-area">
    <div class="btn-area">
        <a href="{{ route('symptoms.index') }}" class="back-btn">一覧へ戻る</a>
    </div>
</div>

@endsection
