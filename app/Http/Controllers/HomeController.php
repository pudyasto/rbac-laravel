<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        // $routeCollection = Route::getRoutes();
        // foreach ($routeCollection as $value) {
        //     if (strpos($value->uri, '/') !== false) {
        //         $path = explode('/', $value->uri);

        //         $str = " \ ";
        //         if(isset($value->action['middleware']) && $value->action['middleware']){
        //             if(in_array('can:Access', $value->action['middleware'])){
        //                 if (isset($value->action['controller']) && strpos($value->action['controller'], "App") !== false) {
        //                     $arr = explode(trim($str), $value->action['controller']);
        //                     if (isset($arr[3])) {
        //                         var_dump($value->action['middleware']);
        //                         echo '<br>';
        //                         var_dump($path[0]);
        //                         echo '<br>';
        //                     }
        //                 }
        //             }
        //         }
        //     }
        // }
        // // 
        return view('home.index', []);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
    public function edit($id)
    {
        //
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
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
