import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue'; //add this line
import Icons from 'unplugin-icons/vite';


export default defineConfig({
    plugins: [
        
        laravel({
            input: ['resources/js/app.js','resources/css/app.css'],
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
        Icons({
            autoInstall: true, // Automatically installs the icon packages when needed
          }),
    ]
});
