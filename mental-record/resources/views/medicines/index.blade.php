@extends('layouts.app')

@section('title','薬品一覧')

@section('content')

<h1>薬品一覧</h1>

@if(session('success'))
    <p style="color: green;">{{ session('success') }}</p>
@endif

<div class="create-btn">
    <a href="{{ route('medicines.create') }}" class="btn-text-3d">薬品追加</a>
</div>

<table class="table_design11">
    <tr>
        <!-- <th>ID</th> -->
        <th>薬品名</th>
        <th>商品名</th>
        <th>カテゴリ</th>
        <th>効能</th>
        <th>操作</th>
    </tr>

    @foreach($medicines as $medicine)
        <tr>
            <!-- <td>{{ $medicine->id }}</td> -->
            <td>{{ $medicine->medicine }}</td>
            <td>{{ $medicine->product_name }}</td>
            <td>{{ $medicine->category }}</td>
            <td class="efficacy">{{ $medicine->efficacy }}</td>
            <td>
                <div class="action-buttons">
                    <a href="{{ route('medicines.edit', $medicine->id) }}">編集</a>

                    <form action="{{ route('medicines.destroy', $medicine->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('削除しますか？')" class="table-btn">削除</button>
                    </form>
                </div>
            </td>
        </tr>
    @endforeach
</table>

@if($medicines->hasPages())
    <div class="pagination-wrap">
        {{ $medicines->links() }}
    </div>
@endif


@endsection