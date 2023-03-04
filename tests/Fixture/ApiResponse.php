<?php

declare(strict_types=1);

namespace Jfcherng\Utility\Test\Fixture;

use Jfcherng\Utility\WhitelistFluent;

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
    protected array $attributes = [
        'code' => 0,
        'msg' => '',
        'data' => [],
    ];
}
