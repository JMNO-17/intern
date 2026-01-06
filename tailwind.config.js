/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
        './node_modules/flowbite/**/*.js',
        './node_modules/@tailwindcss/forms/**/*.js',
    ],
    theme: {
        extend: {
            fontFamily: {
                myriad: ['MYRIADPRO-REGULAR', 'sans-serif'],
            },
              maxWidth: {
                '8xl': '1440px',
            }
        },
    },
    plugins: [
        require('@tailwindcss/forms'),
        require('flowbite/plugin'),
    ],
};
