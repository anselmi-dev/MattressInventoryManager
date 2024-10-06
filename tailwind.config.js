import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
export default {
    presets: [
        require("./vendor/wireui/wireui/tailwind.config.js")
    ],
    plugins: [
        forms,
        typography,
        require('@tailwindcss/line-clamp'),
    ],
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        "./vendor/wireui/wireui/src/*.php",
        "./vendor/wireui/wireui/ts/**/*.ts",
        "./vendor/wireui/wireui/src/WireUi/**/*.php",
        "./vendor/wireui/wireui/src/Components/**/*.php",
    ],

    theme: {
        screens: {
            'xs':'440px',
            ...defaultTheme.screens,
        },
        extend: {
            fontSize: {
                xxs: '0.6rem',
            },
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            animation: {
                'infinite-scroll': 'infinite-scroll 25s linear infinite',
            },
            keyframes: {
                'infinite-scroll': {
                    from: { transform: 'translateX(0)' },
                    to: { transform: 'translateX(-100%)' },
                }
            },
            zIndex: {
                '1': '1',
                '2': '2',
                '3': '3',
                '4': '4',
                '5': '5',
                '50': '50',
                '100': '100',
            },
            colors: {
                primary: {
                    '50': '#f4faf3',
                    '100': '#e4f5e3',
                    '200': '#caeac8',
                    '300': '#86cd82',
                    '400': '#6fbd6b',
                    '500': '#57B797',
                    '600': '#287961',
                    '700': '#2f682d',
                    '800': '#295427',
                    '900': '#234522',
                    '950': '#0e250e',
                },
                secondary: {
                    dark: '#333333',
                    hover: '#dcd9cc',
                    default: '#f2f1ec',
                    '50': '#f8f7f4',
                    '100': '#f2f1ec',
                    '200': '#dcd9cc',
                    '300': '#c5c0ac',
                    '400': '#ada38a',
                    '500': '#9d8f72',
                    '600': '#907f66',
                    '700': '#786956',
                    '800': '#635749',
                    '900': '#51473d',
                    '950': '#2b251f',
                },
                app: {
                    'primary': '#57B797',
                    'hover': '#287961',
                    'default': '#57b797',
                    '50': '#f3faf8',
                    '100': '#d5f2e6',
                    '200': '#abe4cd',
                    '300': '#7aceb0',
                    '400': '#57b797',
                    '500': '#349878',
                    '600': '#287961',
                    '700': '#236250',
                    '800': '#204f42',
                    '900': '#1f4239',
                    '950': '#0c2720',
                }
            },
            flex: {
                '2': '2 2 0%',
                '3': '3 3 0%',
                '4': '4 4 0%',
                '9': '9 9 0%',
            }
        },
    },
};
