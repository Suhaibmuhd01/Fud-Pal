/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    './*.php',
    './pages/**/*.php',
    './api/**/*.php',
    './assets/js/**/*.js',
    './assets/css/**/*.css',
    './*.html',
  ],
  theme: {
    extend: {
      colors: {
        primary: '#10B981',
        secondary: '#D97706',
        danger: '#EF4444',
        dark: {
          primary: '#065F46',
          secondary: '#B45309',
        },
      },
      fontFamily: {
        poppins: ['Poppins', 'sans-serif'],
      },
    },
  },
  plugins: [
    require('@tailwindcss/forms'),
    require('@tailwindcss/typography'),
    require('@tailwindcss/aspect-ratio'),
    require('@tailwindcss/line-clamp'),
  ],
}

