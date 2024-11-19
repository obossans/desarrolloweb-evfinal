<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" class="style">
    <script type="text/javascript" src="{{ asset('js/script.js') }}" ></script>
</head>
<body>
<div class="login-page">
    <h1>Inicio de Sesión</h1>
    <!--- errores ---->
    @if ($errors->any())
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
    @endif

  <div class="form">
    <form class="login-form" action="{{ Route('usuario.validar') }}" method="POST">
    @csrf
      <input type="text" name="email" value="scabezas@ciisa.cl" />
      <input type="password" name="password" value="hola" />
      <button type="submit">Ingresar</button>
     </form>
  </div>
</div>
</body>
</html>

