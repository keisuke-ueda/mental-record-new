@extends('layouts.app')

@section('title','クライエント詳細 / カルテ')

@section('content')

<head>
    <meta charset="UTF-8">
    <title>クライエント詳細 / カルテ</title>
</head>
<body>

<div class="page-frame">

    <div class="client-header">
        <div>クライエント名 : {{ $client->name }}</div>
        <div>ニックネーム : {{ $client->nickname }}</div>
        <div>年齢 :{{ $client->age }}</div>
        <div>性別 :{{ $client->sex }}</div>
        <div>職業 :{{ $client->occupation }}</div>
        <div class="sub-links">
            <a href="{{ route('clients.index') }}">クライエント一覧へ戻る</a>
            <a href="{{ route('clients.edit', $client->id) }}">クライエント編集</a>
        </div>
    </div>

        @if(session('success'))
        <div class="success-box">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="error-box">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @php
        $currentIndex = null;
        if ($selectedRecord) {
            foreach ($records as $index => $record) {
                if ($record->id === $selectedRecord->id) {
                    $currentIndex = $index;
                    break;
                }
            }
        }

        $prevRecord = ($currentIndex !== null && $currentIndex < count($records) - 1) ? $records[$currentIndex + 1] : null;
        $nextRecord = ($currentIndex !== null && $currentIndex > 0) ? $records[$currentIndex - 1] : null;
    @endphp

    <!-- 入力フォーム -->
    <form id="record-form" method="POST" action="{{ route('records.store', $client->id) }}" enctype="multipart/form-data">
        @csrf

        <div class="main-layout">

            <!-- 左エリア -->
            <div>
                <div class="left-tools">
                    <input
                        class="date-input"
                        type="date"
                        name="counseling_date"
                        value="{{ old('counseling_date', $selectedRecord ? optional($selectedRecord->counseling_date)->format('Y-m-d') : date('Y-m-d')) }}"
                    >
                    <button type="submit" class="small-btn">Save</button>
                </div>

                <div class="panel new-record-box">
                    <div class="panel-inner">
                        <div class="panel-title">
                            {{ $selectedRecord ? '選択中カルテ' : '新規カルテ' }}
                        </div>
                        <textarea name="counseling_data">{{ old('counseling_data', $selectedRecord ? $selectedRecord->counseling_data : '') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- 中央エリア -->
            <div>
                <div class="record-link-list">
                    @forelse($records as $record)
                        <div class="record-link-item">
                            <div><strong>{{ optional($record->counseling_date)->format('Y-m-d') }}</strong></div>
                            <div class="muted">{{ \Illuminate\Support\Str::limit($record->counseling_data, 40) }}</div>

                            <div class="log">
                                <a href="{{ route('clients.show', ['client' => $client->id, 'record_id' => $record->id]) }}" class="log-font">
                                    このカルテを見る
                                </a>
                                <button
                                    type="button"
                                    class="small-btn"
                                    style="padding: 4px 8px;"
                                    onclick="if(confirm('このカルテを削除しますか？')) document.getElementById('delete-record-{{ $record->id }}').submit();"
                                >
                                    削除
                                </button>
                            </div>
                        </div>
                    @empty
                        <div class="muted">過去カルテはありません。</div>
                    @endforelse
                </div>

                <div class="middle-pagination">
                    <div>
                        @if($prevRecord)
                            <a class="small-btn" href="{{ route('clients.show', ['client' => $client->id, 'record_id' => $prevRecord->id]) }}">◀</a>
                        @else
                            <button class="small-btn" disabled>◀</button>
                        @endif
                    </div>

                    <div>
                        {{ $selectedRecord ? optional($selectedRecord->counseling_date)->format('Y-m-d') : '日付なし' }}
                    </div>

                    <div>
                        @if($nextRecord)
                            <a class="small-btn" href="{{ route('clients.show', ['client' => $client->id, 'record_id' => $nextRecord->id]) }}">▶</a>
                        @else
                            <button class="small-btn" disabled>▶</button>
                        @endif
                    </div>
                </div>

                <div class="panel record-view-box">
                    <div class="panel-inner">
                        <div class="panel-title">過去カルテ</div>

                        @if($selectedRecord)
                            <textarea readonly class="readonly">{{ $selectedRecord->counseling_data }}</textarea>
                        @else
                            <textarea readonly>まだカルテがありません。</textarea>
                        @endif
                    </div>
                </div>
            </div>

            <!-- 右エリア -->
            <div class="right-column">
                @if($selectedRecord)

                    <!-- 上段 -->
                    <div class="top-area">
                        <div class="mini-panel">
                            <div class="panel-inner">
                                <h3>病名</h3>
                                <div class="scroll-area">
                                    @foreach($diseases as $disease)
                                        <label class="checkbox-label">
                                            <input
                                                type="checkbox"
                                                name="disease_ids[]"
                                                value="{{ $disease->id }}"
                                                {{ $selectedRecord->diseases->contains('id', $disease->id) ? 'checked' : '' }}
                                            >
                                            {{ $disease->disease }}
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="mini-panel">
                            <div class="panel-inner">
                                <h3>症状</h3>
                                <div class="scroll-area">
                                    @foreach($symptoms as $symptom)
                                        <label class="checkbox-label">
                                            <input
                                                type="checkbox"
                                                name="symptom_ids[]"
                                                value="{{ $symptom->id }}"
                                                {{ $selectedRecord->symptoms->contains('id', $symptom->id) ? 'checked' : '' }}
                                            >
                                            {{ $symptom->symptom }}
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 中段 -->
                    <div class="top-area">
                        <div class="mini-panel">
                            <div class="panel-inner">
                                <h3>薬品</h3>
                                <div class="scroll-area">
                                    @foreach($medicines as $medicine)
                                        <div class="checkbox-label medicine-row">
                                            <input
                                                type="checkbox"
                                                name="medicine_ids[]"
                                                value="{{ $medicine->id }}"
                                                id="medicine_{{ $medicine->id }}"
                                                {{ $selectedRecord->medicines->contains('id', $medicine->id) ? 'checked' : '' }}
                                            >

                                            <span
                                                class="medicine-name"
                                                data-medicine="{{ $medicine->medicine }}"
                                                data-product-name="{{ $medicine->product_name ?? '' }}"
                                                data-category="{{ $medicine->category ?? '' }}"
                                                data-efficacy="{{ $medicine->efficacy ?? '' }}"
                                            >
                                                {{ $medicine->medicine }}
                                            </span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="mini-panel">
                            <div class="panel-inner">
                                <h3>新規画像ファイル</h3>
                                <input type="file" name="images[]" multiple>
                            </div>
                        </div>
                    </div>

                    <!-- 下段 -->
                    <div class="mini-panel large">
                        <div class="panel-inner">
                            <h3>画像リスト</h3>
                            <div class="scroll-area large">
                                @if($selectedRecord->images->count())
                                    <div class="image-list">
                                        @foreach($selectedRecord->images as $image)
                                            <div class="image-item">
                                                <a href="{{ route('records.images.show',
                                                    ['client' => $client->id,
                                                    'record' => $selectedRecord->id,
                                                    'image' => $image->id
                                                    ]) }}" target="_blank">

                                                    <img src="{{ route('records.images.show', [
                                                        'client' => $client->id,
                                                        'record' => $selectedRecord->id,
                                                        'image' => $image->id
                                                    ]) }}" alt="record image">
                                                </a>
                                                <button
                                                    type="button"
                                                    class="image-delete-btn"
                                                    onclick="if(confirm('画像を削除しますか？')) document.getElementById('delete-image-{{ $image->id }}').submit();"
                                                >
                                                    ×
                                                </button>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="muted">画像はありません。</div>
                                @endif
                            </div>
                        </div>
                    </div>


                @else
                    <div class="muted">カルテを作成すると、ここで病名・症状・薬品・画像を管理できます。</div>
                @endif
            </div>

        </div>
    </form>

    <div id="medicine-modal" class="medicine-modal">
        <div class="medicine-modal-content">
            <button type="button" id="medicine-modal-close" class="medicine-modal-close">×</button>

            <h3>薬品詳細</h3>

            <div class="medicine-detail-item">
                <div class="medicine-detail-label">薬品名</div>
                <div id="modal-medicine-name" class="medicine-detail-value"></div>
            </div>

            <div class="medicine-detail-item">
                <div class="medicine-detail-label">商品名</div>
                <div id="modal-product-name" class="medicine-detail-value"></div>
            </div>

            <div class="medicine-detail-item">
                <div class="medicine-detail-label">カテゴリ</div>
                <div id="modal-category" class="medicine-detail-value"></div>
            </div>

            <div class="medicine-detail-item">
                <div class="medicine-detail-label">効能</div>
                <div id="modal-efficacy" class="medicine-detail-value"></div>
            </div>
        </div>
    </div>

    {{-- カルテ削除用フォーム --}}
    @foreach($records as $item)
        <form
            id="delete-record-{{ $item->id }}"
            method="POST"
            action="{{ route('records.destroy', ['client' => $client->id, 'record' => $item->id]) }}"
            style="display:none;"
        >
            @csrf
        </form>
    @endforeach

    {{-- 画像削除用フォーム --}}
    @if($selectedRecord)
        @foreach($selectedRecord->images as $image)
            <form
                id="delete-image-{{ $image->id }}"
                method="POST"
                action="{{ route('records.images.destroy', [
                    'client' => $client->id,
                    'record' => $selectedRecord->id,
                    'image' => $image->id
                ]) }}"
                style="display:none;"
            >
                @csrf

            </form>
        @endforeach
    @endif

</div>


<script src="{{ asset('js/app.js') }}" defer></script>

@endsection

