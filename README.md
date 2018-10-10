# php-whitelist-fluent [![Build Status](https://travis-ci.org/jfcherng/php-whitelist-fluent.svg?branch=master)](https://travis-ci.org/jfcherng/php-whitelist-fluent)

Base class for data structure with restricted attributes.


# Installation

```
$ composer require jfcherng/php-whitelist-fluent --no-dev
```


# Example

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


Supporters <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=ATXYY9Y78EQ3Y" target="_blank"><img src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_LG.gif" /></a>
==========

Thank you guys for sending me some cups of coffee.
