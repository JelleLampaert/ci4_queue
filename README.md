# CodeIgniter4 queuing system

Queue tasks that depend on external services (like e-mail) in the database.
Process the queue asynchronous (i.e. by using a cronjob), so the user does
not have to wait for that service to respond.

## Installation

Install the package through [Composer](http://getcomposer.org/). 

Run the Composer require command from the Terminal:

    composer require jellelampaert/ci4_queue

Once installed, make sure your database is setup correctly and run the migration

    php spark migrate -all

## Usage

How to load the library

```php
$queue = new \jellelampaert\ci4_queue\Queue();
$queue->queue('email')->add(array(
    'to'        => 'test@example.com',
    'subject'   => 'This is a test',
    'message'   => 'Testing, attention please'
));
```

The queuing system has the following methods:

### Queue::queue($queue)

Define the queue you want to use.
Your application can have different queues, i.e. a queue for e-mails, a queue for webhooks, ...

### Queue::add($data)

Add a task to the queue.
The argument can be anything: a number, a string, an array, an object, ...
Make sure to define a queuename first

```php
$queue = new Queue();
$queue->queue('email')->add(array(
    'to'        => 'test@example.com',
    'subject'   => 'This is a test',
    'message'   => 'Testing, attention please'
));
```

### Queue::clean($hours)

Delete all tasks from a queue that are processed more than x hours ago.

```php
$queue = new Queue();
$queue->queue('email')->clean(24);
```

### Queue::cleanAll($hours)

Delete all tasks from all queues that are processed more than x hours ago.

```php
$queue = new Queue();
$queue->cleanAll(24);
```

### Queue::delete($id)

Delete a task from the database.

```php
$queue = new Queue();
$queue->delete(1);
```

### Queue::getAllTasks()

Gets all tasks in the queue, whether they are processed or not

```php
$queue = new Queue();
$queue->queue('email')->getAllTasks();
```

### Queue::getAllUnprocessed()

Gets all unprocessed tasks from every queue in the database.

```php
$queue = new Queue();
$queue->getAllUnprocessed();
```

### Queue::getTask($id)

Gets a task by it's ID

```php
$queue = new Queue();
$queue->getTask(1);
```

### Queue::getUnprocessed()

Get all unprocessed tasks from a queue.

```php
$queue = new Queue();
$queue->queue('email')->getUnprocessed();
```

### Queue::setProcessed($id)

Sets a task as processed.

```php
$queue = new Queue();
$queue->queue('email')->setProcessed(1);
```

### Queue::setResponse($id, $data)

Sets the response of a task.
This can be used for logging purposes or debugging

```php
$queue = new Queue();
$queue->setResponse(1, 'HTTP Error 404');
```

## License

This package is free software distributed under the terms of the [MIT license](LICENSE.md).