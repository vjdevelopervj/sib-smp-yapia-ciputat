<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Inventory System</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="icon" href="{{ asset('logoyayasan.png') }}" type="image/x-icon">
    <style>
        .modern-input {
            opacity: 0;
            transform: translateY(10px);
        }

        .modern-input.opacity-100 {
            opacity: 1;
            transform: translateY(0);
        }

        .card-hover {
            transition: all 0.3s ease;
        }

        .card-hover:hover {
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            transform: scale(1.05);
        }

        /* Animated gradient background */
        .animate-gradient-bg {
            background: linear-gradient(45deg, #0c4a6e, #D4FF54, #DFD966, #EAB378, #F48C8A, #FF669C);
            background-size: 400%;
            animation: gradientShift 15s ease infinite;
        }

        @keyframes gradientShift {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        /* Ensure login container stands out */
        .login-container {
            background: rgba(19, 25, 36, 0.85);
            backdrop-filter: blur(10px);
        }
    </style>
</head>

<body class="relative bg-[#10151D] overflow-hidden">
    <img src="{{ asset('bg.png') }}" alt="bg"
        class="absolute inset-0 w-[960px] h-full z-[1] object-cover opacity-70">
    <img src="{{ asset('bg.png') }}" alt="bg"
        class="absolute right-0 top-0 w-[960px] h-full z-[1] object-cover opacity-70">
    <div class="absolute inset-0 bg-gradient-to-br from-indigo-900 via-[#10151D] to-cyan-900 animate-gradient-bg"></div>
    <canvas id="particle-canvas" class="absolute inset-0"></canvas>
    <div class="min-h-screen flex items-center justify-center p-4 relative z-10">
        <div
            class="bg-gradient-to-tl from-sky-950 to-[#131924] login-container rounded-2xl p-8 max-w-md w-full card-hover transition-all duration-300 shadow-md">
            <div class="text-center mb-8">
                <div class="flex justify-center mb-4">
                    <img class="w-20 h-20" src="{{ asset('logoyayasan.png') }}" alt="logo-yayasan">
                </div>
                <h1 class="text-3xl font-bold text-white mb-2">
                    Inventory <span class="text-fuchsia-300">System</span>
                </h1>
                <h3 class="text-white text-lg font-bold">SMP Yapia Ciputat</h3>
                <p class="text-gray-300">Silakan masuk ke akun Anda</p>
            </div>

            @if ($errors->any())
                <div class="mb-4 p-3 bg-red-100 text-red-700 rounded-lg">
                    {{ $errors->first() }}
                </div>
            @endif

            <form class="space-y-6" method="POST" action="{{ route('login') }}">
                @csrf
                <div>
                    <label for="username" class="block text-sm font-medium text-gray-300 mb-1">
                        Username
                    </label>
                    <div class="relative">
                        <div class="absolute z-10 inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-user text-fuchsia-300"></i>
                        </div>
                        <input id="username" name="username" type="text" autocomplete="username" required
                            class="bg-[#131924] text-white modern-input opacity-0 block w-full pl-10 pr-3 py-3 border border-gray-500 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300"
                            placeholder="username" value="{{ old('username') }}" />
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-300 mb-1">
                        Password
                    </label>
                    <div class="relative">
                        <div class="absolute z-10 inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-fuchsia-300"></i>
                        </div>
                        <input id="password" name="password" type="password" autocomplete="current-password" required
                            class="bg-[#131924] text-white modern-input opacity-0 block w-full pl-10 pr-3 py-3 border border-gray-500 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300"
                            placeholder="••••••••" />
                        <button type="button"
                            class="absolute inset-y-0 right-0 pr-3 flex items-center toggle-password">
                            <i class="fas fa-eye-slash text-gray-400 hover:text-gray-600"></i>
                        </button>
                    </div>
                </div>

                <div>
                    <button type="submit"
                        class="btn-primary w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-sm text-sm font-medium text-white bg-fuchsia-500 hover:bg-fuchsia-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-300 hover:shadow-md">
                        Masuk
                        <i class="fas fa-arrow-right ml-2 mt-0.5"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/particles.js/2.0.0/particles.min.js"></script>
    <script>
        // Animation for form elements
        document.addEventListener('DOMContentLoaded', function() {
            const formElements = document.querySelectorAll('.modern-input');
            formElements.forEach((element, index) => {
                element.style.transition = `all 0.3s ease ${index * 0.1}s`;
                element.classList.add('opacity-100');
            });

            // Hover effect for card
            const card = document.querySelector('.card-hover');
            if (card) {
                card.addEventListener('mouseenter', () => {
                    card.classList.add('shadow-lg', 'transform', 'scale-105');
                });
                card.addEventListener('mouseleave', () => {
                    card.classList.remove('shadow-lg', 'transform', 'scale-105');
                });
            }

            // Toggle password visibility
            document.querySelectorAll('.toggle-password').forEach(button => {
                button.addEventListener('click', function() {
                    const passwordInput = this.parentElement.querySelector('input');
                    const icon = this.querySelector('i');

                    if (passwordInput.type === 'password') {
                        passwordInput.type = 'text';
                        icon.classList.remove('fa-eye-slash');
                        icon.classList.add('fa-eye');
                    } else {
                        passwordInput.type = 'password';
                        icon.classList.remove('fa-eye');
                        icon.classList.add('fa-eye-slash');
                    }
                });
            });

            // Initialize Particles.js
            particlesJS('particle-canvas', {
                particles: {
                    number: {
                        value: 50,
                        density: {
                            enable: true,
                            value_area: 800
                        }
                    },
                    color: {
                        value: '#ffffff'
                    },
                    shape: {
                        type: 'circle'
                    },
                    opacity: {
                        value: 0.4,
                        random: true
                    },
                    size: {
                        value: 3,
                        random: true
                    },
                    line_linked: {
                        enable: false
                    },
                    move: {
                        enable: true,
                        speed: 1,
                        direction: 'none',
                        random: true,
                        out_mode: 'out'
                    }
                },
                interactivity: {
                    detect_on: 'canvas',
                    events: {
                        onhover: {
                            enable: true,
                            mode: 'repulse'
                        },
                        onclick: {
                            enable: true,
                            mode: 'push'
                        },
                        resize: true
                    }
                },
                retina_detect: true
            });
        });
    </script>
</body>

</html>
