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
            
            <form id="passwordForm" action="{{ route('change.password') }}" method="POST" class="space-y-4">
                @csrf
                
                <!-- Mot de passe actuel -->
                <div>
                    <label for="current_password" class="block text-sm font-medium text-gray-700">Mot de passe actuel</label>
                    <input type="password" id="current_password" name="current_password" placeholder="Mot de passe actuel" required
                        class="block mt-1 w-full p-4 border border-gray-300 rounded-lg">
                    <p id="error_current_password" class="text-red-500 text-sm mt-1"></p>
                </div>

                <!-- Nouveau mot de passe -->
                <div>
                    <label for="new_password" class="block text-sm font-medium text-gray-700">Nouveau mot de passe</label>
                    <input type="password" id="new_password" name="new_password" placeholder="Nouveau mot de passe" required
                        class="block mt-1 w-full p-4 border border-gray-300 rounded-lg">
                    <p id="error_new_password" class="text-red-500 text-sm mt-1"></p>
                </div>

                <!-- Confirmation du mot de passe -->
                <div>
                    <label for="new_password_confirmation" class="block text-sm font-medium text-gray-700">Confirmez le mot de passe</label>
                    <input type="password" id="new_password_confirmation" name="new_password_confirmation" placeholder="Confirmez le nouveau mot de passe" required
                        class="block mt-1 w-full p-4 border border-gray-300 rounded-lg">
                    <p id="error_new_password_confirmation" class="text-red-500 text-sm mt-1"></p>
                </div>

                <!-- Bouton de soumission -->
                <button type="submit" class="w-full py-3 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                    Changer le mot de passe
                </button>
            </form>
        </div>
    </div>

<script>
    document.getElementById('passwordForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Empêcher l'envoi du formulaire si les validations échouent

        let currentPassword = document.getElementById('current_password').value;
        let newPassword = document.getElementById('new_password').value;
        let confirmPassword = document.getElementById('new_password_confirmation').value;

        // Effacer les anciens messages d'erreur
        document.getElementById('error_current_password').textContent = "";
        document.getElementById('error_new_password').textContent = "";
        document.getElementById('error_new_password_confirmation').textContent = "";

        let valid = true;

        // Vérifier si les champs sont remplis
        if (!currentPassword) {
            document.getElementById('error_current_password').textContent = "Le mot de passe actuel est requis.";
            valid = false;
        }

        // Vérifier la longueur du nouveau mot de passe
        if (newPassword.length < 8) {
            document.getElementById('error_new_password').textContent = "Le mot de passe doit contenir au moins 8 caractères.";
            valid = false;
        }

        // Vérifier la confirmation du mot de passe
        if (newPassword !== confirmPassword) {
            document.getElementById('error_new_password_confirmation').textContent = "La confirmation du mot de passe ne correspond pas.";
            valid = false;
        }

        // Soumettre le formulaire si tout est correct
        if (valid) {
            this.submit();
        }
    });

    // Afficher les erreurs de validation Laravel sous les champs
    @if($errors->any())
        let errors = {!! json_encode($errors->toArray()) !!};
        if (errors.current_password) {
            document.getElementById('error_current_password').textContent = errors.current_password[0];
        }
        if (errors.new_password) {
            document.getElementById('error_new_password').textContent = errors.new_password[0];
        }
        if (errors.new_password_confirmation) {
            document.getElementById('error_new_password_confirmation').textContent = errors.new_password_confirmation[0];
        }
    @endif

    // Afficher un message de succès
    @if(session('success'))
        alert("{{ session('success') }}");
    @endif
</script>

</body>
</html>
