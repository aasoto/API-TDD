<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContractorCompany\StoreRequest;
use App\Http\Requests\ContractorCompany\UpdateRequest;
use App\Models\ContractorCompany;
use Illuminate\Http\Request;

class ContractorCompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(ContractorCompany::with('country')->paginate(10));
    }

    /**
     * Display a listing of the resource without pagination.
     *
     * @return \Illuminate\Http\Response
     */
    public function all()
    {
        return response()->json(ContractorCompany::select('id', 'business_name')->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        return response()->json(ContractorCompany::create($data));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ContractorCompany  $contractorCompany
     * @return \Illuminate\Http\Response
     */
    public function show(ContractorCompany $contractorCompany)
    {
        $result = ContractorCompany::find($contractorCompany->id);
        return response()->json($result);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ContractorCompany  $contractorCompany
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, ContractorCompany $contractorCompany)
    {
        $contractorCompany->update($request->validated());
        return response()->json($contractorCompany);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ContractorCompany  $contractorCompany
     * @return \Illuminate\Http\Response
     */
    public function destroy(ContractorCompany $contractorCompany)
    {
        $contractorCompany->delete();

        $response = json_decode('{"status":"delete"}');
        return response()->json($response);
    }
}
