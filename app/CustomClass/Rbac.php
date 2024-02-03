<?php

namespace App\CustomClass;

use Illuminate\Support\Facades\Auth;
use App\Models\Menus;
use App\Models\Modules;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class Rbac
{

    protected $user;
    protected $arrRoleName = [];
    protected $strRoleName = [];

    public function __construct()
    {
        $this->user = Auth::user();
        $rolesName = $this->user->getRoleNames();

        foreach ($rolesName as $vrole) {
            array_push($this->arrRoleName, strtolower($vrole));
        }

        $this->strRoleName = implode(', ', array_map(function ($val) {
            return sprintf("'%s'", $val);
        }, $this->arrRoleName));
    }

    public function cekPrivileges($link, $operation)
    {
        if (in_array('administrator', $this->arrRoleName)) {
            return true;
        }

        if ($operation) {
            $row = DB::table('role_has_menus')->join('menus', 'role_has_menus.menu_uuid', '=', 'menus.uuid')
                ->join('roles', 'roles.id', '=', 'role_has_menus.role_id')
                ->whereRaw("lower(roles.name) IN ($this->strRoleName)")
                ->whereRaw("menus.link = '$link'")
                ->whereRaw("menus.is_active = 'Aktif'")
                ->whereRaw("roles.is_active = 'Aktif'")
                ->count();
            if ($row > 0) {
                $rowModules = Modules::join('permissions', 'permissions.modules_uuid', '=', 'modules.uuid')
                    ->join('role_has_permissions', 'role_has_permissions.permission_id', '=', 'permissions.id')
                    ->join('roles', 'roles.id', '=', 'role_has_permissions.role_id')
                    ->whereRaw("permissions.is_active = 'Aktif'")
                    ->whereRaw("roles.is_active = 'Aktif'")
                    ->whereRaw("modules.is_active = 'Aktif'")
                    ->whereRaw("modules.link = '$link'")
                    ->whereRaw("lower(roles.name) IN ($this->strRoleName)")
                    ->whereRaw(" (lower(permissions.name) = '" . strtolower($operation . ' ' . $link) . "') ");
                // echo $rowModules->toSql();
                // die;
                if ($rowModules->first()) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            $row = DB::table('role_has_menus')->join('menus', 'role_has_menus.menu_uuid', '=', 'menus.uuid')
                ->join('roles', 'roles.id', '=', 'role_has_menus.role_id')
                ->whereRaw("lower(roles.name) IN ($this->strRoleName)")
                ->whereRaw("menus.link = '$link'")
                ->whereRaw("roles.is_active = 'Aktif'")
                ->whereRaw("menus.is_active = 'Aktif'")
                ->count();
            if ($row > 0) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function menuApp($link = null)
    {
        if (in_array('administrator', $this->arrRoleName)) {
            $menus = Menus::where('is_active', 'Aktif')
                ->whereNull('main_uuid')
                ->orderBy('menu_order', 'asc')->get();
        } else {

            $single_menu = Menus::join('role_has_menus', 'role_has_menus.menu_uuid', '=', 'menus.uuid')
                ->join('roles', 'roles.id', '=', 'role_has_menus.role_id')
                ->whereRaw("lower(roles.name) IN ($this->strRoleName)")
                ->whereRaw("menus.is_active = 'Aktif'")
                ->whereNull('menus.main_uuid')
                ->orderBy('menus.menu_order', 'ASC')
                ->select([
                    'menus.*'
                ]);

            $menu_sidebar = Menus::join('menus as sub', 'sub.main_uuid', '=', 'menus.uuid')
                ->join('role_has_menus', 'role_has_menus.menu_uuid', '=', 'sub.uuid')
                ->join('roles', 'roles.id', '=', 'role_has_menus.role_id')
                ->whereRaw("lower(roles.name) IN ($this->strRoleName)")
                ->whereRaw("menus.is_active = 'Aktif'")
                ->whereNull('menus.main_uuid')
                ->orderBy('menus.menu_order', 'ASC')
                ->select([
                    'menus.*'
                ])
                ->union($single_menu);

            $str = $menu_sidebar->toSql();
            $rawSql = DB::raw(" SELECT * FROM ($str) AS tmp ORDER BY menu_order ASC ");
            $menus = DB::select($rawSql->getValue(DB::connection()->getQueryGrammar()));
        }

        $header = array();
        $output['menus'] = array();
        foreach ($menus as $res) {
            $row = array();
            $row['id'] = $res->uuid;
            $row['menu_name'] = $res->menu_name;
            $row['menu_header'] = $res->menu_header;
            $row['icon'] = $res->icon;
            $row['link'] = $res->link;
            $row['description'] = $res->description;

            $row['is_eksternal'] = $res->is_eksternal;
            $row['is_newtab'] = $res->is_newtab;

            $row['active'] = $this->active_menu($link, $res->uuid);
            $row['sub'] = $this->submenu_app($link, $res->uuid);
            $output['menus'][] = $row;

            if (count($row['sub']['submenu']) > 0 && $row['link'] == "#") {
                $header[$row['menu_header']] = $row['menu_header'];
            } elseif ($row['link'] !== "#") {
                $header[$row['menu_header']] = $row['menu_header'];
            }
        }

        return [
            'header' => $header,
            'output' => $output,
        ];
    }
    private function active_menu($link, $uuid)
    {
        $header = Menus::where('main_uuid', $uuid)->first();

        $val = Menus::where('link', $link)->first();
        if ($val) {
            if ($val->main_uuid == $uuid) {
                return ' show  ';
            } else if (!in_array($val->link, ['#', '-']) && !$header && !$val->main_uuid) {
                return ' active ';
            } else {
                return '';
            }
        }
    }

    private function submenu_app($link, $uuid)
    {
        if (in_array('administrator', $this->arrRoleName)) {
            $sub_menu_sidebar = Menus::where('is_active', 'Aktif')
                ->where('main_uuid', $uuid)
                ->orderBy('menu_order', 'asc')->get();
        } else {
            $sub_menu_sidebar = Menus::join('role_has_menus', 'role_has_menus.menu_uuid', '=', 'menus.uuid')
                ->join('roles', 'roles.id', '=', 'role_has_menus.role_id')
                ->whereRaw("lower(roles.name) IN ($this->strRoleName)")
                ->where('menus.is_active', 'Aktif')
                ->where('menus.main_uuid', $uuid)
                ->select(['menus.*'])
                ->orderBy('menus.menu_order', 'asc')->get();
        }
        $output['submenu'] = [];

        foreach ($sub_menu_sidebar as $row) {
            if ($link == $row->link) {
                $mnsub_active = ' nav-link active ';
            } else {
                $mnsub_active = '';
            }

            $mnsub = array();
            $mnsub['id'] = $row->uuid;
            $mnsub['menu_name'] = $row->menu_name;
            $mnsub['link'] = $row->link;
            $mnsub['icon'] = $row->icon;
            $mnsub['description'] = $row->description;
            $mnsub['sub_active'] = $mnsub_active;

            $mnsub['is_eksternal'] = $row->is_eksternal;
            $mnsub['is_newtab'] = $row->is_newtab;

            $output['submenu'][] = $mnsub;
        }

        return $output;
    }

    public static function generateRoleModule()
    {
        $routeCollection = Route::getRoutes();
        foreach ($routeCollection as $value) {
            if (strpos($value->uri, '/') !== false) {
                $path = explode('/', $value->uri);

                $str = " \ ";
                if (isset($value->action['middleware']) && $value->action['middleware'] && in_array('can:Access', $value->action['middleware'])) {
                    if (isset($value->action['controller']) && strpos($value->action['controller'], "App") !== false) {
                        $arr = explode(trim($str), $value->action['controller']);
                        if (isset($arr[3])) {

                            $mod = Modules::where('link', $path[0])
                                ->where('is_active', 'Aktif')
                                ->first();

                            $menus = Menus::where('link', $path[0])->first();
                            if ($menus) {
                                $name = ucwords(strtolower($menus->menu_name));
                            } else {
                                $name = ucwords(strtolower(str_replace('-', ' ', $path[0])));
                            }

                            if (!$mod) {
                                $mod = Modules::create([
                                    'name'          => $name,
                                    'description'   => 'Module ' . ucwords(strtolower(str_replace('-', ' ', $path[0]))),
                                    'link'          => ($path[0]),
                                    'is_active'     => 'Aktif',
                                ]);
                            }

                            if ($mod) {
                                $mo = Permission::where('modules_uuid', $mod->uuid)
                                    ->where('name', $path[1] . ' ' . $mod->link)
                                    ->first();

                                if (!$mo) {
                                    // Jika tidak ada maka buat data baru
                                    Permission::create([
                                        'modules_uuid'  => $mod->uuid,
                                        'name'          => $path[1] . ' ' . $mod->link,
                                        'description'   => 'Permission pada modul ' . $mod->name . ' perintah ' . ($path[1]),
                                        'is_active'     => 'Aktif',
                                    ]);
                                } else {
                                    Permission::find($mo->id)->update([
                                        'modules_uuid'  => $mod->uuid,
                                        'name'          => $path[1] . ' ' . $mod->link,
                                        'description'   => 'Permission pada modul ' . $mod->name . ' perintah ' . ($path[1]),
                                        'is_active'     => 'Aktif',
                                    ]);
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}
