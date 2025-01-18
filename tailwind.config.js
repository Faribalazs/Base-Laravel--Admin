const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    purge: ['./storage/framework/views/*.php', './resources/views/**/*.blade.php'],

    theme: {
        colors: {
              'main-color' : '#0d2c5a',
              'secondary-color' : '#e8772e',
              'red' : '#ac1902',
              'white' : '#ffffff',
              'grey' : '#6b7280',
              'border-grey': '#adb5bd',
              'black': '#000',
            },
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
        screens: {
            'xs': '400px',
            'sm': '640px',
            'md': '768px',
            'lg': '1024px',
            'xl': '1280px',
            '2xl': '1536px',
            }
        },
    },

    variants: {
        extend: {
            opacity: ['disabled'],
        },
    },

    plugins: [require('@tailwindcss/forms')],
};
