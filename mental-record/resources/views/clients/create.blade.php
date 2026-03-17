@extends('layouts.app')

@section('title','クライエント登録')

@section('content')


<h1>クライエント登録</h1>

@if ($errors->any())
    <div style="color: red;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('clients.store') }}">
@csrf

<table class="form-table">
        <tr>
            <th>名前</th>
            <td>
                <input type="text" name="name">
            </td>
        </tr>
        <tr>
            <th>ニックネーム</th>
            <td>
                <input type="text" name="nickname">
            </td>
        </tr>
        <tr>
            <th>年齢</th>
            <td>
                <input type="text" name="age">
            </td>
        </tr>
        <tr>
            <th>性別</th>
            <td>
                <select name="sex">
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="LGBTQ">LGBTQ</option>
                    <option value="Other">Other</option>
                </select>
            </td>
        </tr>
        <tr>
            <th>職業</th>
            <td>
                <input type="text" name="occupation">
            </td>
        </tr>
        </table>
    <div class="btn-area">
        <button type="submit" class="update-btn">更新</button>
    </div>

</form>

<div class="footer-area">
    <div class="btn-area">
        <a href="{{ route('clients.index') }}" class="back-btn">一覧へ戻る</a>
    </div>
</div>

@endsection

