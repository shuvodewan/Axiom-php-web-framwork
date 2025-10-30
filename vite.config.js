import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'
export default defineConfig({
  plugins: [
    laravel({
      input: [
        'project/templates/assets/css/app.css',
        'project/templates/assets/js/app.js',
        'project/templates/assets/css/admin.css',
        'project/templates/assets/js/admin.js'
      ],
      refresh: true,
    })
  ],
})