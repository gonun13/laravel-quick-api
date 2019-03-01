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
        // build companies with ratings
        $results = array();
        $companies = Company::all();
        foreach ($companies as $company)
        {
            $ratings = $company->find($company->id)->ratings;
            $company->avgCulture = round($ratings->avg('culture'), 2);
            $company->avgManagement = round($ratings->avg('management'), 2);
            $company->avgWork_live_balance = round($ratings->avg('work_live_balance'), 2);
            $company->avgCareer_development = round($ratings->avg('career_development'), 2);
            $results[] = $company;
        }
        return $results;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $company_count = $review_count = 0;
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
            // gather some stats for response
            if ($company->wasRecentlyCreated) 
            {
                $company_count++;
            }
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
                    // gather some stats for response
                    if ($review->wasRecentlyCreated) 
                    {
                        $review_count++;
                    }
                    // insert rating into review (only one rating per review)
                    if ($review->exists && is_array($reviewData['rating']))
                    {
                        $rating = Rating::firstOrCreate(
                            ['review_id' => $review->id],
                            [
                                'culture' => $reviewData['rating']['culture'],
                                'management' => $reviewData['rating']['management'],
                                'work_live_balance' => $reviewData['rating']['work_live_balance'],
                                'career_development' => $reviewData['rating']['career_development'],
                            ]
                        );
                    }
                }
            }
        }
        return response()->json(['companiesInserted'=>$company_count, 'reviewsInserted'=>$review_count], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
        return new CompanyResource($company);
    }

    /**
     * Display the highest and lowest
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function highlow(Request $request)
    { 
        $reviews = Review::with('rating')->where('company_id', $request->company_id)->get();
        // find highest and lowest rated review
        $high = $low = 0;
        $highest = $lowest = new Review();
        foreach ($reviews as $review)
        {
            $total = $review->rating['culture'] + $review->rating['management'] + $review->rating['work_live_balance'] + $review->rating['career_development'];
            if (!$low) $low = $total;
            if ($total > $high) 
            {
                $high = $total;
                $highest = $review;
            }
            else if ($total < $low)
            {
                $low = $total;
                $lowest = $review;
            }
        }
        return array("highestReview"=>$highest, "lowestReview"=>$lowest);
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
        return CompanyResource::cfind($id);
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
