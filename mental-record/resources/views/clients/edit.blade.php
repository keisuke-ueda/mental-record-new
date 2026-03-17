@extends('layouts.app')

@section('title','クライエント編集')

@section('content')


<h1>クライエント編集</h1>

<form method="POST" action="{{ route('clients.update',$client->id) }}">
    @csrf
    @method('PUT')

    <table class="form-table">

        <tr>
            <th>名前</th>
            <td>
                <input type="text" name="name" value="{{ $client->name }}">
            </td>
        </tr>
        <tr>
            <th>ニックネーム</th>
            <td>
                <input type="text" name="nickname" value="{{ $client->nickname }}">
            </td>
        </tr>
        <tr>
            <th>年齢</th>
            <td>
                <input type="text" name="age" value="{{ $client->age }}">
            </td>
        </tr>
        <tr>
            <th>性別</th>
            <td>
                <select name="sex">
                    <option value="Male" @if($client->sex=='Male') selected @endif>Male</option>
                    <option value="Female" @if($client->sex=='Female') selected @endif>Female</option>
                    <option value="LGBTQ" @if($client->sex=='LGBTQ') selected @endif>LGBTQ</option>
                    <option value="Other" @if($client->sex=='Other') selected @endif>other</option>
                </select>
            </td>
        </tr>
        <tr>
            <th>職業</th>
            <td>
                <input type="text" name="occupation" value="{{ $client->occupation }}">
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

