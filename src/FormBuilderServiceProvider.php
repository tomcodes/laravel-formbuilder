<?php
/*--------------------
https://github.com/jazmy/laravelformbuilder
Licensed under the GNU General Public License v3.0
Author: Jasmine Robinson (jazmy.com)
Last Updated: 12/29/2018
----------------------*/
namespace jazmy\FormBuilder;

use jazmy\FormBuilder\Middlewares\FormAllowSubmissionEdit;
use jazmy\FormBuilder\Middlewares\PublicFormAccess;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class FormBuilderServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/config.php', 'formbuilder'
        );
    }

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        // load custom route overrides
        $this->loadRoutesFrom( __DIR__.'/../routes.php' );

        // register the middleware
        Route::aliasMiddleware('public-form-access', PublicFormAccess::class);
        Route::aliasMiddleware('submisson-editable', FormAllowSubmissionEdit::class);

        $this->publishes([
            __DIR__.'/../database/migrations/2018_09_30_110932_create_forms_table.php' => database_path('migrations/2018_09_30_110932_create_forms_table.php'),
            __DIR__.'/../database/migrations/2018_09_30_142113_create_form_submissions_table.php' => database_path('migrations/2018_09_30_142113_create_form_submissions_table.php'),
            __DIR__.'/../database/migrations/2018_10_16_000926_add_custom_submit_url_column_to_the_forms_table.php' => database_path('migrations/2018_10_16_000926_add_custom_submit_url_column_to_the_forms_table.php'),
        ], 'migrations');

        // // publish config files
        $this->publishes([
            __DIR__.'/../config/config.php' => config_path('formbuilder.php', 'formbuilder'),
        ], 'formbuilder-config');

        // publish view files
        $this->publishes([
            __DIR__.'/../views' => resource_path('views/vendor/formbuilder', 'formbuilder::'),
        ], 'formbuilder-views');

        // // publish public assets
        $this->publishes([
            __DIR__.'/../public' => public_path('vendor/formbuilder'),
        ], 'formbuilder-public');
    }
}
