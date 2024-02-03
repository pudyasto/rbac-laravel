<?php

namespace App\Http\Controllers;

use App\Models\Menus;
use App\Models\Modules;
use App\Models\RoleHasMenus;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;

class RolesController extends Controller
{

    protected $message = 'Data berhasil di proses';
    protected $code = 200;
    protected $response = array();

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('rbac.roles.index', []);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
        if (!$request->ajax()) {
            return redirect('');
        }

        return view('rbac.roles.form', [
            'url'   => url('/roles/store'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        try {
            if (!$request->ajax()) {
                return redirect('');
            }

            $validator = Validator::make($request->all(), [
                'name'         => ['required'],
            ]);

            if ($validator->fails()) {
                throw new Exception(errorValidasi($validator->errors()));
            }

            DB::beginTransaction();

            $this->response = Role::create([
                'name'          => $request->name,
                'guard_name'    => 'web',
                'description'   => $request->description,
                'is_active'     => $request->is_active,
            ]);

            $this->message = "Data berhasil disimpan";
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            $this->message = errorMessage($e->getMessage());
            $this->code = 201;
        }

        return response()->json([
            'metadata' => array(
                'message' => $this->message,
                'code' => $this->code,
            ),
            'response' => $this->response,
        ], $this->code);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        //
        if (!$request->ajax()) {
            return redirect('');
        }
        $data = Role::where('id', $id)->first();
        return view('rbac.roles.form', [
            'url'       => url('/roles/update/' . $id),
            'data'      => $data
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        try {
            if (!$request->ajax()) {
                return redirect('');
            }

            $validator = Validator::make($request->all(), [
                'name'  => ['required'],
            ]);

            if ($validator->fails()) {
                throw new Exception(errorValidasi($validator->errors()));
            }

            DB::beginTransaction();

            $this->response = Role::find($id)->update([
                'name'          => $request->name,
                'description'   => $request->description,
                'is_active'     => $request->is_active,
            ]);

            $this->message = "Data berhasil diubah";
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            $this->message = errorMessage($e->getMessage());
            $this->code = 201;
        }

        return response()->json([
            'metadata' => array(
                'message' => $this->message,
                'code' => $this->code,
            ),
            'response' => $this->response,
        ], $this->code);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        //
        try {
            if (!$request->ajax()) {
                return redirect('');
            }

            DB::beginTransaction();

            $this->response = Role::find($id)->delete();

            $this->message = "Data berhasil dihapus";
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            $this->message = errorMessage($e->getMessage());
            $this->code = 201;
        }

        return response()->json([
            'metadata' => array(
                'message' => $this->message,
                'code' => $this->code,
            ),
            'response' => $this->response,
        ], $this->code);
    }

    public function tableMain(Request $request)
    {
        if (!$request->ajax()) {
            return redirect('');
        }

        $data  = Role::select(['roles.*',]);
        return DataTables::of($data)
            ->addColumn('btn', function ($data) {
                $btn = '<center>' .
                    '<div class="btn-group btn-group-sm" role="group" aria-label="Button Role">' .
                    '<div class="dropdown">' .
                    '<button type="button" id="dropDownAkses' . $data->id . '" class="btn btn-sm btn-dark dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">' .
                    'Akses' .
                    '</button>' .
                    '<ul class="dropdown-menu" aria-labelledby="dropDownAkses' . $data->id . '">' .
                    '<li>' .
                    '<a class="dropdown-item" href="#"' .
                    ' data-bs-toggle="modal"' .
                    ' data-title="Set Menu Pada Role : ' . $data->name  . '"' .
                    ' data-post-id="' . $data->id . '"' .
                    ' data-action-url="roles/formRoleMenus/' . $data->id . '"' .
                    ' data-bs-target="#form-modal">' .
                    'Set Menu' .
                    '</a>' .
                    '</li>' .
                    '<li>' .
                    '<a class="dropdown-item" href="#"' .
                    ' data-bs-toggle="modal"' .
                    ' data-title="Set Module Pada Role : ' . $data->name  . '"' .
                    ' data-post-id="' . $data->id . '"' .
                    ' data-action-url="roles/formRoleModules/' . $data->id . '"' .
                    ' data-bs-target="#form-modal">' .
                    'Set Module' .
                    '</a>' .
                    '</li>' .
                    '</ul>' .
                    '</div>' .

                    '<button class="btn btn-info btn-sm waves-effect"' .
                    ' data-bs-toggle="modal"' .
                    ' data-title="Edit Data : ' . $data->name  . '"' .
                    ' data-post-id="' . $data->id . '"' .
                    ' data-action-url="roles/edit/' . $data->id . '"' .
                    ' data-bs-target="#form-modal">' .
                    'Edit' .
                    '</button>' .
                    '<button class="btn btn-danger btn-sm waves-effect"' .
                    ' onclick="deleteData(\'' . $data->id . '\');">' .
                    'Hapus' .
                    '</button>' .
                    '</div>' .
                    '</center>';
                return $btn;
            })
            ->rawColumns(['btn'])
            ->make(true);
    }

    /*
     * Role Menu Begin
     */
    public function formRoleMenus(Request $request, $id)
    {

        if (!$request->ajax()) {
            return redirect('');
        }
        $data = Role::where('id', $id)->first();
        return view('rbac.roles.formRoleMenus', [
            'url'       => url('/roles/storeRoleMenus/' . $id),
            'data'      => $data
        ]);
    }

    public function tableDetailRoleMenus(Request $request)
    {
        if (!$request->ajax()) {
            return redirect('');
        }
        $roleMenu = RoleHasMenus::where('role_id', $request->role_id);
        $data = Menus::with(['parent'])->leftJoinSub($roleMenu, 'rolemenu', 'rolemenu.menu_uuid', '=', 'menus.uuid')
            ->select([
                'rolemenu.menu_uuid',
                'menus.uuid',
                'menus.menu_name',
                'menus.link',
                'menus.description',
                'menus.main_uuid',
            ])
            ->where('menus.is_active', 'Aktif')
            ->where('menus.link', '<>', '#')
            ->get();
        return DataTables::of($data)
            ->addColumn('pilih', function ($data) {
                if ($data->menu_uuid) {
                    $chkPilih = '<div class="form-group">' .
                        '<button class="btn btn-success btn-sm set-rule" type="button" id="' . $data->uuid . '">Aktif</button>' .
                        '</div>';
                } else {
                    $chkPilih = '<div class="form-group">' .
                        '<button class="btn btn-dark btn-sm set-rule" type="button" id="' . $data->uuid . '">Tidak</button>' .
                        '</div>';
                }
                $btn = '<center>' .
                    $chkPilih .
                    '</center>';
                return $btn;
            })
            ->rawColumns(['pilih'])
            ->make(true);
    }

    public function storeRoleMenus(Request $request, $role_id)
    {
        try {
            if (!$request->ajax()) {
                return redirect('');
            }

            DB::beginTransaction();

            $cek = RoleHasMenus::where('role_id', $role_id)
                ->where('menu_uuid', $request->menu_uuid)
                ->first();

            if ($cek) {
                RoleHasMenus::where('role_id', $role_id)
                    ->where('menu_uuid', $request->menu_uuid)
                    ->delete();
            } else {
                RoleHasMenus::create(
                    [
                        'role_id'    => $role_id,
                        'menu_uuid'     => $request->menu_uuid,
                    ]
                );
            }
            $this->message = "Data berhasil diproses";
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            $this->message = $e->getMessage();
            $this->code = 202;
        }


        return response()->json([
            'metadata' => array(
                'message' => $this->message,
                'code' => $this->code,
            ),
            'response' => $this->response,
        ], $this->code);
    }
    /*
     * Role Menu End
     */

    /*
     * Role Permission Begin
     */


    public function formRoleModules(Request $request, $id)
    {

        if (!$request->ajax()) {
            return redirect('');
        }
        $data = Role::where('id', $id)->first();
        return view('rbac.roles.formRoleModules', [
            'url'       => url('/roles/storeRoleModules/' . $id),
            'data'      => $data
        ]);
    }

    public function getListModule(Request $request)
    {
        $module = Modules::with([
            'permission' => function ($q) use ($request) {
                $rmo = DB::table('role_has_permissions')->where('role_id', $request->role_id);
                $q->leftJoinSub($rmo, 'selected_role', 'selected_role.permission_id', '=', 'permissions.id');
                $q->select([
                    'permissions.*',
                    DB::raw("CASE WHEN selected_role.permission_id IS NULL THEN '' ELSE 'checked' END AS checked"),
                ]);
                $q->orderBy('name');
            }
        ])
            ->where('modules.is_active', 'Aktif')
            ->orderBy('modules.name', 'ASC')
            ->get();

        return view('rbac.roles.checkbox', [
            'module'    => $module,
        ]);
    }

    public function storeRoleModules(Request $request)
    {
        try {
            if (!$request->ajax()) {
                return redirect('');
            }

            $validator = Validator::make($request->all(), [
                'role_id'  => ['required'],
            ]);

            if ($validator->fails()) {
                throw new Exception(errorValidasi($validator->errors()));
            }

            DB::beginTransaction();
            $role = Role::find($request->role_id);

            // Remove all permission to spesific role
            $allPermission = Permission::get();
            foreach($allPermission as $val){
                $role->revokePermissionTo($val->name);
            }

            // Give permission to spesific role
            foreach ($request->all() as $key => $val) {
                if (strpos($key, 'chk-') !== false) {
                    $permission = Permission::where('id',$val)->first();
                    $role->givePermissionTo($permission);
                }
            }

            $this->message = "Data berhasil disimpan";

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            $this->message = errorMessage($e->getMessage());
            $this->code = 201;
        }

        return response()->json([
            'metadata' => array(
                'message' => $this->message,
                'code' => $this->code,
            ),
            'response' => $this->response,
        ], $this->code);
    }
    /*
     * Role Permission End
     */
}
