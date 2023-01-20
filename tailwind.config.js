/** @type {import('tailwindcss').Config} */
module.exports = {
    darkMode: 'class',
    content: [
        "./resources/views/**/*.blade.php",
    ],
    theme: {
        extend: {
            container: {
                center: true,
                screens: {
                    sm: '1240px',
                    md: '1240px',
                    lg: '1240px',
                    xl: '1240px',
                    '2xl': '1240px',
                },
            },
            colors: {
                'discord': "#5865f2"
            }
        },
    },
    plugins: [],
}