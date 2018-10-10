<?php

declare(strict_types=1);

namespace Jfcherng\Utility\Test;

use InvalidArgumentException;
use Jfcherng\Utility\Test\Fixture\ApiResponse;
use PHPUnit\Framework\TestCase;

/**
 * @coversNothing
 */
class WhitelistFluentTest extends TestCase
{
    /**
     * @covers \Jfcherng\Utility\WhitelistFluent::__get
     * @covers \Jfcherng\Utility\WhitelistFluent::get
     * @covers \Jfcherng\Utility\WhitelistFluent::offsetGet
     */
    public function testGet(): void
    {
        $wf = new ApiResponse([
            'code' => 500,
        ]);

        $this->assertSame(500, $wf->code);
        $this->assertNull($wf->nonexistent);

        $this->assertSame(500, $wf->get('code'));
        $this->assertNull($wf->get('nonexistent'));
        $this->assertSame(':(', $wf->get('nonexistent', ':('));

        $this->assertSame(500, $wf['code']);
        $this->assertNull($wf['nonexistent']);
    }

    /**
     * @covers \Jfcherng\Utility\WhitelistFluent::__call
     * @covers \Jfcherng\Utility\WhitelistFluent::__set
     * @covers \Jfcherng\Utility\WhitelistFluent::offsetSet
     */
    public function testSet(): void
    {
        $wf = new ApiResponse([
            'code' => 500,
        ]);

        $wf->code(200);
        $this->assertSame(200, $wf->code);

        $wf->code = 300;
        $this->assertSame(300, $wf->code);

        $wf['code'] = 400;
        $this->assertSame(400, $wf->code);

        $this->expectException(InvalidArgumentException::class);
        $wf->nonexistent('hello');
        $wf->nonexistent = 'hello';
        $wf['nonexistent'] = 'hello';
    }

    /**
     * @covers \Jfcherng\Utility\WhitelistFluent::__isset
     * @covers \Jfcherng\Utility\WhitelistFluent::offsetExists
     */
    public function testIsset(): void
    {
        $wf = new ApiResponse([
            'code' => 0,
            'msg' => '',
            'data' => [],
        ]);

        $this->assertTrue(isset($wf->code));
        $this->assertFalse(isset($wf->nonexistent));

        $this->assertTrue(isset($wf['code']));
        $this->assertFalse(isset($wf['nonexistent']));
    }

    /**
     * @covers \Jfcherng\Utility\WhitelistFluent::__unset
     * @covers \Jfcherng\Utility\WhitelistFluent::offsetUnset
     */
    public function testUnset(): void
    {
        $wf = new ApiResponse([
            'code' => 0,
            'msg' => '',
            'data' => [],
        ]);

        unset($wf->code, $wf['msg']);
        $this->assertNull($wf->code);
        $this->assertNull($wf->msg);
    }

    /**
     * @covers \Jfcherng\Utility\WhitelistFluent::getAttributes
     */
    public function testGetAttributes(): void
    {
        $attrs = [
            'code' => 500,
            'msg' => 'Internal Server Error',
            'data' => [],
        ];

        $wf = new ApiResponse($attrs);

        $this->assertSame($attrs, $wf->getAttributes());
    }

    /**
     * @covers \Jfcherng\Utility\WhitelistFluent::getAllowedAttributes
     */
    public function testGetAllowedAttributes(): void
    {
        $attrs = [
            'code' => 500,
            'msg' => 'Internal Server Error',
            'data' => [],
        ];

        $wf = new ApiResponse($attrs);

        $this->assertSame(\array_keys($attrs), $wf->getAllowedAttributes());
    }

    /**
     * @covers \Jfcherng\Utility\WhitelistFluent::toArray
     */
    public function testToArray(): void
    {
        $attrs = [
            'code' => 500,
            'msg' => 'Internal Server Error',
            'data' => [],
        ];

        $wf = new ApiResponse($attrs);

        $this->assertSame($attrs, $wf->toArray());
    }

    /**
     * @covers \Jfcherng\Utility\WhitelistFluent::toJson
     */
    public function testToJson(): void
    {
        $attrs = [
            'code' => 500,
            'msg' => 'Internal Server Error',
            'data' => [],
        ];

        $wf = new ApiResponse($attrs);

        $this->assertSame(\json_encode($attrs), $wf->toJson());
    }

    /**
     * @covers \Jfcherng\Utility\WhitelistFluent::jsonSerialize
     */
    public function testJsonSerialize(): void
    {
        $attrs = [
            'code' => 500,
            'msg' => 'Internal Server Error',
            'data' => [],
        ];

        $wf = new ApiResponse($attrs);

        $this->assertSame($attrs, $wf->jsonSerialize());
    }
}
