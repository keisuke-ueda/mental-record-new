@extends('layouts.app')

@section('title','薬品登録')

@section('content')


<h1>薬品登録</h1>

@if ($errors->any())
    <div style="color: red;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('medicines.store') }}">
    @csrf

    <table class="form-table">
        <tr>
            <th> 薬品名</th>
            <td>
                <input type="text" name="medicine">
            </td>
        </tr>
        <tr>
            <th> 商品名</th>
            <td>
                <input type="text" name="product_name">
            </td>
        </tr>
        <tr>
            <th>カテゴリ</th>
            <td>
                <select name="category">
                    <option value="抗不安薬">抗不安薬</option>
                    <option value="抗精神薬">抗精神薬</option>
                    <option value="抗うつ薬">抗うつ薬</option>
                    <option value="睡眠薬">睡眠薬</option>
                </select>
            </td>
        </tr>
        <tr>
            <th>効能</th>
            <td>
                <textarea name="efficacy"></textarea>
            </td>
        </tr>
    </table>
    <div class="btn-area">
        <button type="submit" class="update-btn">更新</button>
    </div>
</form>


<div class="footer-area">
    <div class="btn-area">
        <a href="{{ route('medicines.index') }}" class="back-btn">一覧へ戻る</a>
    </div>
</div>


@endsection
