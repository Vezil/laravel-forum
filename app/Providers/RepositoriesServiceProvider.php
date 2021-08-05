<?php

namespace App\Providers;

use App\Interfaces\Resources\CategoryRepositoryInterface;
use App\Interfaces\Resources\NotificationRepositoryInterface;
use App\Interfaces\Resources\QuestionRepositoryInterface;
use App\Interfaces\Resources\ReplyRepositoryInterface;
use App\Repositories\CategoryRepository;
use App\Repositories\NotificationRepository;
use App\Repositories\QuestionRepository;
use App\Repositories\ReplyRepository;
use Illuminate\Support\ServiceProvider;

class RepositoriesServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(QuestionRepositoryInterface::class, QuestionRepository::class);
        $this->app->bind(NotificationRepositoryInterface::class, NotificationRepository::class);
        $this->app->bind(ReplyRepositoryInterface::class, ReplyRepository::class);
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
    }
}
