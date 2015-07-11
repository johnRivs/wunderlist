# Use the latest Wunderlist API version in your apps.
[![Latest Stable Version](https://poser.pugx.org/johnrivs/wunderlist/v/stable)](https://packagist.org/packages/johnrivs/wunderlist) [![Total Downloads](https://poser.pugx.org/johnrivs/wunderlist/downloads)](https://packagist.org/packages/johnrivs/wunderlist) [![License](https://poser.pugx.org/johnrivs/wunderlist/license)](https://packagist.org/packages/johnrivs/wunderlist)

[http://johnrivs.github.io/wunderlist](http://johnrivs.github.io/wunderlist )

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
- Lists
    - ~~Get all lists~~
    - ~~Get a list~~
    - Create a list
    - Update a list
    - Make a list public
    - Delete a list
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
- Task
    - ~~Get all tasks~~
    - ~~Get all completed tasks~~
    - ~~Get a task~~
    - Create a task
    - Update a task
    - Delete a task

Finished:
- Authorization
- User (except restricting the list of users a user can access by list)
- Webhook
