# Slack

This is a small case study on building something like Slack with Laravel and Vue.js.

## Installation

### Pusher

First, we have to create our own [Pusher](https://pusher.com) account.

Create an application, keep track of the cluster, we'll need that.

### Backend

```
$ composer install
$ php artisan:fresh --seed && art passport:install
```

### Frontend
```
$ yarn
$ yarn run watch
```
