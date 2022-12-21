<?php

namespace App\Http\Controllers;

use App\Models\Lending;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class LendingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $laptops=Lending::all();
        $hari=\Carbon\Carbon::now()->format('Y-m-d');
        $kemarin=\Carbon\Carbon::yesterday()->format('Y-m-d');
        return view('home.index', compact('laptops', 'hari', 'kemarin')); 
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
        $request->validate([
            'name'=>'required',
            'purposes'=>'required',
            'description'=>'required',
            'nis'=>'required|max:8',
            'rayon'=>'required',
            'date'=>'required',
            'teacher'=>'required',
        ],[
            'nis.max' => "Nis harus dibawah dari 8"
        ]);
        Lending::create([
            'nis'=>$request->nis,
            'name'=>$request->name,
            'rayon'=>$request->rayon,
            'purposes'=>$request->purposes,
            'description'=>$request->description,
            'date'=>$request->date,
            'teacher'=>$request->teacher,
        ]);
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Lending  $lending
     * @return \Illuminate\Http\Response
     */
    public function show(Lending $lending)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Lending  $lending
     * @return \Illuminate\Http\Response
     */
    public function edit(Lending $lending)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Lending  $lending
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        Lending::where('id', $id)->update([
            'return_date'=>\Carbon\Carbon::now()
        ]);
        return redirect ()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Lending  $lending
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Lending::where('id', $id)->delete();
        return redirect ()->back();
    }
}
