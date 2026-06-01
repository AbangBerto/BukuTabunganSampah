<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bank Sampah Ngembrinagan</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        .btn-hijau {
            background-color: #059669 !important; /* Hijau Solid (Green 600) */
            color: #ffffff !important;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            transition: all 0.2s ease;
        }
        .btn-hijau:hover {
            background-color: #047857 !important; /* Hijau Lebih Tua */
        }
        .btn-merah {
            background-color: #dc2626 !important; /* Merah Solid (Red 600) */
            color: #ffffff !important;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            transition: all 0.2s ease;
        }
        .btn-merah:hover {
            background-color: #b91c1c !important;
        }
        .btn-gelap {
            background-color: #1f2937 !important; /* Abu-abu Gelap (Gray 800) */
            color: #ffffff !important;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            transition: all 0.2s ease;
        }
        .btn-gelap:hover {
            background-color: #111827 !important;
        }
        .btn-abu {
            background-color: #f3f4f6 !important;
            color: #374151 !important;
            border: 1px solid #d1d5db;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
        }
        button:active, a:active { transform: scale(0.98); }
    </style>
</head>
<body class="bg-gray-100 font-sans antialiased text-gray-800">

    <div class="max-w-md mx-auto min-h-screen bg-white shadow-2xl flex flex-col relative overflow-hidden">
        
        <header class="bg-gradient-to-r from-green-600 to-green-700 p-5 text-white text-center shadow-md relative z-10">
            <h1 class="text-xl font-extrabold tracking-wide"><i class="fa-solid fa-leaf mr-2"></i>Bank Sampah</h1>
            <p class="text-[11px] text-green-100 mt-1 font-medium tracking-wider uppercase">Desa Ngembrinagan</p>
        </header>

        <main class="flex-1 p-5 relative z-10">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded-xl mb-5 shadow-sm flex items-center">
                    <i class="fa-solid fa-circle-check text-lg mr-3 text-green-600"></i>
                    <span class="text-sm font-semibold">{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-800 px-4 py-3 rounded-xl mb-5 shadow-sm flex items-center">
                    <i class="fa-solid fa-triangle-exclamation text-lg mr-3 text-red-600"></i>
                    <span class="text-sm font-semibold">{{ session('error') }}</span>
                </div>
            @endif

            @yield('content')
        </main>

        <footer class="p-5 bg-gray-50 border-t border-gray-200 text-center text-xs text-gray-400 font-medium">
            &copy; 2026 Desa Ngembrinagan.<br>Dibuat untuk kesejahteraan warga.
        </footer>
    </div>

</body>
</html>