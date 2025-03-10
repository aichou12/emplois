<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modification du mot de passe</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">
    
    <div class="container mx-auto flex justify-center items-center h-screen">
        <div class="bg-white shadow-md rounded-md p-6 w-full md:w-1/2">
            <h2 class="text-lg font-semibold text-gray-800 text-center mb-4">Modifier votre mot de passe</h2>
            
         <form action="{{ route('change.password') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label for="current_password" class="block text-sm font-medium text-gray-700">Mot de passe actuel</label>
                    <input type="password" id="current_password" name="current_password"  placeholder="Mot de passe actuel"  required
                        class="block mt-1 w-full p-4 border border-gray-300 rounded-lg">
                </div>
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Nouveau mot de passe</label>
                    <input type="password" id="new_password" name="new_password" placeholder="Nouveau mot de passe" required
                        class="block mt-1 w-full p-4 border border-gray-300 rounded-lg">
                </div>
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmez le mot de passe</label>
                    <input type="password" id="new_password_confirmation" name="new_password_confirmation" placeholder="confirmez le nouveau mot de passe" required
                        class="block mt-1 w-full p-4 border border-gray-300 rounded-lg">
                </div>
                <button type="submit" class="w-full py-3 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                Changer le mot de passe
                </button>
            </form>
        
        </div>
    </div>
</body>
<script>
    // Afficher le popup si le message de succès est présent
    @if(session('success'))
        var myModal = new bootstrap.Modal(document.getElementById('successModal'), {
            keyboard: false
        });
        myModal.show();
    @endif
</script>
</html>
