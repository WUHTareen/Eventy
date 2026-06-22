<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Eventy') }} | Professional Infrastructure</title>
    
    <!-- Premium Font Integration -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@200;300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            DEFAULT: '#0A3A7A',
                            50: '#f0f4f9', 100: '#e1e9f3', 200: '#c3d3e7', 300: '#a5bddb',
                            400: '#6991c3', 500: '#0A3A7A', 600: '#09346e', 700: '#082b5c',
                            800: '#062349', 900: '#051b3b', 950: '#030f21',
                        },
                        secondary: {
                            DEFAULT: '#ED1C24',
                            50: '#fef3f3', 100: '#fee7e7', 200: '#fcc3c5', 300: '#fa9fa3',
                            400: '#f6575e', 500: '#ED1C24', 600: '#d51920', 700: '#b2151b',
                            800: '#8e1115', 900: '#750e11', 950: '#4a090b',
                        },
                    },
                },
            },
        };
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #0f172a;
            background-image:
                radial-gradient(at 0% 0%, hsla(222,47%,20%,1) 0, transparent 50%),
                radial-gradient(at 50% 0%, hsla(223,47%,16%,1) 0, transparent 50%),
                radial-gradient(at 100% 0%, hsla(222,47%,20%,1) 0, transparent 50%);
            margin: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }
        [x-cloak] { display: none !important; }
        
        .master-container {
            width: 100%;
            max-width: 1000px;
            background: #0f172a; /* Deep Navy */
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 1.5rem;
            display: flex;
            overflow: hidden;
            box-shadow: 0 40px 80px -20px rgba(0, 0, 0, 0.6);
        }

        .left-panel {
            width: 40%;
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%); /* Navy Gradient */
            padding: 2.5rem;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            border-right: 1px solid rgba(255, 255, 255, 0.05);
            position: relative;
        }
        .left-panel::after {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: radial-gradient(circle at 20% 20%, rgba(237, 28, 36, 0.05) 0%, transparent 50%);
            pointer-events: none;
        }

        .right-panel {
            width: 60%;
            background: #0B1120;
            display: flex;
            flex-direction: column;
            padding: 2.5rem;
        }

        .input-dark {
            background-color: #0F172A !important;
            border: 1px solid #1E293B !important;
            color: #F8FAFC !important;
            padding: 0.75rem 1rem 0.75rem 2.75rem !important;
            border-radius: 0.6rem !important;
            width: 100% !important;
            font-size: 0.813rem !important;
            transition: all 0.3s ease;
        }

        .input-dark:-webkit-autofill {
            -webkit-box-shadow: 0 0 0px 1000px #0F172A inset !important;
            -webkit-text-fill-color: #F8FAFC !important;
        }

        .input-dark:focus {
            border-color: #ED1C24 !important;
            background-color: #1E293B !important;
            box-shadow: 0 0 0 3px rgba(237, 28, 36, 0.1) !important;
            outline: none !important;
        }

        .input-dark::placeholder {
            color: #94A3B8;
            opacity: 1;
        }

        .input-icon {
            color: #94A3B8; /* Brightened Icon */
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            font-size: 0.875rem;
            pointer-events: none;
        }
        .group:focus-within .input-icon {
            color: #ED1C24;
        }

        .label-text {
            color: #CBD5E1; /* Brightened from Slate-400 */
            font-size: 0.7rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            margin-bottom: 0.4rem;
            display: block;
        }

        .btn-primary {
            background: linear-gradient(to right, #ED1C24, #BE123C);
            color: #FFF;
            padding: 0.875rem;
            border-radius: 0.6rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            width: 100%;
            font-size: 0.813rem;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            box-shadow: 0 10px 15px -3px rgba(237, 28, 36, 0.2);
        }
        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 20px 25px -5px rgba(237, 28, 36, 0.3);
            filter: brightness(1.1);
        }

        @media (max-width: 900px) {
            .master-container { flex-direction: column; max-width: 500px; }
            .left-panel, .right-panel { width: 100%; padding: 2rem; }
            .left-panel { border-right: none; border-bottom: 1px solid rgba(255, 255, 255, 0.05); }
        }
    </style>

    {{-- Admin-managed header tracking / verification code (GSC, Analytics, Clarity, Meta Pixel, etc.) --}}
    @if($headerTrackingCode = \App\Models\SiteSetting::get('header_tracking_code'))
        {!! $headerTrackingCode !!}
    @endif
</head>
<body class="antialiased">
    <div class="master-container">
        <!-- Left Section -->
        <div class="left-panel">
            <div>
                <div class="mb-10">
                    <a href="/">
                        <img src="{{ asset('images/logo.png') }}" alt="Eventy" class="h-12 w-auto object-contain" />
                    </a>
                </div>
                
                <h1 class="text-3xl font-black text-white leading-tight">
                    Powering <br/>
                    <span class="text-[#ED1C24]">Elite</span> <br/>
                    Experiences.
                </h1>
                <p class="text-white text-sm mt-4 font-medium leading-relaxed"> <!-- Changed to White -->
                    Precision infrastructure for Pakistan's premier event management ecosystems.
                </p>
            </div>

            <div class="flex items-center gap-4 pt-6 border-t border-white/5">
                <div class="flex items-center gap-1.5 grayscale opacity-80 hover:grayscale-0 hover:opacity-100 transition-all duration-300">
                    <i class="fa-solid fa-circle-check text-green-500 text-[9px]"></i>
                    <span class="text-white text-[8.5px] font-black uppercase tracking-[0.1em]">99.9% Uptime</span>
                </div>
                <div class="w-px h-2.5 bg-white/10"></div>
                <div class="flex items-center gap-1.5 grayscale opacity-80 hover:grayscale-0 hover:opacity-100 transition-all duration-300">
                    <i class="fa-solid fa-shield-halved text-[#ED1C24] text-[9px]"></i>
                    <span class="text-white text-[8.5px] font-black uppercase tracking-[0.1em]">Global Security</span>
                </div>
            </div>
        </div>

        <!-- Right Section -->
        <div class="right-panel">
            {{ $slot }}
        </div>
    </div>

    @include('partials.toast')
</body>
</html>
