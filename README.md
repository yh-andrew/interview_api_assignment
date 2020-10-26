# API assignment

The assignment:
https://docs.google.com/document/d/14OTW2RfQ6xS57deDnENW7FEdGd8j2b3A-b5iujYL_sA/edit

I code the API with PHP and Laravel 8 as the framework.
I used Homestead with vagrant to develop this app.

In order to run the code, remember to change the setting in ```.env```, such as, database login, url, etc. 

## Creating the Database

Code: ```api/database/migrations/2020_10_26_062853_create_accounts_table.php```

Creates the SQL table called accounts which has two fields: ```account```, and ```password```.

## Routing and processing the request
Code: ```api/routes/web.php```

The app is simple enough to not need a Laravel controller class.
Each API is implemented as a function. See comments in the code for detail.
