<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManagerStatic as Image;

class UsersController extends Controller
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
        return view('rbac.users.index', []);
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

        return view('rbac.users.form', [
            'url'           => url('/users/store'),
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
                'name'          => ['required', 'string', 'max:255'],
                'gender'        => ['required', 'string', 'max:10'],
                'username'      => ['required', 'string', 'max:15', 'unique:users'],
                'email'         => ['required', 'string', 'email', 'max:255', 'unique:users'],
            ]);

            if ($validator->fails()) {
                throw new Exception(errorValidasi($validator->errors()));
            }

            DB::beginTransaction();

            $this->response = User::create([
                'nik'               => $request->username,
                'name'              => $request->name,
                'username'          => $request->username,

                'gender'            => $request->gender,
                'status'            => $request->status,

                'email'             => $request->email,
                'password'          => Hash::make($request->password),

                'email_verified_at' => date('Y-m-d H:i:s'),
            ]);

            $uuid = $this->response->uuid;
            $this->uploadPhoto($uuid, $request);

            // Submit role pengguna
            $this->submitRole($this->response, $request);

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
        $data = User::with('roles')->where('uuid', $uuid)->first();
        return view('rbac.users.form', [
            'url'           => url('/users/update/' . $uuid),
            'data'          => $data
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
                'name'          => ['required', 'string', 'max:255'],
                'gender'        => ['required', 'string', 'max:10'],
                'username'      => ['required', 'string', 'max:15', Rule::unique('users')->where(function ($query) use ($request) {
                    return $query->where('uuid', '<>', $request->uuid);
                })],
                'email'         => ['required', 'string', 'email', 'max:255', Rule::unique('users')->where(function ($query) use ($request) {
                    return $query->where('uuid', '<>', $request->uuid);
                })],
            ]);

            if ($validator->fails()) {
                throw new Exception(errorValidasi($validator->errors()));
            }

            DB::beginTransaction();
            $this->response = User::find($uuid)->update([

                'nik'               => $request->username,
                'name'              => $request->name,
                'username'          => $request->username,

                'gender'            => $request->gender,
                'status'            => $request->status,

                'email'             => $request->email,
            ]);

            $this->uploadPhoto($uuid, $request);
            
            // Submit role pengguna
            $user = User::where('uuid', $uuid)->first();
            $this->submitRole($user, $request);

            if ($request->password) {
                // Jika password diisi maka update password
                User::find($uuid)->update([
                    'password'  => Hash::make($request->password),
                ]);
            }

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

            $this->response = User::find($uuid)->delete();

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

        $data  = User::get();
        return DataTables::of($data)
            ->addColumn('btn', function ($data) {
                $btn = '<center>' .
                    '<div class="btn-group btn-group-sm" role="group" aria-label="Button Group">' .
                    '<button class="btn btn-info btn-sm waves-effect"' .
                    ' data-bs-toggle="modal"' .
                    ' data-title="Edit Data : ' . $data->name  . '"' .
                    ' data-post-id="' . $data->uuid . '"' .
                    ' data-action-url="users/edit/' . $data->uuid . '"' .
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
            ->rawColumns(['btn'])
            ->make(true);
    }

    private function submitRole($user, $request)
    {
        DB::table('model_has_roles')->where('model_uuid', $user->uuid)->delete();
        if (is_array($request->role_id) && count($request->role_id) > 0) {
            $user = User::find($user->uuid);
            $user->assignRole([$request->role_id]);
        }
    }
    
    private function uploadPhoto($uuid, $request)
    {
        $photo = null;
        if ($request->hasFile('photo')) {
            if ($request->file('photo')->isValid()) {
                $avatar = Config::get('storage.avatar');
                if (!File::exists($avatar)) File::makeDirectory($avatar, 0777, true);

                $file = $request->file('photo');
                $image = 'emp-' . $request->username . '.' . $file->getClientOriginalExtension();

                //Resize Function
                $image_resize = Image::make($file->getRealPath());

                $height = $image_resize->height();
                $width = $image_resize->width();

                $newWidth = 250;
                $newHeight = 250;
                $image_resize->resize($newWidth, $newHeight, function ($constraint) {
                    $constraint->aspectRatio();
                });

                $image_resize->save($avatar . '/' . $image);

                $photo = base64_encode(file_get_contents($avatar . '/' . $image));

                array_map('unlink', glob($avatar . "/emp-*"));
            }
        }
        User::find($uuid)->update([
            'photo' => $photo
        ]);
    }
}
