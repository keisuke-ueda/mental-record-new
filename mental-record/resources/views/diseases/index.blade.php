@extends('layouts.app')

@section('title','病名一覧')

@section('content')

<h1>病名一覧</h1>

@if(session('success'))
    <p style="color: green;">{{ session('success') }}</p>
@endif

<div class="create-btn">
    <a href="{{ route('diseases.create') }}" class="btn-text-3d">病名追加</a>
</div>


<table class="table_design11">
    <tr>
        <!-- <th>ID</th> -->
        <th>病名</th>
        <th>病名概要</th>
        <th>操作</th>
    </tr>

    @foreach($diseases as $disease)
        <tr>
            <!-- <td>{{ $disease->id }}</td> -->
            <td>{{ $disease->disease }}</td>
            <td class="disease-summary">{{ $disease->disease_summary }}</td>
            <td>
                <div class="action-buttons">
                    <a href="{{ route('diseases.edit', $disease->id) }}">編集</a>

                    <form action="{{ route('diseases.destroy', $disease->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('削除しますか？')" class="table-btn">削除</button>
                    </form>
                </div>
            </td>
        </tr>
    @endforeach
</table>



{{ $diseases->links() }}

@endsection

