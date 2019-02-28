<?php

namespace App\Http\Controllers;

use App\Company;
use App\Review;
use App\Rating;
use App\Http\Resources\CompanyResource;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * secure endpoint
     */
    public function __construct()
    {
        //$this->middleware('auth:api')->except(['index', 'show']);
        // $this->middleware('auth:api');
    }

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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // insert all companies
        foreach($request->companies as $companyData)
        {
            // insert new company (by slug)
            $company = Company::firstOrCreate(
                ['slug' => $companyData['slug']],
                [
                    'name' => $companyData['name'],
                    'city' => $companyData['city'],
                    'country' => $companyData['country'],
                    'industry' => $companyData['industry'],
                ]
            );
            // insert reviews for company
            if ($company->exists && is_array($companyData['reviews']))
            {
                foreach($companyData['reviews'] as $reviewData)
                {
                    // insert only one review per company/user
                    $review = Review::firstOrCreate(
                        [
                            'user' => $reviewData['user'],
                            'company_id' => $company->id,
                        ],
                        [
                            'title' => $reviewData['title'],
                            'pro' => $reviewData['pro'],
                            'contra' => $reviewData['contra'],
                            'suggestions' => $reviewData['suggestions'],
                        ]
                    );
                }
            }
        }
        return new CompanyResource($company);
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
