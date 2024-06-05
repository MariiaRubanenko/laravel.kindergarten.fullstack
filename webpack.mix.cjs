const mix = require("laravel-mix");
const path = require("path");

mix.webpackConfig({
    resolve: {
        alias: {
            "@": path.resolve(__dirname, "resources/js"),
        },
    },
});

mix.js("resources/js/app.js", "public/js")
    .vue()
    .postCss("resources/css/app.css", "public/css")
    .setPublicPath("public");
