import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    server: {
        host: true,
        port: 5173,
        strictPort: true,
    },
    plugins: [
        laravel({
            input: [
                "resources/css/app.css",
                "resources/js/app.js",
                "resources/js/app_auth.js",
                "resources/js/role_permissions.js",
            ],
            refresh: true,
        }),
    ],
});
