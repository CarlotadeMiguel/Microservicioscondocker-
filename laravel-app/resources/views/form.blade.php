<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Formulario de Contacto</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f7f7f7;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 420px;
            margin: 40px auto;
            background: #fff;
            padding: 32px 24px 24px 24px;
            border-radius: 10px;
            box-shadow: 0 2px 16px rgba(0,0,0,0.1);
        }
        h2 {
            margin-bottom: 18px;
            color: #333;
            text-align: center;
        }
        label {
            display: block;
            margin-bottom: 6px;
            color: #555;
        }
        input[type="text"],
        input[type="email"],
        textarea {
            width: 100%;
            padding: 8px 10px;
            margin-bottom: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 1em;
            box-sizing: border-box;
        }
        textarea {
            min-height: 90px;
            resize: vertical;
        }
        .btn-submit {
            background: #007bff;
            color: #fff;
            border: none;
            padding: 10px 0;
            width: 100%;
            border-radius: 4px;
            font-size: 1.1em;
            cursor: pointer;
            transition: background 0.2s;
        }
        .btn-submit:hover {
            background: #0056b3;
        }
        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 16px;
        }
        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 16px;
        }
        ul {
            margin: 0 0 0 18px;
            padding: 0;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Formulario de Contacto</h2>

    @if(session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert-error">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="/submit" autocomplete="off">
        @csrf
        <label for="name">Nombre:</label>
        <input type="text" id="name" name="name" value="{{ old('name') }}" required>

        <label for="email">Correo electrónico:</label>
        <input type="email" id="email" name="email" value="{{ old('email') }}" required>

        <label for="message">Mensaje:</label>
        <textarea id="message" name="message" required>{{ old('message') }}</textarea>

        <button type="submit" class="btn-submit">Enviar</button>
    </form>
</div>
</body>
</html>
