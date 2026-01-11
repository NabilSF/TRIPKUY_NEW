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
            primary: '#2aa090',
            primaryDark: '#1f7a6e',
        }
    },
  },
  plugins: [],
}