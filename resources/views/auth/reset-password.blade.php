<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réinitialisation du mot de passe</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-gray-100 font-sans">
    <div class="container mx-auto flex justify-center items-center h-screen">
        <div class="bg-white shadow-md rounded-md p-6 w-full md:w-1/2">
            <h2 class="text-lg font-semibold text-gray-800 text-center mb-4">Réinitialiser votre mot de passe</h2>
            @if ($errors->any())
                <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ route('password.update') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Adresse email</label>
                    <input type="email" id="email" name="email" value="{{ $email ?? old('email') }}" required
                        class="block mt-1 w-full p-4 border border-gray-300 rounded-lg bg-gray-100 cursor-not-allowed">
                </div>
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Nouveau mot de passe</label>
                    <input type="password" id="password" name="password" placeholder="Nouveau mot de passe" required
                        class="block mt-1 w-full p-4 border border-gray-300 rounded-lg" onkeyup="validatePassword()">
                    <p id="passwordMessage" class="text-sm text-gray-600 mt-1"></p>
                </div>
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmez le mot de passe</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Confirmez votre mot de passe" required
                        class="block mt-1 w-full p-4 border border-gray-300 rounded-lg" onkeyup="checkMatch()">
                    <p id="matchMessage" class="text-sm mt-1"></p>
                </div>
                <button type="submit" class="w-full py-3 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                    Réinitialiser le mot de passe
                </button>
            </form>
        </div>
    </div>
      <!-- Script de validation -->
      <script>
        function validatePassword() {
            const password = document.getElementById('password').value;
            const message = document.getElementById('passwordMessage');
            const submitBtn = document.getElementById('submitBtn');

            const regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/;
            if (regex.test(password)) {
                message.textContent = "Mot de passe valide ✅";
                message.classList.remove("text-red-600");
                message.classList.add("text-green-600");
            } else {
                message.textContent = "Le mot de passe doit contenir au moins 8 caractères, une majuscule, une minuscule et un chiffre ❌";
                message.classList.remove("text-green-600");
                message.classList.add("text-red-600");
            }
            checkMatch();
        }

        function checkMatch() {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('password_confirmation').value;
            const message = document.getElementById('matchMessage');
            const submitBtn = document.getElementById('submitBtn');

            if (password === confirmPassword && password.length > 0) {
                message.textContent = "Les mots de passe correspondent ✅";
                message.classList.remove("text-red-600");
                message.classList.add("text-green-600");
                submitBtn.disabled = false;
            } else {
                message.textContent = "Les mots de passe ne correspondent pas ❌";
                message.classList.remove("text-green-600");
                message.classList.add("text-red-600");
                submitBtn.disabled = true;
            }
        }

        function validateForm() {
            const passwordMessage = document.getElementById('passwordMessage').classList.contains("text-green-600");
            const matchMessage = document.getElementById('matchMessage').classList.contains("text-green-600");

            if (!passwordMessage || !matchMessage) {
                return false;
            }
            return true;
        }

        @if(session('success'))
        Swal.fire({
            title: "Mot de passe mis à jour !",
            text: "{{ session('success') }}",
            icon: "success",
            confirmButtonText: "OK"
        });
        @endif
    </script>
    
</body>
</html>
