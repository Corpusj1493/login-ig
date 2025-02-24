<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificación OTP</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex items-center justify-center min-h-screen bg-gray-100">

    <form method="POST" action="{{ route('verify.otp.post') }}" class="bg-white p-6 rounded-lg shadow-lg w-full max-w-sm">
        @csrf

        <h2 class="text-2xl font-bold text-gray-700 text-center mb-4">Verificación OTP</h2>
        @if ($errors->has('otp'))
            <div class="bg-red-100 text-red-700 px-4 py-2 mb-4 rounded-lg border border-red-400">
                {{ $errors->first('otp') }}
            </div>
        @endif
        <div class="mb-4">
            <label for="otp" class="block text-gray-600 text-sm font-medium mb-1">Código OTP</label>
            <input 
                type="number" 
                name="otp" 
                id="otp" 
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none text-center text-lg"
                placeholder="Ingresa tu código"
                required 
            >
        </div>

        <button type="submit" class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 rounded-lg transition duration-200">
            Verificar
        </button>
    </form>

</body>
</html>

