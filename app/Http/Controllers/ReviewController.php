<?php

namespace App\Http\Controllers;

use App\Company;
use App\Review;
use App\Rating;
use App\Http\Resources\ReviewResource;
use Illuminate\Http\Request;

class ReviewController extends Controller
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Company $company)
    {
        // add review to existing company
        $company = $company->find($request->company_id);
        if ($company->exists)
        {
            // only one review per user for this company
            $review = Review::firstOrCreate(
                ['user' => $request->user],
                [
                    'company_id' => $company->id,
                    'title' => $request->title,
                    'pro' => $request->pro,
                    'contra' => $request->contra,
                    'suggestions' => $request->suggestions,
                ]
            );
            // if insert goes well, add rating
            if ($review->exists && is_array($request->rating))
            {
                $rating = Rating::firstOrCreate(
                    ['review_id' => $review->id],
                    [
                        'culture' => $request->rating['culture'],
                        'management' => $request->rating['management'],
                        'work_live_balance' => $request->rating['work_live_balance'],
                        'career_development' => $request->rating['career_development'],
                    ]
                );
            }
            return new ReviewResource($review);
        }
        else
        {
            return response()->json(['error'=>'Company does not exist'], 403);
        }
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
