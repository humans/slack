# Case Study: Slack

The case study of building Slack with Laravel and Vue.js.

You can read the full write up here:
- [Overview](https://medium.com/@jaggygauran/case-study-slack-with-laravel-vue-js-overview-837b49c70c3e)
- Backend (coming soon)
- Frontend (coming soon)

## Installation

If you wanna host it on your own to see how it works, just follow the instructions.

Be warned though, I'm writing the instructions at 2 in the morning, things ~might~ will go wrong.

### Pusher

Create a [Pusher](https://pusher.com) account.

Make sure your `.env` variables are all set. Keep track of that cluster!

```
PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_CLUSTER=
```

Also, change your pusher settings in `resources/assets/js/bootstrap.js`. I committed mine but, ¯\_(ツ)_/¯, add your key and cluster right there too.

```
Vue.prototype.$echo = window.echo = new Holler({
  broadcaster: 'pusher',
  key: '',
  cluster: '',
});
```

### Backend

#### Seeding

I didn't really make a registration form for creating teams (sorry for that), so you'll either have to use `php artisan tinker`, or modify `database/seeds/TeamsTableSeeder.php` and add your preferred subdomain to make things work.

#### Setting up

Don't forget to run composer.

```
$ composer install
```

Also, we'll have to migrate the database, seed it, and set up Passport's defaults.

```
$ php artisan:fresh --seed && art passport:install
```

#### Hosting

I'm running the app via [Laravel Valet](https://laravel.com/docs/master/valet).

To link to the subdomains you'll be testing out, go to the project root and run `valet link <subdomain>.slack.dev`.

You _should_ be able to access the registration form from there.

### Frontend

I don't think there'll be anything special here other than running yarn. _I think_.

```
$ yarn
$ yarn run dev
```
