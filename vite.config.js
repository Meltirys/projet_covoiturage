import { defineConfig } from 'vite'
import tailwindcss from '@tailwindcss/vite'

export default defineConfig({
    plugins: [tailwindcss()],
    publicDir: false,
    css: {
        preprocessorOptions: {},
    },
    build: {
        outDir: 'public/css',
        emptyOutDir: false,
        rollupOptions: {
            input: 'Ressources/css/style.css',
            output: {
                assetFileNames: '[name][extname]',
            },
        },
    },
})
