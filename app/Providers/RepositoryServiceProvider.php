<?php

namespace App\Providers;

use App\Repositories\RoleRepository;
use App\Repositories\UserRepository;
use App\Repositories\SectionRepository;
use App\Repositories\SettingRepository;
use Illuminate\Support\ServiceProvider;
use App\Repositories\BannerSliderRepository;
use App\Repositories\ContentDescriptionRepository;
use App\Repositories\Interfaces\RoleRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\Interfaces\SectionRepositoryInterface;
use App\Repositories\Interfaces\SettingRepositoryInterface;
use App\Repositories\Interfaces\BannerSliderRepositoryInterface;
use App\Repositories\Interfaces\ContentDescriptionRepositoryInterface;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(RoleRepositoryInterface::class, RoleRepository::class);
        $this->app->bind(SettingRepositoryInterface::class, SettingRepository::class);
        $this->app->bind(SectionRepositoryInterface::class, SectionRepository::class);
        $this->app->bind(BannerSliderRepositoryInterface::class, BannerSliderRepository::class);
        $this->app->bind(ContentDescriptionRepositoryInterface::class, ContentDescriptionRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
