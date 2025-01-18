<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Post;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer(['home', 'posts.index', 'blog'], function ($view) {
            $posts = Post::latest()->paginate(10); // Ambil postingan terbaru dengan pagination
            $view->with('posts', $posts);
        });
    }
}
