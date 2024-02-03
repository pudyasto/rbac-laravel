<?php

namespace App\Http\Controllers;

use App\Models\Menus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Exception;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class MenusController extends Controller
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
        return view('rbac.menus.index', []);
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

        return view('rbac.menus.form', [
            'url'   => url('/menus/store'),
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
                'menu_name'         => ['required'],
                'link'              => ['required', 'max:255'],
            ]);

            if ($validator->fails()) {
                throw new Exception(errorValidasi($validator->errors()));
            }

            DB::beginTransaction();

            $this->response = Menus::create([
                'menu_order'    => ($request->menu_order) ? $request->menu_order : 0,
                'menu_header'   => $request->menu_header,
                'menu_name'     => $request->menu_name,
                'description'   => $request->description,
                'link'          => $request->link,
                'icon'          => $request->icon,
                'main_uuid'     => $request->main_uuid,
                'is_active'     => ($request->is_active) ? 'Aktif' : 'Tidak',
                'is_eksternal'  => ($request->is_eksternal) ? $request->is_eksternal : 'Tidak',
                'is_newtab'     => ($request->is_newtab) ? $request->is_newtab : 'Tidak',
                'is_backend'    => ($request->is_backend) ? $request->is_backend : 1,
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
     * @param  int  $uuid
     * @return \Illuminate\Http\Response
     */
    public function show($uuid)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $uuid
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $uuid)
    {
        //
        if (!$request->ajax()) {
            return redirect('');
        }
        $data = Menus::where('uuid', $uuid)->first();
        return view('rbac.menus.form', [
            'url'       => url('/menus/update/' . $uuid),
            'data'      => $data
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $uuid
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $uuid)
    {
        //
        try {
            if (!$request->ajax()) {
                return redirect('');
            }

            $validator = Validator::make($request->all(), [
                'menu_name'         => ['required'],
                'link'              => ['required', 'max:255'],
            ]);

            if ($validator->fails()) {
                throw new Exception(errorValidasi($validator->errors()));
            }

            DB::beginTransaction();

            $this->response = Menus::find($uuid)->update([
                'menu_order'    => ($request->menu_order) ? $request->menu_order : 0,
                'menu_header'   => $request->menu_header,
                'menu_name'     => $request->menu_name,
                'description'   => $request->description,
                'link'          => $request->link,
                'icon'          => $request->icon,
                'main_uuid'     => $request->main_uuid,
                'is_active'     => ($request->is_active) ? 'Aktif' : 'Tidak',
                'is_eksternal'  => ($request->is_eksternal) ? $request->is_eksternal : 'Tidak',
                'is_newtab'     => ($request->is_newtab) ? $request->is_newtab : 'Tidak',
                'is_backend'    => ($request->is_backend) ? $request->is_backend : 1,
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
     * @param  int  $uuid
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $uuid)
    {
        //
        try {
            if (!$request->ajax()) {
                return redirect('');
            }

            DB::beginTransaction();
            
            $this->response = Menus::find($uuid)->delete();

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

        $table = "SELECT 
                    icon, 
                    menu_name, 
                    submenu, 
                    description, 
                    uuid, 
                    link,
                    menu_header,
                    is_active
                FROM (SELECT
                        submenu.uuid,
                        CASE WHEN menus.menu_name IS NULL 
                            THEN submenu.menu_name 
                            ELSE menus.menu_name 
                        END AS menu_name,
                        CASE WHEN menus.menu_name IS NULL 
                            THEN '' 
                            ELSE submenu.menu_name 
                        END AS submenu,
                        submenu.description,
                        submenu.link,
                        submenu.icon,
                        submenu.is_active,
                        CASE WHEN menus.menu_header IS NULL 
                            THEN submenu.menu_header 
                            ELSE menus.menu_header 
                        END AS menu_header
                    FROM
                            menus
                    RIGHT JOIN menus AS submenu 
                            ON submenu.main_uuid = menus.uuid
                    WHERE
                            menus.main_uuid IS NULL
                    ) AS a ";

        $rawSql = DB::raw($table);
        $data  = DB::select($rawSql->getValue(DB::connection()->getQueryGrammar()));
        return DataTables::of($data)
            ->addColumn('icon', function ($data) {
                if (!$data->submenu) {
                    $btn = '<i class="' . $data->icon . '"></i>';
                } else {
                    $btn = '';
                }
                return $btn;
            })
            ->addColumn('btn', function ($data) {
                $name = ($data->submenu) ? $data->submenu : $data->menu_name;
                $btn = '<center>' .
                    '<div class="btn-group btn-group-sm" role="group" aria-label="Button Group">' .
                    '<button class="btn btn-info btn-sm waves-effect"' .
                    ' data-bs-toggle="modal"' .
                    ' data-title="Edit Data : ' . $name . '"' .
                    ' data-post-id="' . $data->uuid . '"' .
                    ' data-action-url="menus/edit/'.$data->uuid.'"' .
                    ' data-bs-target="#form-modal">' .
                    'Edit' .
                    '</button>' .
                    '<button class="btn btn-danger btn-sm waves-effect"' .
                    ' onclick="deleteData(\'' . $data->uuid . '\');">' .
                    'Hapus' .
                    '</button>' .
                    '</div>' .
                    '</center>';
                return $btn;
            })
            ->rawColumns(['btn', 'icon'])
            ->make(true);
    }

    public function getMainMenu(Request $request){
        $menus = Menus::whereNull('main_uuid')
                    ->where('link', '#')
                    ->get();
        return response()->json($menus);
    }
}
