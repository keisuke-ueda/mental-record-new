@extends('layouts.app')

@section('title','病名登録')

@section('content')


<h1>病名登録</h1>

@if ($errors->any())
    <div style="color: red;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('diseases.store') }}">
    @csrf
    

    <table class="form-table">
            <tr>
                <th>病名</th>
                <td>
                    <input type="text" name="disease" value="{{ old('disease') }}">
                </td>
            </tr>
            <tr>
                <th>病名概要</th>
                <td>
                    <textarea name="disease_summary" rows="5" cols="40">{{ old('disease_summary') }}</textarea>
                </td>
            </tr>
        </table>
        <div class="btn-area">
            <button type="submit" class="update-btn">更新</button>
        </div>
</form>

<div class="footer-area">
    <div class="btn-area">
        <a href="{{ route('diseases.index') }}" class="back-btn">一覧へ戻る</a>
    </div>
</div>

@endsection
