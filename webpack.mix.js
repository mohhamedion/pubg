let mix = require('laravel-mix');

mix
    .js('resources/assets/js/app.js', 'public/js')
    .scripts(
        [
            'resources/assets/js/libs/bootstrap-table.min.js',
            'resources/assets/js/libs/bootstrap-table-locale-all.min.js',
            'resources/assets/js/libs/bootbox.js',
            'resources/assets/js/main.js',
        ],
        'public/js/main.js')
    .sass('resources/assets/sass/vendor.scss', 'public/css')
    .sass('resources/assets/sass/app.scss', 'public/css')
    .sass('resources/assets/sass/pages/auth.scss', 'public/css');

if (mix.inProduction()) {
    mix.version();
}

mix.copy('resources/assets/fonts', 'public/fonts');
mix.copy('resources/assets/images', 'public/images');
mix.copy('resources/assets/js/libs/tinymce', 'public/js/tinymce');