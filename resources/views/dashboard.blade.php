<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
</head>
<body>
  <h1>Dashboard</h1>
  {{ Auth::user() }}
  @guest
    <a href="{{ route('auth.redirect') }}">Login</a>
  @endguest
  @auth
    <form action="{{ route('auth.logout') }}" method="POST">
      @csrf
      <button type="submit">Logout</button>
    </form>
  @endauth
</body>
</html>
