import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/about.css',
                'resources/css/admin-responsive.css',
                'resources/css/auth-fixes.css',
                'resources/css/gallery.css',
                'resources/css/home.css',
                'resources/css/home.rtl.css',
                'resources/css/navbar.css',
                'resources/css/ourservices.css',
                'resources/css/partner_show.css',
                'resources/css/partners.css',
                'resources/css/privacy.css',
                'resources/css/reg-single.css',
                'resources/css/reg-team.css',
                'resources/css/safari-fixes.css',
                'resources/css/style.css',
                'resources/css/team.css',
                'resources/css/team_show.css',
                'resources/css/terms.css',
                'resources/css/tournaments.css',
                'resources/css/tours-reg.css',
                'resources/js/app.js',
                'resources/js/admin-mobile-menu.js',
                'resources/js/home.js',
                'resources/js/logout.js',
                'resources/js/script.js',
            ],
            refresh: true,
        }),
    ],
    build: {
        outDir: 'public/build',
        manifest: true,
        emptyOutDir: true,
    },
});
