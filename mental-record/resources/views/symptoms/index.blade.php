@extends('layouts.app')

@section('title','症状一覧')

@section('content')


<h1>症状一覧</h1>

@if(session('success'))
    <p style="color: green;">{{ session('success') }}</p>
@endif

<div class="create-btn">
    <a href="{{ route('symptoms.create') }}" class="btn-text-3d">症状登録</a>
</div>

<table class="table_design11">
    <tr>
        <!-- <th>ID</th> -->
        <th>症状名</th>
        <th>症状概要</th>
        <th>操作</th>
    </tr>

    @foreach($symptoms as $symptom)
        <tr>
            <!-- <td>{{ $symptom->id }}</td> -->
            <td>{{ $symptom->symptom }}</td>
            <td class="symptom-summary">{{ $symptom->symptom_summary }}</td>
            <td>
                <div class="action-buttons">
                    <a href="{{ route('symptoms.edit', $symptom->id) }}">編集</a>

                    <form action="{{ route('symptoms.destroy', $symptom->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('削除しますか？')" class="table-btn">削除</button>
                    </form>
                </div>
            </td>
        </tr>
    @endforeach
</table>

@if($symptoms->hasPages())
    <div class="pagination-wrap">
        {{ $symptoms->links() }}
    </div>
@endif


@endsection
