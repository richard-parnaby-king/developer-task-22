# ActiveHousing DeveloperTask22

DeveloperTask22 is a small test package that provides a service for retrieving users via a remote API (https://reqres.in/ dummy API for the purposes of this test).

## Installation

```bash
composer require richard-parnaby-king/developer-task-22
```

## Usage

```php

$request = new \RichardParnabyKing\DeveloperTask22\Request();

//Fetch one user
$user = $request->getUser(1); //\RichardParnabyKing\DeveloperTask22\Model\User
var_dump($user->getFirstName()); //George

//Fetch a user that does not exist
$user = $request->getUser(23); //null

//Fetch a page of users.
$users = $request->getUsers(1); //\RichardParnabyKing\DeveloperTask22\Model\User[]

//Exceed pagination resultset of users (there's only two pages of user data, try to
// get data from page 3)
$users = $request->getUser(3); //Empty array

```

## Dependencies

This package requires the following dependencies:

* curl/curl

## License
[MIT](https://choosealicense.com/licenses/mit/)