<link rel="stylesheet" href="{{ asset('css/header.css') }}">


<header class="site-header">

    <div class="header-left">
        <a href="{{ route('dashboard') }}" class="logo">
            カルテ管理システム
            <img src="{{ asset('images/logo.png') }}" alt="">
        </a>
    </div>

    <nav class="header-nav">
        <a href="{{ route('clients.index') }}" class="nav-btn">クライエント</a>
        <a href="{{ route('diseases.index') }}" class="nav-btn">病名</a>
        <a href="{{ route('symptoms.index') }}" class="nav-btn">症状</a>
        <a href="{{ route('medicines.index') }}" class="nav-btn">薬品</a>
    </nav>

    <div class="header-right">
        <span class="user-name">
            {{ auth()->user()->name }}
        </span>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="logout-btn">ログアウト</button>
        </form>
    </div>

</header>