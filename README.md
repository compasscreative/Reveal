Reveal
======

## Setup

Simply tell `Response::get` to handle whatever your router returns. For example:

```php
<?php

Response::get(Router::run())->send();
```

## 404 pages

Maybe you have a fancy `404` page you'd like to show? You can do that. Note, this particular example will handle all response errors, including bad requests (`400`), unauthorized requests (`401`), forbidden requests (`403`), pages not found (`404`) and internal server errors (`500`).

```php
<?php

try {

    Response::get(Router::run())->send();

} catch (ResponseException $e) {

    $view = new ViewResponse('error.php', $e->getCode());
    $view->code = $e->getCode();
    $view->message = $e->getMessage();
    $view->send();
}
```

### Triggering a 404 error

You can trigger a `404` within your application by throwing a specific error, returning false, or by simply returning nothing. All can be helpful:

```php
<?php

// Throw a specific error
public function displayProfile($person_id)
{
    if (!$person = Person::select($person_id)) {
        Response::notFound('Person with the id ' . $person_id . ' does not exist.');
    }

    return Response::view('profile.php', array('person' => $person));
}

// Return false
public function displayProfile($person_id)
{
    if (!$person = Person::select($person_id)) {
        return false;
    }

    return Response::view('profile.php', array('person' => $person));
}

// Return nothing
public function displayProfile($person_id)
{
    if ($person = Person::select($person_id)) {
        return Response::view('profile.php', array('person' => $person));
    }
}
```

## Views

### Creating views

```php
<?php

return Response::view('home.php');
```

### Adding data to views

```php
<?php

return Response::view(
    'home.php',
    array(
        'name' => 'Jonathan',
        'country' => 'Canada'
    )
);
```

## Redirects

```php
<?php

// Standard 301 redirect
return Response::redirect('/url');

// Redirecting with a specific code
return Response::redirect('/url', 301);
```

## JSON

```php
<?php

// JSON encode array
return Response::json($array);
```

## Files

Outputting files couldn't be easier, just return the path to your image or document. If the file doesn't exist, a `404` `ErrorResponse` will automatically be returned instead.

```php
<?php

// Display an image
return Response::jpg($file_path);

// Display a PDF document
return Response::pdf($file_path);

// Force download a PDF document
return Response::pdf($file_path, 'document.pdf', true);
```

## Errors

In addition to `404` pages, Reveal can also help with other common errors. To trigger an error, simply call one of the following methods:

```php
<?php

// 400
Response::badRequest();

// 401
Response::unauthorized();

// 403
Response::forbidden();

// 404
Response::notFound();

// 500
Response::serverError();
```

### Exceptions

You'll notice that error responses don't need to be returned. This is because they're actually an alias to the `ResponseException` class, which is thrown upon calling them. Like any other exception, the `ResponseException` should be caught. See an example above, under the "404 pages" section.

```php
<?php

// This is the same...
Response::notFound();

// ...as this:
throw new ResponseException('Page Not Found.', 404);
```

## Strings

Strings are automatically converted into a valid `Response` object.

```php
<?php

// This...
return 'String';

// ...is the same as this:
return new Response('String');
```

## Blank pages

Sometimes there just isn't anything to say, but a valid response is still required. Just `return false` to prevent a `404` `ErrorResponse`.

```php
<?php

// Blank page
return true;
```