@extends('layouts.app')

@section('title','クライエント一覧')

@section('content')

<body>

<h1>クライエント一覧</h1>

@if(session('chart_error'))
    <div class="error-message">
        {{ session('chart_error') }}
    </div>
@endif

<div class="create-btn">
    <a href="{{ route('clients.create') }}" class="btn-text-3d">クライエント追加</a>
</div>

<table class="table_design11">
    <tr>
        <!-- <th>ID</th> -->
        <th>名前</th>
        <th>ニックネーム</th>
        <th>年齢</th>
        <th>性別</th>
        <th>職業</th>
        <th>操作</th>
    </tr>

    @foreach($clients as $client)
    <tr>
        <!-- <td>{{ $client->id }}</td> -->
        <!-- <td>{{ $client->name }}</td> -->
        <td>{{ $client->masked_name }}</td>
        <td>{{ $client->nickname }}</td>
        <td>{{ $client->age }}</td>
        <td>{{ $client->sex }}</td>
        <td>{{ $client->occupation }}</td>

        <td>
            <div class="action-buttons">
                
                 <button
                    type="button"
                    class="open-chart-modal table-btn"
                    data-client-id="{{ $client->id }}"
                    data-client-name="{{ $client->masked_name }}"
                    data-action="{{ route('clients.chart.auth', $client->id) }}"
                >
                    カルテ
                </button>

                <!-- <a href="{{ route('clients.edit',$client->id) }}">編集</a> -->

                <form action="{{ route('clients.destroy',$client->id) }}" method="POST" style="display:inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('削除しますか？')" class="table-btn">削除</button>
                </form>

            </div>
            
        </td>
    </tr>
    @endforeach

</table>
@if($clients->hasPages())
    <div class="pagination-wrap">
        {{ $clients->links() }}
    </div>
@endif

{{-- モーダル --}}
<div id="chartPasswordModal" class="modal-overlay">
    <div class="modal-box">
        <button type="button" class="modal-close" id="closeChartModal">×</button>

        <h2>カルテ閲覧認証</h2>
        <p id="modalClientName">クライエント名</p>

        <form id="chartPasswordForm" method="POST" action="">
            @csrf

            <div class="form-group">
                <label for="chart_password">パスワード</label>
                <input type="password" name="chart_password" id="chart_password" required>
            </div>

            @error('chart_password')
                <div class="error-message">
                    {{ $message }}
                </div>
            @enderror

            <div class="modal-actions">
                <button type="submit" class="table-btn">入る</button>
                <button type="button" class="table-btn" id="cancelChartModal">キャンセル</button>
            </div>
        </form>
    </div>
</div>

<!-- モーダル表示 -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('chartPasswordModal');
    const form = document.getElementById('chartPasswordForm');
    const clientNameText = document.getElementById('modalClientName');
    const passwordInput = document.getElementById('chart_password');
    const closeBtn = document.getElementById('closeChartModal');
    const cancelBtn = document.getElementById('cancelChartModal');
    const openButtons = document.querySelectorAll('.open-chart-modal');

    function openModal(action, clientName) {
        form.action = action;
        clientNameText.textContent = `「${clientName}」さんのカルテを開くにはパスワードを入力してください。`;
        modal.classList.add('active');
        passwordInput.focus();
    }

    function closeModal() {
        modal.classList.remove('active');
        passwordInput.value = '';
    }

    openButtons.forEach(button => {
        button.addEventListener('click', function () {
            openModal(
                this.dataset.action,
                this.dataset.clientName
            );
        });
    });

    closeBtn.addEventListener('click', closeModal);
    cancelBtn.addEventListener('click', closeModal);

    modal.addEventListener('click', function (e) {
        if (e.target === modal) {
            closeModal();
        }
    });
});
</script>

@if($errors->has('chart_password') && session('modal_client_id'))
<script>
document.addEventListener('DOMContentLoaded', function () {

    const clientId = @json(session('modal_client_id'));

    if (!clientId) return;

    const targetButton = document.querySelector(
        '.open-chart-modal[data-client-id="' + clientId + '"]'
    );

    if (targetButton) {
        targetButton.click();
    }
});
</script>
@endif

@endsection
