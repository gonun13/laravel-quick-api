# laravel-quick-api
Quick API for Kununu test 
(Tested on a fresh Ubuntu 18 only with docker and docker compose)

Steps to install (requires sudo level)

```
git clone git@github.com:gonun13/laravel-quick-api.git

cd laravel-quick-api

./start
```

Running start will: install laravel and all vendor dependencies, set permissions, fire docker, prepare laravel and run migrations

## How to test

A number of Curl calls are available for testing all features.

`./tests/curls/curl_loadData`
Run this first to move data.json into mysql database.

`./tests/curls/curl_showCompanies`
This will list all companies with respective average ratings

`./tests/curls/curl_showCompany`
This will list one company with all its reviews

`./tests/curls/curl_addReview`
This will add an extra review to a company

`./tests/curls/curl_showHighLow`
This will list the highest and lowest rated review for a company (required Enhancement)

## Questions

* How much test-coverage is desirable?
100%.

* What parts of your example do you like the least? 
Did not move some business logic into helper classes. Yet.

* How would you describe your coding style? What makes your code clean? Can you point out an example?
Organize by stages. Proper identation, proper whitespace, consistency. 
```
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
 ```

* 
* 
*
