# php-whitelist-fluent

<a href="https://travis-ci.org/jfcherng/php-whitelist-fluent"><img alt="Travis (.org) branch" src="https://img.shields.io/travis/jfcherng/php-whitelist-fluent/master"></a>
<a href="https://app.codacy.com/project/jfcherng/php-whitelist-fluent/dashboard"><img alt="Codacy grade" src="https://img.shields.io/codacy/grade/6780f76764da4d578f903680f3b90a11/master"></a>
<a href="https://packagist.org/packages/jfcherng/php-whitelist-fluent"><img alt="Packagist" src="https://img.shields.io/packagist/dt/jfcherng/php-whitelist-fluent"></a>
<a href="https://packagist.org/packages/jfcherng/php-whitelist-fluent"><img alt="Packagist Version" src="https://img.shields.io/packagist/v/jfcherng/php-whitelist-fluent"></a>
<a href="https://github.com/jfcherng/php-whitelist-fluent/blob/master/LICENSE"><img alt="Project license" src="https://img.shields.io/github/license/jfcherng/php-whitelist-fluent"></a>
<a href="https://github.com/jfcherng/php-whitelist-fluent/stargazers"><img alt="GitHub stars" src="https://img.shields.io/github/stars/jfcherng/php-whitelist-fluent?logo=github"></a>
<a href="https://www.paypal.me/jfcherng/5usd" title="Donate to this project using Paypal"><img src="https://img.shields.io/badge/paypal-donate-blue.svg?logo=paypal" /></a>

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
