const mix = require("laravel-mix");
const path = require("path");

mix.webpackConfig({
    resolve: {
        alias: {
            "@": path.resolve(__dirname, "resources/js"),
        },
    },
    /*  devServer: {
        client: {
            webSocketURL: {
                hostname: "localhost:8000",
                pathname: "/ws",
                protocol: "wss",
            },
        },
        host: "0.0.0.0", // Listen on all IPs, required for ngrok
        port: 8000, // Default port for dev server
        hot: true, // Enable hot module replacement
    }, */
});

/* mix.browserSync({
    proxy: "http://127.0.0.1:8000", // Proxy Laravel server
    host: "578b-178-150-111-49.ngrok-free.app", // Your ngrok domain
    open: false, // Don't automatically open the browser
    port: 3000, // BrowserSync server port
    files: [
        "resources/views/app.blade.php",
        "public/js/app.js",
        "public/css/app.css",
    ],
    socket: {
        domain: "578b-178-150-111-49.ngrok-free.app",
    },
}); */

mix.js("resources/js/app.js", "public/js")
    .vue()
    .postCss("resources/css/app.css", "public/css")
    .setPublicPath("public");
