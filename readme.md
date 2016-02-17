# ETA Notifications for PHP - Laravel
[![Build Status](https://travis-ci.org/TwilioDevEd/eta-notifications-laravel.svg?branch=master)](https://travis-ci.org/TwilioDevEd/eta-notifications-laravel)

ETA notifications implementation with PHP - Laravel and Twilio.

### Run the application

1. Clone the repository and `cd` into it.
1. Install the application's dependencies with [Composer](https://getcomposer.org/)

   ```bash
   $ composer install
   ```
1. The application uses PostgreSQL as the persistence layer. If you
  don't have it already, you should install it. The easiest way is by
  using [Postgres.app](http://postgresapp.com/).
1. Create a database.

  ```bash
  $ createdb eta_notifications
  ```
1. Copy the sample configuration file and edit it to match your configuration.

   ```bash
   $ cp .env.example .env
   ```

  You can find your `TWILIO_ACCOUNT_SID` and `TWILIO_AUTH_TOKEN` under
  your
  [Twilio Account Settings](https://www.twilio.com/user/account/settings).

  You can buy Twilio phone numbers at [Twilio numbers](https://www.twilio.com/user/account/phone-numbers/search)
  `TWILIO_NUMBER` should be set to the phone number you purchased above.
1. Generate an `APP_KEY`:

   ```bash
   $ php artisan key:generate
   ```
1. Run the migrations:

  ```bash
  $ php artisan migrate
  ```
1. Load the seed data:

  ```bash
  $ php artisan db:seed
  ```

  We have provided an example name and phone number in the seed data. In order for
  the application to send sms notifications, you must edit this seed data providing
  a real phone number where you want to receive the sms notifications.

  In order to do this, you must modify
  [this file](https://github.com/TwilioDevEd/eta-notifications-laravel/blob/master/database/seeds/OrdersTableSeeder.php)
  that is located at:

  ```
  project-root/database/seeds/OrdersTableSeeder.php
  ```

1. Run the application using Artisan.

  ```bash
  $ php artisan serve
  ```

  now you can access the application at http://localhost:8000

### Dependencies

This application uses this Twilio helper library:
* [twilio-php](https://github.com/twilio/twilio-php)

### Run the tests

1. Run at the top-level directory:

   ```bash
   $ phpunit
   ```
   If you don't have phpunit installed on your system, you can follow [this
   instructions](https://phpunit.de/manual/current/en/installation.html) to
   install it.
