const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js')
.js('resources/js/firebase.js', 'public/js')
//.js('resources/js/firebase-messaging-sw.js', 'public/js')
.sass('resources/sass/app.scss', 'public/css');
