@extends('layouts.app')

@section('title','薬品編集')

@section('content')

<h1>薬品編集</h1>

@if ($errors->any())
    <div style="color: red;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('medicines.update', $medicine->id) }}">
    @csrf
    @method('PUT')

    <table class="form-table">

        <tr>
            <th>薬品名</th>
            <td>
                <input type="text" name="medicine" value="{{ old('medicine', $medicine->medicine) }}">
            </td>
        </tr>
        <tr>
            <th>商品名</th>
            <td>
                <input type="text" name="product_name" value="{{ old('product_name', $medicine->product_name) }}">
            </td>
        </tr>
        <tr>
            <th>カテゴリ</th>
            <td>
                <select name="category">
                    <option value="抗不安薬" @if($medicine->category=='抗不安薬') selected @endif>抗不安薬</option>
                    <option value="抗精神薬" @if($medicine->category=='抗精神薬') selected @endif>抗精神薬</option>
                    <option value="抗うつ薬" @if($medicine->category=='抗うつ薬') selected @endif>抗うつ薬</option>
                    <option value="睡眠薬" @if($medicine->category=='睡眠薬') selected @endif>睡眠薬</option>
                </select>
            </td>
        </tr>
        <tr>
            <th>効能</th>
            <td>
                <textarea name="efficacy" rows="5" cols="40">{{ old('efficacy', $medicine->efficacy) }}</textarea>
            </td>
        </tr>
        </table>
    <div class="btn-area">
        <button type="submit" class="update-btn">更新</button>
    </div>

</form>

<div class="footer-area">
    <div class="btn-area">
        <a href="{{ route('medicines.index') }}"  class="back-btn">一覧へ戻る</a>
    </div>
</div>





@endsection
