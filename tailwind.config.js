/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            colors: {
                accent: "#D6FF00",
                highlight: "#ff00ff",
            },
            fontFamily: {
                sans: ["Uniform", "sans-serif"],
            }
        },
    },
    plugins: [],
}

