<?php
namespace Vlorun\Api\Definition;

use PHPUnit\Framework\TestCase;

class RequestParametersTest extends TestCase
{
    /** @test */
    public function itCanBeTraversed()
    {
        $requestParameter = $this->prophesize(Parameter::class);
        $requestParameter->getLocation()->willReturn('query');
        $requestParameter->getName()->willReturn('foo');

        $requestParameters = new Parameters([$requestParameter->reveal()]);

        assertThat($requestParameters, isInstanceOf(\Traversable::class));
        assertThat($requestParameters, containsOnlyInstancesOf(Parameter::class));
    }

    /** @test */
    public function itCanBeSerialized()
    {
        $requestParameters = new Parameters([]);
        $serialized = serialize($requestParameters);

        assertThat(unserialize($serialized), self::equalTo($requestParameters));
    }

    /** @test */
    public function itCanResolveARequestParameterByName()
    {
        $requestParameter = $this->prophesize(Parameter::class);
        $requestParameter->getLocation()->willReturn('query');
        $requestParameter->getName()->willReturn('foo');

        $requestParameters = new Parameters([$requestParameter->reveal()]);

        assertThat($requestParameters->getByName('foo'), equalTo($requestParameter->reveal()));
    }
}
