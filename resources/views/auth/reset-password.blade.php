<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réinitialisation du mot de passe</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">
    <div class="container mx-auto flex justify-center items-center h-screen">
        <div class="bg-white shadow-md rounded-md p-6 w-full md:w-1/2">
            <h2 class="text-lg font-semibold text-gray-800 text-center mb-4">Réinitialiser votre mot de passe</h2>
            <form action="{{ route('password.update') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Adresse email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required
                        class="block mt-1 w-full p-4 border border-gray-300 rounded-lg">
                </div>
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Nouveau mot de passe</label>
                    <input type="password" id="password" name="password" placeholder="Nouveau mot de passe" required
                        class="block mt-1 w-full p-4 border border-gray-300 rounded-lg">
                </div>
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmez le mot de passe</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Confirmez votre mot de passe" required
                        class="block mt-1 w-full p-4 border border-gray-300 rounded-lg">
                </div>
                <button type="submit" class="w-full py-3 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                    Réinitialiser le mot de passe
                </button>
            </form>
        </div>
    </div>
</body>
</html>
