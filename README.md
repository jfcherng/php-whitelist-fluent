# php-whitelist-fluent

[![GitHub Workflow Status (branch)](https://img.shields.io/github/actions/workflow/status/jfcherng/php-whitelist-fluent/php.yml?branch=master&style=flat-square)](https://github.com/jfcherng/php-whitelist-fluent/actions)
[![Packagist](https://img.shields.io/packagist/dt/jfcherng/php-whitelist-fluent?style=flat-square)](https://packagist.org/packages/jfcherng/php-whitelist-fluent)
[![Packagist Version](https://img.shields.io/packagist/v/jfcherng/php-whitelist-fluent?style=flat-square)](https://packagist.org/packages/jfcherng/php-whitelist-fluent)
[![Project license](https://img.shields.io/github/license/jfcherng/php-whitelist-fluent?style=flat-square)](https://github.com/jfcherng/php-whitelist-fluent/blob/master/LICENSE)
[![GitHub stars](https://img.shields.io/github/stars/jfcherng/php-whitelist-fluent?style=flat-square&logo=github)](https://github.com/jfcherng/php-whitelist-fluent/stargazers)
[![Donate to this project using Paypal](https://img.shields.io/badge/paypal-donate-blue.svg?style=flat-square&logo=paypal)](https://www.paypal.me/jfcherng/5usd)

Base class for data structure with restricted attributes.


## Installation

```bash
composer require jfcherng/php-whitelist-fluent

# if PHP ^5.5 is used
composer require jfcherng/php-whitelist-fluent:dev-php5
```


## Example

```php
<?php

include __DIR__ . '/vendor/autoload.php';

use Jfcherng\Utility\WhitelistFluent;

// extend your own class with WhitelistFluent

/**
 * @property int    $code the error code
 * @property array  $data the output data
 * @property string $msg  the message
 */
class ApiResponse extends WhitelistFluent
{
    /**
     * {@inheritdoc}
     */
    protected $attributes = [
        'code' => 0,
        'msg' => '',
        'data' => [],
    ];
}

$resp = new ApiResponse();

// 2 ways to get an attribute
$resp['code'];
$resp->code;

// 3 ways to set an attribute
$resp->code(200);
$resp['code'] = 200;
$resp->code = 200;

// method chaining
$resp
    ->code(500)
    ->msg('something goes wrong')
    ->data([]);

// trying to set a nonexistent attribute would throw InvalidArgumentException
$resp->nonexistent('hello');
$resp['nonexistent'] = 'hello';
$resp->nonexistent = 'hello';

// get attributes in array form
$resp->toArray();

// get attributes in json string form
$jsonFlag = JSON_PRETTY_PRINT;
$resp->toJson($jsonFlag);
json_encode($resp, $jsonFlag);
```
