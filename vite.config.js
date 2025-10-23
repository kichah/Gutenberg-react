/* eslint-disable linebreak-style */
/* eslint-disable array-bracket-spacing */
/* eslint-disable space-in-parens */
/* eslint-disable indent */
/* eslint-disable linebreak-style */
import { defineConfig } from 'vite';
import react from '@vitejs/plugin-react';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
  plugins: [
    react(), // For React components (even in blocks)
    tailwindcss(),
  ],

  // The public directory (relative to root) - files here are copied to dist
  publicDir: 'src-assets/public',

  build: {
    // Our output directory (relative to root)
    outDir: 'dist',
    // We want to see the assets in a /dist/ folder
    assetsDir: '',
    // Clear the outDir on build
    emptyOutDir: true,

    // Generate a manifest.json file for a backend integration
    manifest: true,

    // Our entry points
    rollupOptions: {
      input: {
        main: 'src-assets/js/main.js', // Main JS
        style: 'src-assets/css/main.css', // Main CSS
        editor: './assets/css/editor.css', // Add this
      },
    },
  },

  // Vite development server config
  server: {
    host: true,
    // We are calling Vite from PHP, so we need CORS
    cors: true,

    // Where to serve static assets from
    origin: 'http://localhost:5173',

    // The port to run the dev server on
    port: 5173,

    // Enable strict port - if 5173 is in use, exit
    strictPort: true,
  },
});
