<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

//interface 
use App\Interface\QuestionRepositoryInterface;
use App\Interface\CategoryRepositoryInterface;
use App\Interface\OptionRepositoryInterface;
use App\Interface\QuizeRepositoryInterface;
use App\Interface\UserRepositoryInterface;

//classes
use App\RepositoryClass\QuestionRepository;
use App\RepositoryClass\CategoryRepository;
use App\RepositoryClass\OptionRepository;
use App\RepositoryClass\QuizeRepository;
use App\RepositoryClass\UserRepository;

class RepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(QuestionRepositoryInterface::class,QuestionRepository::class);
        $this->app->bind(CategoryRepositoryInterface::class,CategoryRepository::class);
        $this->app->bind(OptionRepositoryInterface::class,OptionRepository::class);
        $this->app->bind(QuizeRepositoryInterface::class,QuizeRepository::class);
        $this->app->bind(UserRepositoryInterface::class,UserRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
