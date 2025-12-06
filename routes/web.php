<?php

use App\Http\Controllers\Admin\AccountController;
use App\Http\Controllers\Admin\ContentController;
use App\Http\Controllers\Admin\GalleryItemController;
use App\Http\Controllers\Admin\NewsArticleController;
use App\Http\Controllers\Admin\PartnerController;
use App\Http\Controllers\Admin\TeamController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\TournamentAdminController;
use App\Http\Controllers\Admin\TournamentCardController;
use App\Http\Controllers\Admin\TournamentGameAdminController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PartnerPublicController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TeamPublicController;
use App\Http\Controllers\TournamentController;
use App\Http\Controllers\TournamentGameImageController;
use App\Http\Controllers\Registration\SingleRegistrationController;
use App\Http\Controllers\Registration\TeamRegistrationController;
use App\Http\Controllers\WinnersController;
use Illuminate\Support\Facades\Route;

// Keep ONE home route
Route::view('/', 'site.home')->name('home');


// Locale toggle
Route::get('/lang/{locale}', function (string $locale) {
    $allowed = ['en','ar'];
    $selected = in_array($locale, $allowed, true) ? $locale : config('app.fallback_locale', 'en');

    session(['locale' => $selected]);
    app()->setLocale($selected);

    return redirect()->back(fallback: route('home'));
})->name('setLocale');

// The rest of pages
Route::view('/about', 'site.about')->name('about');
Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery');
Route::get('/gallery/{item:slug}', [GalleryController::class, 'show'])->name('gallery.show');
Route::view('/partners', 'site.partners')->name('partners');
Route::get('/partners/{partner:slug}', [PartnerPublicController::class, 'show'])
    ->name('partners.show');
Route::view('/privacy', 'site.privacy')->name('privacy');
Route::view('/services', 'site.services')->name('services');
Route::view('/terms', 'site.terms')->name('terms');
Route::view('/tournaments', 'site.tournaments')->name('tournaments');
Route::get('/tournaments/{tournament:slug}/register', [TournamentController::class, 'register'])
    ->name('tournaments.register');
Route::view('/tours-reg', 'site.tours-reg')->name('tours-reg');
Route::get('/team', [TeamPublicController::class, 'index'])->name('team');
Route::get('/team/{team:slug}', [TeamPublicController::class, 'show'])->name('teams.show');
Route::get('/media/tournament-games/{game:slug}', TournamentGameImageController::class)
    ->name('tournament-games.image');

// Public registration
Route::get('/register/single', [SingleRegistrationController::class, 'create'])->name('register.single');
Route::post('/register/single', [SingleRegistrationController::class, 'store'])
    ->middleware('throttle:5,1')
    ->name('register.single.store');

Route::get('/register/team', [TeamRegistrationController::class, 'create'])->name('register.team');
Route::post('/register/team', [TeamRegistrationController::class, 'store'])
    ->middleware('throttle:5,1')
    ->name('register.team.store');

Route::redirect('/reg-single', '/register/single')->name('reg-single');
Route::redirect('/reg-team', '/register/team')->name('reg-team');

// Public news
Route::get('/news', [NewsController::class, 'index'])->name('news');
Route::get('/news/{article}', [NewsController::class, 'show'])->name('news.show');

// Public winners
Route::get('/winners/{tournament:slug}', [WinnersController::class, 'show'])->name('winners.show');

// Dashboard & auth (unchanged)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::middleware(['web','auth']) // Phase 8 can add 'can:manage-content'
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/', [ContentController::class, 'dashboard'])->name('dashboard');
        Route::get('/contents', [ContentController::class, 'index'])->name('contents.index');
        Route::get('/contents/page/{group}', [ContentController::class, 'page'])->name('contents.page');
        Route::get('/contents/skeleton/{group}', [ContentController::class, 'skeleton'])->name('contents.skeleton');
        Route::get('/contents/{key}/data', [ContentController::class, 'showData'])->name('contents.data');
        Route::get('/contents/{key}', [ContentController::class, 'edit'])->name('contents.edit');
        Route::post('/contents/{key}', [ContentController::class, 'update'])->name('contents.update');
        Route::post('/contents/{key}/ajax', [ContentController::class, 'updateAjax'])->name('contents.update.ajax');

        Route::get('/account', [AccountController::class, 'edit'])->name('account.edit');
        Route::put('/account/email', [AccountController::class, 'updateEmail'])->name('account.email.update');
        Route::put('/account/username', [AccountController::class, 'updateUsername'])->name('account.username.update');
        Route::put('/account/password', [AccountController::class, 'updatePassword'])->name('account.password.update');
        
        // AJAX endpoints for content management
        Route::post('/content/update-ajax', [ContentController::class, 'updateContentAjax'])->name('content.update-ajax');
        Route::post('/content/batch-update', [ContentController::class, 'batchUpdate'])->name('content.batch-update');

        Route::resource('tournament-cards', TournamentCardController::class)
            ->parameters(['tournament-cards' => 'tournament_card'])
            ->except(['show']);

        Route::post('tournament-cards/reorder', [TournamentCardController::class, 'reorder'])
            ->name('tournament-cards.reorder');

        Route::get('/tournaments', [TournamentAdminController::class, 'index'])->name('tournaments.index');
        Route::delete('/tournaments/bulk', [TournamentAdminController::class, 'bulkDestroy'])->name('tournaments.bulk-destroy');
        Route::get('/tournaments/open', [TournamentAdminController::class, 'open'])->name('tournaments.open');
        Route::get('/tournaments/{tournament:slug}', [TournamentAdminController::class, 'show'])->name('tournaments.show');
        Route::get('/tournaments/{tournament:slug}/export', [TournamentAdminController::class, 'export'])->name('tournaments.export');
        Route::post('/tournaments/{tournament:slug}/finish', [TournamentAdminController::class, 'finish'])->name('tournaments.finish');
        Route::get('/tournaments/{tournament:slug}/games', [TournamentGameAdminController::class, 'index'])->name('tournaments.games.index');
        Route::get('/tournaments/{tournament:slug}/games/create', [TournamentGameAdminController::class, 'create'])->name('tournaments.games.create');
        Route::post('/tournaments/{tournament:slug}/games', [TournamentGameAdminController::class, 'store'])->name('tournaments.games.store');
        Route::get('/tournaments/{tournament:slug}/games/{game:slug}/edit', [TournamentGameAdminController::class, 'edit'])->name('tournaments.games.edit');
        Route::put('/tournaments/{tournament:slug}/games/{game:slug}', [TournamentGameAdminController::class, 'update'])->name('tournaments.games.update');
        Route::delete('/tournaments/{tournament:slug}/games/{game:slug}', [TournamentGameAdminController::class, 'destroy'])->name('tournaments.games.destroy');
        Route::post('/tournaments/{tournament:slug}/games/reorder', [TournamentGameAdminController::class, 'reorder'])->name('tournaments.games.reorder');

        Route::resource('news-articles', NewsArticleController::class)->except(['show']);
        Route::post('news-articles/reorder', [NewsArticleController::class, 'reorder'])
            ->name('news-articles.reorder');

        Route::resource('gallery-items', GalleryItemController::class)
            ->parameters(['gallery-items' => 'gallery_item'])
            ->except(['show']);
        Route::post('gallery-items/reorder', [GalleryItemController::class, 'reorder'])
            ->name('gallery-items.reorder');

        Route::resource('testimonials', TestimonialController::class)->except(['show']);
        Route::post('testimonials/reorder', [TestimonialController::class, 'reorder'])
            ->name('testimonials.reorder');

        Route::resource('partners', PartnerController::class)->except(['show']);
        Route::post('partners/reorder', [PartnerController::class, 'reorder'])
            ->name('partners.reorder');

        Route::resource('teams', TeamController::class);
    });
