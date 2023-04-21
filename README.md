# News Aggregator API

This is an API that aggregates news from multiple sources.

## Setup Instructions

**Requirements:**

> - PHP >= 8.1
> - Composer >= 2.4.3
> - MySQL >= 8.0

**Step 1:** Clone the repository in your terminal using `https://github.com/victorive/news-aggregator-api.git`

**Step 2:** Enter the project’s directory using `cd news-aggregator-api`

**Step 3:** Run `composer install` to install the project’s dependencies.

**Step 4:** Run `cp .env.example .env` to create the .env file for the project’s configuration
and `cp .env.example .env.testing` to create the .env file for the testing environment.

**Step 5:** Run `php artisan key:generate` to set the application key.

**Step 6:** Create a database with the name **news_aggregator-api** or any name of your choice in your current database
server and configure the DB_DATABASE, DB_USERNAME and DB_PASSWORD credentials respectively, in the .env files located in
the project’s root folder. eg.

> DB_DATABASE={{your database name}}
>
> DB_USERNAME= {{your database username}}
>
> DB_PASSWORD= {{your database password}}

**Step 7:** Generate API keys from NewsAPI.org, The Guardian and NY Times and configure them in both `.env` files.

**Step 8:** Run `php artisan migrate` to create your database tables. This command also seeds your database with some
required data and calls the scheduled commands to fetch data from the various news services as a result of
the `MigrationEnded` event that fires when the migration is completed.

**Step 9:** Setup `php artisan schedule:work` to run the commands to fetch data from various news services at
intervals. By default, it is configured to run every thirty minutes.

**Step 10:** Run `php artisan serve` to serve your application, then use the link generated to access the API via any
API testing software of your choice.

**Step 11:** To run the test suites, make sure you have configured the testing environment using the `.env.testing` file
generated earlier, then run `php artisan test` to test.

Here's the link to the API documentation on [Postman](https://documenter.postman.com/)

Feel free to fork the repo, make any changes or report any issues, and submit a PR. Happy coding!


