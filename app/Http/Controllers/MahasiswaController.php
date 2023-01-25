<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\Prodi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $prodis = Prodi::get();
        return view('pages.users.dashboard.modal', ['mahasiswa'=> new Mahasiswa, 'prodis' => $prodis]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreMahasiswaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|max:100',
            'semester' => 'required',
            'nim' => 'required|max:10|unique:mahasiswas,nim',
            'email' => 'required|unique:users,email',
            'kelas' => 'required',
            'tahun' => 'required',
            'prodi' => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            if ($errors->has('nama')) {
                return response()->json([
                    'alert' => 'error',
                    'message' => $errors->first('nama'),
                ]);
            }else if($errors->has('nim')){
                return response()->json([
                    'alert' => 'error',
                    'message' => $errors->first('nim'),
                ]);
            }else if($errors->has('email')){
                return response()->json([
                    'alert' => 'error',
                    'message' => $errors->first('email'),
                ]);
            }else if($errors->has('kelas')){
                return response()->json([
                    'alert' => 'error',
                    'message' => $errors->first('kelas'),
                ]);
            }else if($errors->has('tahun')){
                return response()->json([
                    'alert' => 'error',
                    'message' => $errors->first('tahun'),
                ]);
            }else if($errors->has('prodi')){
                return response()->json([
                    'alert' => 'error',
                    'message' => $errors->first('prodi'),
                ]);
            }
        }
        $mahasiswa = new Mahasiswa;
        $user = new User;
        $user->nama = $request->nama;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();
        $mahasiswa->user_id = $user->id;
        $mahasiswa->nim = $request->nim;
        $mahasiswa->kelas = $request->kelas;
        $mahasiswa->semester = $request->semester;
        $mahasiswa->tahun = $request->tahun;
        $mahasiswa->prodi = $request->prodi;
        $mahasiswa->save();
        return response()->json([
            'alert' => 'success',
            'message' => 'Mahasiswa '. $request->nama . ' Saved',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Mahasiswa  $mahasiswa
     * @return \Illuminate\Http\Response
     */
    public function show(Mahasiswa $mahasiswa)
    {
        return view('pages.users.dashboard.show', compact('mahasiswa'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Mahasiswa  $mahasiswa
     * @return \Illuminate\Http\Response
     */
    public function edit(Mahasiswa $mahasiswa)
    {
        $prodis = Prodi::get();
        return view('pages.users.dashboard.modal', ['mahasiswa'=> $mahasiswa, 'prodis' => $prodis]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMahasiswaRequest  $request
     * @param  \App\Models\Mahasiswa  $mahasiswa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Mahasiswa $mahasiswa)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|max:100',
            'semester' => 'required',
            'nim' => 'required|max:10|unique:mahasiswas,nim,' .$mahasiswa->id,
            'kelas' => 'required',
            'tahun' => 'required',
            'prodi' => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            if ($errors->has('nama')) {
                return response()->json([
                    'alert' => 'error',
                    'message' => $errors->first('nama'),
                ]);
            }else if($errors->has('nim')){
                return response()->json([
                    'alert' => 'error',
                    'message' => $errors->first('nim'),
                ]);
            }else if($errors->has('kelas')){
                return response()->json([
                    'alert' => 'error',
                    'message' => $errors->first('kelas'),
                ]);
            }else if($errors->has('tahun')){
                return response()->json([
                    'alert' => 'error',
                    'message' => $errors->first('tahun'),
                ]);
            }else if($errors->has('prodi')){
                return response()->json([
                    'alert' => 'error',
                    'message' => $errors->first('prodi'),
                ]);
            }
        }
        $user = User::where('id', $mahasiswa->user_id)->first();
        $user->nama = $request->nama;
        $user->save();
        $mahasiswa->nim = $request->nim;
        $mahasiswa->kelas = $request->kelas;
        $mahasiswa->tahun = $request->tahun;
        $mahasiswa->semester = $request->semester;
        $mahasiswa->prodi = $request->prodi;
        $mahasiswa->update();
        return response()->json([
            'alert' => 'success',
            'message' => 'Mahasiswa '. $request->nama . ' Updated',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Mahasiswa  $mahasiswa
     * @return \Illuminate\Http\Response
     */
    public function destroy(Mahasiswa $mahasiswa)
    {
        $user = User::where('id',$mahasiswa->user_id)->first();
        $user->delete();
        $mahasiswa->delete();
        return response()->json([
            'alert' => 'success',
            'message' => 'Mahasiswa '. $mahasiswa->nama . ' Dihapus',
        ]);
    }
}
