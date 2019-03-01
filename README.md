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

# How to test

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

