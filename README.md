<p align="center"><img src="https://blog.pleets.org/img/articles/easy-http-logo.png" height="150"></p>

<p align="center">
<a href="https://travis-ci.org/easy-http/layer-contracts"><img src="https://travis-ci.org/easy-http/layer-contracts.svg?branch=master" alt="Build Status"></a>
<a href="https://scrutinizer-ci.com/g/easy-http/layer-contracts"><img src="https://img.shields.io/scrutinizer/g/easy-http/layer-contracts.svg" alt="Code Quality"></a>
<a href="https://sonarcloud.io/dashboard?id=easy-http_layer-contracts"><img src="https://sonarcloud.io/api/project_badges/measure?project=easy-http_layer-contracts&metric=security_rating" alt="Bugs"></a>
<a href="https://scrutinizer-ci.com/g/easy-http/layer-contracts/?branch=master"><img src="https://scrutinizer-ci.com/g/easy-http/layer-contracts/badges/coverage.png?b=master" alt="Code Coverage"></a>
</p>

<p align="center"><img src="https://blog.pleets.org/img/articles/easy-http-contracts.png" height="300"></p>

# Layer Contracts

Http layer contracts for PHP clients. For all client layers see [Easy Http](https://github.com/easy-http).

# Usage

## Simple requests

You can execute a simple request through the Standard class. 

```php
use EasyHttp\GuzzleLayer\SomeClient;

$client = new SomeClient();
$response = $client->call('GET', 'https://api.ratesapi.io/api/2020-07-24/?base=USD');

$response->getStatusCode(); // 200
$response->toJson();      // JSON
```

## Prepared requests

A prepared request is a more flexible way to generate requests through any client.

```php
use EasyHttp\GuzzleLayer\SomeClient;

$client = new SomeClient();

$client->prepareRequest('POST', 'https://jsonplaceholder.typicode.com/posts');
$client->getRequest()->setJson([
    'title' => 'foo',
    'body' => 'bar',
    'userId' => 1,
]);
$response = $client->execute();

$response->getStatusCode(); // 201
$response->toJson();      // JSON
```

## HTTP Authentication

Actually this library supports basic authentication natively.

```php
use EasyHttp\GuzzleLayer\SomeClient;

$client = new SomeClient();

$client->prepareRequest('POST', 'https://api.sandbox.paypal.com/v1/oauth2/token');
$user = 'AeA1QIZXiflr1_-r0U2UbWTziOWX1GRQer5jkUq4ZfWT5qwb6qQRPq7jDtv57TL4POEEezGLdutcxnkJ';
$pass = 'ECYYrrSHdKfk_Q0EdvzdGkzj58a66kKaUQ5dZAEv4HvvtDId2_DpSuYDB088BZxGuMji7G4OFUnPog6p';
$client->getRequest()->setBasicAuth($user, $pass);
$client->getRequest()->setQuery(['grant_type' => 'client_credentials']);
$response = $client->execute();

$response->getStatusCode(); // 200
$response->toJson();      // JSON
```