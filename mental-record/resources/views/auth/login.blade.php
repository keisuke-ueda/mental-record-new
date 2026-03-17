<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="{{ asset('./css/app.css') }}">
    <meta charset="UTF-8">
    <title>ログイン</title>
</head>
<body>

<div class="login-wrap">
    <h1>ログイン</h1>

    @if($errors->any())
        <div class="error-box">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('login.submit') }}">
        @csrf

        <div class="form-group">
            <label>メールアドレス</label>
            <input type="email" name="email" value="{{ old('email') }}">
        </div>

        <div class="form-group">
            <label>パスワード</label>
            <input type="password" name="password">
        </div>

        <button type="submit">ログイン</button>
    </form>
</div>

</body>
</html>