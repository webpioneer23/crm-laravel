<?php

namespace App\Http\Controllers;

use App\Models\Complex;
use Illuminate\Http\Request;

class ComplexController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('complex/list');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('complex/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Complex $complex)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Complex $complex)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Complex $complex)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Complex $complex)
    {
        //
    }
}
