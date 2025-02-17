<?php

namespace App\Providers;

use App\Models\admin\SendTask;
use App\Models\studydepartament\Donetask;
use App\Models\studydepartament\DoneUserDocs;
use App\Models\studydepartament\UserDocuments;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

use Illuminate\Support\Facades\Schema;

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
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        // Connect Helpers
        foreach (glob(__DIR__ . '/../Helpers/*.php') as $filename) {
            require_once $filename;
        }

        View::composer('*', function ($view) {
            $user = auth()->user();

            if ($user) {

                $sends = SendTask::count();

                $donetask_id = Donetask::pluck('task_id');

                $send = SendTask::whereIn('id', $donetask_id)->count();


                $userdocs_id = DB::table('userdocs_has_departments')
                    ->where('department_id', $user->department_id)
                    ->where('status', 'waiting')
                    ->pluck('userdocs_id');


                $userdocs = UserDocuments::where('status', '!=', 'cancelled')
                    ->whereIn('id', $userdocs_id)
                    ->count();


                $doneuserdoc_id = DoneUserDocs::where('user_id', $user->id)->pluck('userdocs_id');

                $userdoc = UserDocuments::whereIn('id', $doneuserdoc_id)
                    ->where('status', '!=', 'cancelled')
                    ->count();


                $view->with('count', max(0, $sends - $send));
                $view->with('count_docs', max(0, $userdocs - $userdoc));

            } else {
                $view->with('count', 0);
            }


        });


    }
}
