<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use App\Http\Requests\CustomerRequest;
use Illuminate\Http\Request;


class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    //debug . too few arguments 
public function update(CustomerRequest $request)
{
    $customer = $request->user()->customer;
    
    if (!$customer) {
        return apiFail('Customer profile not found', 404);
    }

    $data = $request->validated();

    if ($request->hasFile('avatar')) {

        if ($customer->avatar) {
            Storage::delete("customer-avatars/{$customer->avatar}");
        }

        $filename = time() . "." . $request->file('avatar')->extension();

        $request->file('avatar')->storeAs('customer-avatars', $filename);

        $data['avatar'] = $filename;
    }

    $customer->update($data);

    return apiSuccess('customer updated successfully', $customer);
}
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
