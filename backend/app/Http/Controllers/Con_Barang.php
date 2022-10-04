<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Http\Resources\Res_Barang;
use Illuminate\Support\Facades\File;
// use Validator;

class Con_Barang extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $barang = Barang::all(); //SQL
        $res_barang = Res_Barang::collection($barang); //filter

        // return response()->json([$barang, $res_barang], 200);
        return response()->json($barang, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $req = $request->all();

        $validator = $request->validate([
            'nama' =>'required',
            'deskripsi' =>'required',
            'harga' =>'required',
            'stok' =>'required',
            'gambar' =>'required:mimes:png,jpg,jpeg|max:2048',
        ]);

        if($validator==false){
            return response()->json('semua data harus diisi', 404);
        }

        $req = $request->all();

        $req_img = $request->gambar;
        $nama_file = uniqid().'.'.$req_img->getClientOriginalExtension();
        $req_img->move(public_path().'/gambar', $nama_file);
        $req['gambar']=$nama_file;

        // $req = $request->all();
        $barang = Barang::create($req);

        return response()->json(new Res_Barang($barang), 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $barang = Barang::find($id);

        return response()->json(new Res_Barang($barang), 200);
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
        $validator = $request->validate([
            'nama' =>'required',
            'deskripsi' =>'required',
            'harga' =>'required',
            'stok' =>'required',
            'gambar' =>'required:mimes:png,jpg,jpeg|max:2048',
        ]);

        if($validator==false){
            return response()->json('semua data harus diisi', 404);
        }

        $barang = Barang::find($id);
        $req = $request->all();

        $barang->nama = $req['nama'];
        $barang->deskripsi = $req['deskripsi'];
        $barang->harga = $req['harga'];
        $barang->stok = $req['stok'];
        if($barang->gambar != $req['gambar']){
            File::delete(public_path().'/gambar/'. $barang->gambar);
            $req_img = $request->gambar;
            $nama_file = uniqid().'.'.$req_img->getClientOriginalExtension();
            $req_img->move(public_path().'/gambar', $nama_file);
            // $nama_file = uniqid().'.'.$req['gambar']->getClientOriginalExtension();
            // $req['gambar']->move(public_path().'/gambar', $nama_file);
            // $req['gambar']=$nama_file;
            $barang->gambar = $nama_file;
        }
        else{
            $barang->gambar = $req['gambar'];
        }
        $barang->save();

        // $barang->gambar = $req['gambar'];
        // $nama_file = uniqid().'.'.$req_img->getClientOriginalExtension();
        // $req_img->move(public_path().'/gambar', $nama_file);
        // $req['gambar']=$nama_file;


        return response()->json(new Res_Barang($barang), 200);
        // return response()->json($req['gambar'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $barang = Barang::find($id);
        $req_img = $barang->gambar;
        // $nama_file = uniqid().'.'.$req_img->getClientOriginalExtension();
        File::delete(public_path().'/gambar/'. $req_img);
        // $req['gambar']=$nama_file;

        
        $barang->delete();

        return response()->json([], 200);
    }
}
