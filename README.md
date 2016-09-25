## Instakler ##

PHP library for accessing to Instagram's API. The library is incomplete for me, but is operative, I'm using it in a project.

Backlog
- Test the library using PHPUnit
- Pagination for getting content from API

## Usage ##

Here's a basic example for showing owner information.

``` php
<?php
use Instakler\Instakler;

$config = array(
    'access_token' => ACCESS_TOKEN,
    'client_id' => CLIENT_ID,
    'client_secret' => CLIENT_SECRET,
);
$api = new Instakler($config);

$response = $api->getUsers()->getOwnerInformation();
print_r($response->getData());

?>
```
