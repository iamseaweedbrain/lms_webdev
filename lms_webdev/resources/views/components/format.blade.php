<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'LearnFinity' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- fonts -->
    <<link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    
    <!-- para sa icons iconify na since ayun din gamit sa figma or dagdag kayo here -->
    <script src="https://code.iconify.design/iconify-icon/2.1.0/iconify-icon.min.js"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        pastel: {
                            pink: '#FFD6EA',
                            yellow: '#FFE6A6',
                            blue: '#D1E4E2',
                            purple: '#D7CAE8',
                        },
                        main: '#000000',
                        page: '#FAF8F5',
                    },
                    fontFamily: {
                        outfit: ['Outfit', 'sans-serif'],
                        poppins: ['Poppins', 'sans-serif'],
                    },
                    boxShadow: {
                        'pastel-pink': '4px 4px 0 #FFD6EA',
                        'pastel-yellow': '4px 4px 0 #FFE6A6',
                        'pastel-blue': '4px 4px 0 #D1E4E2',
                        'pastel-purple': '4px 4px 0 #D7CAE8',
                        'main': '4px 4px 0 #000000',
                    },
                },
            },
        };
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#FCFAF8] text-gray-900 flex flex-col min-h-screen">
    {{ $slot }}
</body>
</html>
