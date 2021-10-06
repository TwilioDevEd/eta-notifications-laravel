# ETA Notifications for PHP - Laravel

[![Build Status](https://travis-ci.org/TwilioDevEd/eta-notifications-laravel.svg?branch=master)](https://travis-ci.org/TwilioDevEd/eta-notifications-laravel)

ETA notifications implementation with PHP - Laravel and Twilio.

### Run the application

1. Clone the repository and `cd` into it.
1. Install the application dependencies with [Composer](https://getcomposer.org/)

   ```bash
   composer install
   ```
1. The application uses PostgreSQL as persistence layer. If you
  don't have it already, you should install it. The easiest way is by
  using [Postgres.app](http://postgresapp.com/).

1. Create a database.

   ```bash
   createdb eta_notifications
   ```
5. Copy the sample configuration file and edit it to match your configuration.

   ```bash
   cp .env.example .env
   ```
   You can find your `TWILIO_ACCOUNT_SID` and `TWILIO_AUTH_TOKEN` under
   your [Twilio Account Settings](https://www.twilio.com/user/account/settings).

   You can buy Twilio phone numbers at [Twilio numbers](https://www.twilio.com/user/account/phone-numbers/search)
   `TWILIO_NUMBER` should be set to the phone number you purchased above.

1. Generating an `APP_KEY`:

   ```bash
   php artisan key:generate
   ```
1. Running the migrations:

   ```bash
   php artisan migrate
   ```

1. Modifying the seed data:

   We have provided a name and phone number as example in the seed data. In order for the application to send sms
   notifications, you must edit this seed data providing a valid phone number where you want to receive the sms
   notifications.

   In order to do this, you must modify
   [this file](https://github.com/TwilioDevEd/eta-notifications-laravel/blob/master/database/seeds/OrdersTableSeeder.php)
   that is located at: `project-root/database/seeds/OrdersTableSeeder.php`

1. Seeding the database:

   ```bash
   php artisan db:seed
   ```

1. Expose your application to the wider internet using ngrok. You can look
   [here](#expose-the-application-to-the-wider-internet) for more details. This step is important because the
   application won't work as expected if you run it through the localhost.

   ```bash
   ngrok http 8000
   ```

1. Running the application using Artisan.

   ```bash
   php artisan serve
   ```

Now you can access the application at your ngrok subdomain that should look something like
this: `http://<subdomain>.ngrok.io`

### Exposing the Application to the Wider Internet

If you want your application to be accessible from the internet, you can either forward the necessary ports in your
router, or use a tool like
[ngrok](https://ngrok.com/) that will expose your local host to the internet.

You can read [this blog](https://www.twilio.com/blog/2015/09/6-awesome-reasons-to-use-ngrok-when-testing-webhooks.html)
for more details on how to use ngrok, but if you are using version 2.x, exposing a specific port should be easily done
with the following command:

```bash
ngrok http 8000
```

### Dependencies

This application uses this Twilio helper library:

* [twilio-php](https://github.com/twilio/twilio-php)

### Running the tests

1. Running at the top-level directory:

   ```bash
   phpunit
   ```
   If you don't have phpunit installed on your system, you can
   follow [these instructions](https://phpunit.de/manual/current/en/installation.html) to install it.
