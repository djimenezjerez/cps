<?php

namespace App\Http\Controllers;

use App\Models\Year;
use App\Models\Credential;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\StoreYearRequest;
use App\Http\Requests\UpdateYearRequest;

class YearController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'credential_id' => ['required', 'integer', 'exists:credentials,id'],
        ]);
        $credential = Credential::find($request->credential_id);
        return response()->json([
            'message' => 'Lista de registros',
            'payload' => $credential->years,
        ]);
    }

    public function show(Year $year)
    {
        $business = $year->credential->business;
        unset($year->credential->business);
        $credential = $year->credential;
        unset($year->credential);
        return response()->json([
            'message' => 'Detalle del registro',
            'payload' => [
                'year' => $year,
                'credential' => $credential,
                'business' => $business,
            ],
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Year $year)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateYearRequest $request, Year $year): RedirectResponse
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Year $year): RedirectResponse
    {
        //
    }
}
