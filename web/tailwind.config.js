/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./src/**/*.{js,jsx,ts,tsx}",
  ],
  theme: {
    extend: {
      colors: {
        primary: '#1D1F22',
        secondary: '#2d3748',
        tertiary: '#4a5568',
        'primary-bg': '#ffffff',
        'secondary-bg': '#5ECE7B',
        'inactive-bg' : '#FBFBFB',
        'grey-bg': '#DBDDDD',
      },
      fontFamily: {
        'primary': ['Inter', 'sans-serif'],
        'secondary': ['Avenir', 'Helvetica', 'Arial', 'sans-serif'],
      },
    },
  },
  plugins: [],
};

