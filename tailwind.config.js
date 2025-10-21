/* eslint-disable linebreak-style */
/* eslint-disable array-bracket-spacing */
/* eslint-disable space-in-parens */
/* eslint-disable indent */
/* eslint-disable linebreak-style */

/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './*.php', // All root PHP files
    './template-parts/**/*.php', // All PHP in template-parts
    './src-assets/js/**/*.js', // All theme JS files
    './src-blocks/**/*.js', // All block JS/React files
  ],
  theme: {
    extend: {},
  },
  plugins: [],
};
