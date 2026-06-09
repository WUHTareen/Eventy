import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: {
                    DEFAULT: '#0A3A7A',
                    50: '#f0f4f9',
                    100: '#e1e9f3',
                    200: '#c3d3e7',
                    300: '#a5bddb',
                    400: '#6991c3',
                    500: '#0A3A7A',
                    600: '#09346e',
                    700: '#082b5c',
                    800: '#062349',
                    900: '#051b3b',
                    950: '#030f21',
                },
                secondary: {
                    DEFAULT: '#ED1C24',
                    50: '#fef3f3',
                    100: '#fee7e7',
                    200: '#fcc3c5',
                    300: '#fa9fa3',
                    400: '#f6575e',
                    500: '#ED1C24',
                    600: '#d51920',
                    700: '#b2151b',
                    800: '#8e1115',
                    900: '#750e11',
                    950: '#4a090b',
                },
                premium: {
                    gold: '#FFD700',
                    platinum: '#E5E4E2',
                    rose: '#FF007F',
                    sapphire: '#0F52BA',
                    emerald: '#50C878',
                    onyx: '#353839',
                    glass: 'rgba(255,255,255,0.15)',
                },
                gradient1: 'linear-gradient(90deg, #ff8a00 0%, #e52e71 100%)',
                gradient2: 'linear-gradient(90deg, #43cea2 0%, #185a9d 100%)',
            },
            boxShadow: {
                premium: '0 8px 32px 0 rgba(31, 38, 135, 0.37)',
                glass: '0 4px 30px rgba(0, 0, 0, 0.1)',
                gold: '0 2px 8px 0 #FFD70044',
            },
            backgroundImage: {
                'gradient-gold': 'linear-gradient(90deg, #FFD700 0%, #FFB300 100%)',
                'gradient-rose': 'linear-gradient(90deg, #FF007F 0%, #FF8A00 100%)',
                'gradient-sapphire': 'linear-gradient(90deg, #0F52BA 0%, #43cea2 100%)',
                'glass': 'linear-gradient(135deg, rgba(255,255,255,0.15) 0%, rgba(255,255,255,0.05) 100%)',
            },
            keyframes: {
                'fade-in': {
                    '0%': { opacity: '0' },
                    '100%': { opacity: '1' },
                },
                'slide-up': {
                    '0%': { transform: 'translateY(40px)', opacity: '0' },
                    '100%': { transform: 'translateY(0)', opacity: '1' },
                },
                'glass-float': {
                    '0%, 100%': { filter: 'blur(0px)' },
                    '50%': { filter: 'blur(2px)' },
                },
            },
            animation: {
                'fade-in': 'fade-in 0.8s ease-out',
                'slide-up': 'slide-up 0.7s cubic-bezier(0.4,0,0.2,1)',
                'glass-float': 'glass-float 3s ease-in-out infinite',
            },
            typography: {
                DEFAULT: {
                    css: {
                        color: '#353839',
                        h1: { fontWeight: '800', fontSize: '2.5rem', letterSpacing: '-.02em' },
                        h2: { fontWeight: '700', fontSize: '2rem' },
                        h3: { fontWeight: '600', fontSize: '1.5rem' },
                        h4: { fontWeight: '600', fontSize: '1.25rem' },
                        p: { fontSize: '1.1rem', lineHeight: '1.7' },
                    },
                },
            },
            spacing: {
                'xs': '0.5rem',
                'sm': '1rem',
                'md': '2rem',
                'lg': '3rem',
                'xl': '4rem',
                '2xl': '6rem',
            },
        },
    },

    plugins: [forms],
};
