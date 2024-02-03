<?php

namespace App\Providers;

use App\CustomClass\Rbac;
use App\Models\Menus;
use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use App\Providers\AuthServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends AuthServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
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
        //
        date_default_timezone_set('Asia/Jakarta');
        config(['app.locale' => 'id']);
        Carbon::setLocale('id');
        
        $this->registerPolicies();

        Gate::define('Access', function ($user) {
            if (isset($this->prev_segments(URL::current())[0])) {
                $link = $this->prev_segments(URL::current())[0];

                $operation = null;
                if(isset($this->prev_segments(URL::current())[1])){
                    $operation = $this->prev_segments(URL::current())[1];
                }
                $pawrbac = new Rbac;
                $res = $pawrbac->cekPrivileges($link, $operation);
                return $res;

            } else {
                return true;
            }
            
        });

        View::composer(
            'includes.main-sidebar',
            function ($view) {
                if (Route::currentRouteName()) {
                    $path_url = Route::currentRouteName();
                } else {
                    $path_url = '';
                }

                $menuapps = new Rbac;
                $arr = $menuapps->menuApp($path_url);
                $view->with('link',  $path_url);
                $view->with('header_menu_sidebar',  $arr['header']);
                $view->with('menu_sidebar',  $arr['output']);
            }
        );

        
        View::composer(
            'includes.main-head',
            function ($view) {

                if (isset($this->prev_segments(URL::current())[0])) {
                    $path_url = $this->prev_segments(URL::current())[0];
                } else {
                    $path_url = '';
                }

                $menus = $this->getMenusName($path_url);

                if ($menus) {
                    $menuName = $menus->menu_name;
                    $subMenuName = $menus->sub_menu_name;
                } else {
                    $menuName = ucwords(strtolower($path_url));
                    $subMenuName = '';
                }

                $view->with('menuTitle',  ($subMenuName) ? $subMenuName : $menuName);
            }
        );

        View::composer(
            'layouts.main',
            function ($view) {

                if (isset($this->prev_segments(URL::current())[0])) {
                    $path_url = $this->prev_segments(URL::current())[0];
                } else {
                    $path_url = '';
                }

                $menus = $this->getMenusName($path_url);

                if ($menus) {
                    $menuName = $menus->menu_name;
                    $subMenuName = $menus->sub_menu_name;
                } else {
                    $menuName = ucwords(strtolower($path_url));
                    $subMenuName = '';
                }

                $view->with('menuName',  $menuName);
                $view->with('subMenuName',  $subMenuName);
            }
        );
    }

    private function getMenusName($path_url)
    {
        $single_menu = Menus::whereRaw("menus.link = '" . $path_url . "'")
            ->whereRaw("menus.is_active = 'Aktif'")
            ->whereNull('menus.main_uuid')
            ->orderBy('menus.menu_order', 'ASC')
            ->select([
                'menus.*',
                DB::raw("'' as sub_menu_name")
            ]);

        $menus = Menus::join('menus as sub', 'sub.main_uuid', '=', 'menus.uuid')
            ->whereRaw("sub.link = '" . $path_url . "'")
            ->whereRaw("menus.is_active = 'Aktif'")
            ->whereNull('menus.main_uuid')
            ->orderBy('menus.menu_order', 'ASC')
            ->select([
                'menus.*',
                DB::raw('sub.menu_name as sub_menu_name')
            ])
            ->union($single_menu)
            ->first();

        return $menus;
    }

    private function prev_segments($uri)
    {
        $segments = explode('/', str_replace('' . url('') . '', '', $uri));

        return array_values(array_filter($segments, function ($value) {
            return $value !== '';
        }));
    }
}
