# Use the latest Wunderlist API version in your apps.
[![Latest Stable Version](https://poser.pugx.org/johnrivs/wunderlist/v/stable)](https://packagist.org/packages/johnrivs/wunderlist) [![Total Downloads](https://poser.pugx.org/johnrivs/wunderlist/downloads)](https://packagist.org/packages/johnrivs/wunderlist) [![License](https://poser.pugx.org/johnrivs/wunderlist/license)](https://packagist.org/packages/johnrivs/wunderlist) [![Endpoint coverage](http://progressed.io/bar/45?title=progress)](#progress )

[http://johnrivs.github.io/wunderlist](http://johnrivs.github.io/wunderlist )

- [How to use](#how-to-use )
    - [Register your app](#register-your-app )
    - [Install the package](#install-the-package )
    - [Build up the client](#build-up-the-client )
    - [Authorization](#authorization )
- [FAQ](#faq )
    - [What exactly is this pacakage?](#what-exactly-is-this-pacakage )
    - [How flexible is this package?](#how-flexible-is-this-package )
    - [What should I expect from the Wunderlist API?](#what-should-i-expect-from-the-wunderlist-api )
    - [How does it look like?](#how-does-it-look-like )
    - [How do I provide data?](#how-do-i-provide-data )
    - [Why do some methods take more time than others?](#why-do-some-methods-take-more-time-than-others )
    - [Why does it say Forbidden during authentication?](#why-does-it-say-forbidden-during-authentication )
    - [What if something goes wrong?](#what-if-something-goes-wrong )
- [Progress](#progress )

## How to use?
##### Register your app
First of all, you need to register your app. To do that, go [here](https://developer.wunderlist.com/apps ), log in and click on the blue button that says 'CREATE APP'. Wunderlist will ask you about the name of the app, the description, an icon to represent the app, the URL where it is located and the callback URL for authorization.

If your app is not yet hosted on the Internet, set both the URL fields to `http://localhost`. You're only going to need a 'real' auth callback url when you need to set up authorization (more about this later).

##### Install the package
This package may be installed through [Composer](https://getcomposer.org/download/ ):
```
composer require johnrivs/wunderlist
```
If you're using a framework, everything in your `vendor` directory is most likely autoloaded for you. Otherwise, pull in the file yourself:
```php
<?php

require_once __DIR__.'/path/to/vendor/autoload.php';
```

##### Build up the client
Go back to [apps page](https://developer.wunderlist.com/apps ) and copy your app's 'CLIENT ID', 'CLIENT SECRET' and access token, which you can generate by clicking on 'CREATE ACCESS TOKEN':
```php
<?php 

use JohnRivs\Wunderlist\Wunderlist;

$clientId     = 'THE_CLIENT_ID';
$clientSecret = 'THE_CLIENT_SECRET';
$accessToken  = 'THE_ACCESS_TOKEN';

$w = new Wunderlist($clientId, $clientSecret, $accessToken);

$w->getCurrentUser();
```

##### Authorization
For some methods (mostly the ones where you need to write, update or delete data), you're going to need a user access token. Up until this point you've only had the app access token, which you can use for yourself.

First, redirect the user to Wunderlist, where they need to grant access to your app. Wunderlist needs 2 things: a random string passed to it and the callback URL. Make sure you temporarily save said random string (in a file or session):
```php
$state = md5(time());

// Store the $state to retrieve it later

// Redirect the user to:
$w->authUrl($state, 'http://your-domain.com/auth/callback')
```
**Note: the URL you provide must be the same you set as your [app](https://developer.wunderlist.com/apps ) auth callback url.**

If you're working locally, I recommend using [ngrok](https://ngrok.com/ ):
- Spin up an HTTP server. In PHP via terminal `php -S localhost:8000`
- Create the tunnel: `ngrok http localhost:8000`. It'll tell you where your website is publicly available, something like `http://96d15c39.ngrok.io`
- Go to the [apps page](https://developer.wunderlist.com/apps ) and set the auth callback url to `http://96d15c39.ngrok.io/auth/callback` or whatever you got.
- Use the same URL in your code: `$w->authUrl($state, 'http://96d15c39.ngrok.io/auth/callback')`

**Ngrok gives you a different URL everytime you create the tunnel, so you'll need to update the auth callback url for your app and the one you provide to `authUrl()`.**

Once the user grants access to your app, he's going to be redirected to the callback URL carrying a `code` and the `state`. It would look like `http://96d15c39.ngrok.io/auth/callback?code=random_string&state=the_state_from_the_previous_step`. Now retrieve the `$state` from earlier and compare it to `$_GET['state']`. If they're the same:
```php
$accessToken = $w->getAuthToken($_GET['code']);
```
And that's the user's access token.

## FAQ
##### What exactly is this pacakage?
This package is a wrapper for each endpoint in the Wunderlist API. To know what attributes you need to provide to each method, the data it returns or what status code is set, head over to the [official Wunderlist API documentation](https://developer.wunderlist.com/documentation ).

##### How flexible is this package?
Since this package doesn't perform validation or sanitization, you can provide any attribute to (almost) every method. However, it'll check if the attributes contain the fields required by the endpoint. If you provide unrecognized attribute fields, they will be ignored. Again, to know what fields should be present in the attributes for a Wunderlist API endpoint, have a look at the [official Wunderlist API documentation](https://developer.wunderlist.com/documentation ).

##### What should I expect from the Wunderlist API?
Arrays most of the time. Some methods (such as `deleteTask()`) will return a status code. You can always use `getStatusCode()` regardless of what the method returned.

##### How does it look like?
In the current interation of this package, (almost) each method maps to a Wunderlist API endpoint. In the future, I might turn the interface to a more fluent one.
Right now, this is how the interface looks:
```php
// Get all tasks for a given list
$wunderlist->getTasks(['list_id' => 9876]);

// Get all lists
$wunderlist->getLists();
```
In the future, it'd look like this:
```php
// Get all tasks for a given list
$wunderlist->lists()->find(9876)->tasks()->all();

// Get the first task of each list
$wunderlist->lists()->all()->tasks()->first();
```
If you've ever used [Laravel's Eloquent](http://laravel.com/docs/5.1/eloquent ), you can probably see where I'd take the inspiration from..

##### How do I provide data?
For most methods you'll need to provide an array of attributes, however, for certain ones you'll need to supply some value(s). Check the [API Docs](http://johnrivs.github.io/wunderlist/api-docs/index.html ) out to know what each method expects.

##### Why do some methods take more time than others?
Due to the nature of the service, Wunderlist requires to keep everything in sync by providing the entity's [revision](https://developer.wunderlist.com/documentation/concepts/revisions ). To achieve this, methods responsible for updating entities (such as tasks, lists...) will fetch the entity first and then perform a request to apply the changes.

##### Why does it say `Forbidden` during authentication?
Make sure the auth callback URL you provide to `authUrl()` matches the one you have for your [app](https://developer.wunderlist.com/apps ).

##### What if something goes wrong?
Well.. at the time of this writing, the Wunderlist API isn't too helpful when it comes to error messages, so make sure you stick to the docs, use `getStatusCode()` and ask any questions in the docs comment section.

#### Progress
- Folder
    - ~~Get all folders~~
    - ~~Get a folder~~
    - Create a folder
    - Update a folder
    - Delete a folder
    - ~~Get folder revisions~~
- Note
    - ~~Get all notes~~
    - ~~Get a note~~
    - Create a note
    - Update a note
    - Delete a note
- Reminder
    - ~~Get all reminders~~
    - Create a reminder
    - Update a reminder
    - Delete a reminder
- Subtask
    - ~~Get all subtasks~~
    - ~~Get a subtask~~
    - Create a subtask
    - Update a subtask
    - Delete a subtask
- Some other endpoints (not started)
- Laravel integration
- Silex integration

Finished:
- Authorization
- Avatar
- Lists
- Task
- Comment
- User (except restricting the list of users a user can access by list)
- Webhook
