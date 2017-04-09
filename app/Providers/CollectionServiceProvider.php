<?php

namespace App\Providers;

use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;

class CollectionServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mark();
    }

    /**
     * Add a field and value to each item of the collection.
     *
     * @return void
     */
    private function mark()
    {
        Collection::macro('mark', function ($attribute, $value) {
            return collect($this->items)
                ->map(function ($item) use ($attribute, $value) {
                    $item->{$attribute} = $value;

                    return $item;
                });
        });
    }
}
