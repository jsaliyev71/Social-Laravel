<?php

use App\Http\Controllers\Admin\{
    DashboardController,
    CategoryController as AdminCategoryController,
    CommunityController as AdminCommunityController,
    UserController as AdminUserController
};
use App\Http\Controllers\{
    Ajax\AjaxSectionController, 
    Auth\LoginController, 
    Auth\RegisterController, 
    CategoryController, 
    CommentController, 
    CommentReactionController, 
    HomeController,
    PostController,
    Community\CommunityController, 
    Community\CommunityManageController, 
    Community\CommunityManageMemberController, 
    Community\CommunityManagePostController, 
    Community\CommunitySectionController, 
    Community\CommunityMemberController, 
    PostReactionController,
    ProfileController, 
    SearchController, UserController, 
    UserSettingsController
};
use Illuminate\Support\Facades\Route;




Route::prefix('ajax')->group(function() {
    Route::get('{community_id}/sections', [AjaxSectionController::class, 'index']);
});




Route::prefix('auth')->name('auth.')->group(function() {
    Route::middleware('guest')->group(function() {
        Route::get('login', [LoginController::class, 'index'])->name('login.index');
        Route::post('login', [LoginController::class, 'login'])->name('login.store');
        
        Route::get('register', [RegisterController::class, 'create'])->name('register.create');
        Route::post('register', [RegisterController::class, 'store'])->name('register.store');
    });

    Route::middleware('auth')->group(function() {
        Route::delete('logout', [LoginController::class, 'logout'])->name('logout');
    });
});




Route::group([], function() {
    Route::get('/', [HomeController::class, 'index'])->name('home.index');

    Route::get('communities', [CommunityController::class, 'index'])->name('communities.index');
    Route::get('c/{slug}', [CommunityController::class, 'show'])->name('communities.show');
    Route::get('c/{slug}/about', [CommunityController::class, 'about'])->name('communities.about');

    Route::get('categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('ctg/{category_name}', [CategoryController::class, 'show'])->name('categories.show');

    Route::get('posts', [PostController::class, 'index'])->name('posts.index');
    // Route::get('p/{post_id}', [PostController::class, 'show'])->name('posts.show');

    Route::get('search', [SearchController::class, 'index'])->name('search.index');
});




Route::middleware('auth')->group(function() {

    Route::prefix('@{username}')->name('profile.')->controller(ProfileController::class)->group(function() {
        Route::get('', 'show')->name('show');
        Route::get('comments', 'comments')->name('comments');
        Route::get('communities', 'communities')->name('communities');
        Route::get('about', 'about')->name('about');

        Route::get('saved', 'saved')->name('saved');
        Route::get('hidden', 'hidden')->name('hidden');
        Route::get('history', 'history')->name('history');
        Route::get('reacted', 'reacted')->name('reacted');

        Route::get('edit', 'edit')->name('edit');
        Route::patch('update', 'update')->name('update');
        Route::delete('delete', 'delete')->name('delete');
    });

    Route::prefix('settings')->name('settings.')->controller(UserSettingsController::class)->group(function () {
        Route::get('', 'index')->name('index');
        Route::get('preferences', 'preferences')->name('preferences');
        Route::get('privacy', 'privacy')->name('privacy');

        Route::patch('profile/update', 'updateProfile')->name('profile.update');
        Route::patch('preferences/update', 'updatePreferences')->name('preferences.update');
        Route::patch('privacy/update', 'updatePrivacy')->name('privacy.update');

        Route::delete('account/delete', 'deleteAccount')->name('account.delete');
    });

    Route::prefix('posts')->name('posts.')->controller(PostController::class)->group(function() {
        Route::get('create', 'create')->name('create');
        Route::post('', 'store')->name('store');
        Route::prefix('{post_id}')->group(function() {
            Route::get('', 'show')->name('show');
            Route::get('edit', 'edit')->name('edit');
            Route::patch('update', 'update')->name('update');
            Route::delete('delete', 'delete')->name('delete');

            Route::prefix('comments')->name('comments.')->controller(CommentController::class)->group(function() {
                Route::get('', 'index')->name('index');
                Route::post('store', 'store')->name('store');

                Route::prefix('{comment_id}')->group(function() {
                    Route::get('', 'show')->name('show');
                });
            });
        });
    });

    Route::prefix('comments/{comment_id}')->name('comments.')->controller(CommentController::class)->group(function() {
        Route::patch('update', 'update')->name('update');
        Route::delete('delete', 'delete')->name('delete');
    });

    Route::post('posts/{post_id}/react', [PostReactionController::class, 'react'])->name('posts.react');
    Route::post('comments/{comment_id}/react', [CommentReactionController::class, 'react'])->name('comments.react');

    Route::prefix('communities')->name('communities.')->controller(CommunityController::class)->group(function() {
        Route::get('create', 'create')->name('create');
        Route::post('', 'store')->name('store');
    });

    Route::prefix('c/{slug}')->name('communities.')->group(function() {
        Route::post('follow', [CommunityMemberController::class, 'follow'])->name('follow');
        
        Route::get('submit', [PostController::class, 'create'])->name('post.create'); 

        Route::prefix('p/{post_id}')->name('posts.')->group(function() {
            Route::get('', [PostController::class, 'show'])->name('show');

            Route::prefix('comments')->name('comments.')->controller(CommentController::class)->group(function() {
                Route::get('', 'index')->name('index');
                Route::get('{comment_id}', 'show')->name('show');
            });
        });

        Route::prefix('manage')->name('manage.')->controller(CommunityManageController::class)->group(function() {
            Route::get('', 'index')->name('index');
            Route::get('privacy', 'privacy')->name('privacy');

            Route::patch('general/update', 'updateGeneral')->name('general.update');
            Route::patch('privacy/update', 'updatePrivacy')->name('privacy.update');
            
            Route::delete('general/delete', 'communityDelete')->name('delete');

            Route::prefix('sections')->name('sections.')->controller(CommunitySectionController::class)->group(function() {
                Route::get('', 'index')->name('index');
                Route::post('store', 'store')->name('store');
                Route::prefix('{section_id}')->group(function() {
                    Route::patch('update', 'update')->name('update');
                    Route::delete('delete', 'delete')->name('delete');
                });
            });

            Route::prefix('members')->name('members.')->controller(CommunityManageMemberController::class)->group(function () {
                Route::get('', 'index')->name('index');
                Route::prefix('{user_id}')->group(function () {
                    Route::post('accept', 'accept')->name('accept');
                    Route::post('reject', 'reject')->name('reject');
                    Route::post('remove', 'remove')->name('remove');
                    Route::post('ban', 'ban')->name('ban');
                    Route::post('unban', 'unban')->name('unban');
                });
            });

            Route::prefix('posts')->name('posts.')->controller(CommunityManagePostController::class)->group(function() {
                Route::get('', 'index')->name('index');
                Route::prefix('{post_id}')->group(function() {
                    Route::post('accept', 'accept')->name('accept');
                    Route::post('reject', 'reject')->name('reject');
                    Route::post('pin', 'pin')->name('pin');
                    Route::post('unpin', 'unpin')->name('unpin');
                    Route::delete('remove', 'remove')->name('remove');
                });
            });
        });
    });

    Route::prefix('people')->name('people.')->controller(UserController::class)->group(function() {
        Route::get('', 'index')->name('index');
    });
});




Route::prefix('cp')->name('cp.')->middleware(['auth', 'superadmin'])->group(function() {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('categories')->name('categories.')->controller(AdminCategoryController::class)->group(function() {
        Route::get('', 'index')->name('index');
        Route::get('create', 'create')->name('create');
        Route::post('', 'store')->name('store');
        Route::prefix('{category_name}')->group(function() {
            Route::get('', 'show')->name('show');
            Route::get('edit', 'edit')->name('edit');
            Route::patch('update', 'update')->name('update');
            Route::delete('delete', 'delete')->name('delete');
        });
    });

    Route::prefix('communities')->name('communities.')->controller(AdminCommunityController::class)->group(function() {
        Route::get('', 'index')->name('index');
        Route::get('create', 'create')->name('create');
        Route::post('', 'store')->name('store');
        Route::prefix('{slug}')->group(function() {
            Route::get('', 'show')->name('show');
            Route::get('edit', 'edit')->name('edit');
            Route::patch('update', 'update')->name('update');
            Route::delete('delete', 'delete')->name('delete');
        });
    });
    
    Route::prefix('users')->name('users.')->controller(AdminUserController::class)->group(function() {
        Route::get('', 'index')->name('index');
        Route::prefix('{user_id}')->group(function() {
            Route::get('', 'show')->name('show');
            Route::patch('ban', 'ban')->name('ban');
            Route::patch('unban', 'unban')->name('unban');
            Route::delete('delete', 'delete')->name('delete');
        });
    });
});



