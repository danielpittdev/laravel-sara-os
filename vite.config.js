import { defineConfig } from "vite"
import laravel from "laravel-vite-plugin"
import tailwindcss from "@tailwindcss/vite"
import fs from "fs"

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/css/app.css",
                "resources/js/app.js",
                "resources/js/request-manager.js",
                "resources/js/form-handler.js",
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
    define: {
        global: 'globalThis',
    },
    server: {
        host: "127.0.0.1",
        port: 5190,
        strictPort: true,
        https: {
            key: fs.readFileSync("./vitalic.local-key.pem"),
            cert: fs.readFileSync("./vitalic.local.pem"),
        },
        hmr: {
            host: "vitalic.local",
            protocol: "wss",
            port: 5190,
        },
    },
})