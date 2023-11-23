/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./App/**/*.html",
    "./App/**/*.php",
    "./node_modules/flowbite/**/*.js"
  ],
  theme: {
    extend: {
      colors: {
        button: "#3d7ca7",
        background: "#4180ab",
        customBlue: '#2d71e6',
        customDarkBlue: '#1c4a9e',
      },
    },
  },
  plugins: [
    require('flowbite/plugin')
  ],
}
