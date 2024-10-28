const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js')
   .sass('resources/sass/app.scss', 'public/css') // Si usas SCSS
   .css('resources/css/style.css', 'public/css'); // Agregar esta línea
