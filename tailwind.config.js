/* eslint-disable linebreak-style */
/* eslint-disable array-bracket-spacing */
/* eslint-disable space-in-parens */
/* eslint-disable indent */
/* eslint-disable linebreak-style */

export default {
  content: [
    './**/*.php',
    './src-blocks/**/*.{js,jsx}',
    './src-assets/**/*.{js,jsx}',
  ],
  important: '.editor-styles-wrapper', // Increase specificity in editor
  theme: {
    extend: {},
  },
  plugins: [],
};
