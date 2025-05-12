import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],
    
    // Enable dark mode with class strategy
    darkMode: 'class',

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                // Custom color palette for light and dark mode
                'primary': {
                    50: '#f0f5ff',
                    100: '#e0ebff',
                    200: '#c0d7ff',
                    300: '#a1c3ff',
                    400: '#819fff',
                    500: '#6272f4',
                    600: '#5147e5',
                    700: '#443cc6',
                    800: '#3a3494',
                    900: '#322d78',
                },
                'secondary': {
                    50: '#f8f9fa',
                    100: '#f1f3f5',
                    200: '#e9ecef',
                    300: '#dee2e6',
                    400: '#ced4da',
                    500: '#adb5bd',
                    600: '#868e96',
                    700: '#495057',
                    800: '#343a40',
                    900: '#212529',
                },
                'code-bg': {
                    light: '#f8f9fa',
                    dark: '#1e1e3f'
                }
            },
            keyframes: {
                float: {
                    '0%, 100%': { transform: 'translateY(0)' },
                    '50%': { transform: 'translateY(-10px)' },
                },
                pulse: {
                    '0%, 100%': { opacity: 1 },
                    '50%': { opacity: 0.5 },
                }
            },
            animation: {
                float: 'float 3s ease-in-out infinite',
                pulse: 'pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite'
            },
            boxShadow: {
                'dark': '0 4px 6px -1px rgba(0, 0, 0, 0.4), 0 2px 4px -1px rgba(0, 0, 0, 0.3)',
                'dark-lg': '0 10px 15px -3px rgba(0, 0, 0, 0.5), 0 4px 6px -2px rgba(0, 0, 0, 0.4)',
            }
        },
    },

    plugins: [forms],
};