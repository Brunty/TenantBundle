<?php

namespace spec\Vivait\TenantBundle\Locator;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\HttpFoundation\Request;
use Vivait\TenantBundle\Locator\HeaderLocator;

/**
 * @mixin HeaderLocator
 */
class HeaderLocatorSpec extends ObjectBehavior
{

    function it_should_match_a_tenant_from_a_header()
    {
        $headerKey = 'tenant';
        $method = 'GET';
        $params = [];
        $cookies = [];
        $files = [];
        $server = [
            'HTTP_' . $headerKey => 'vivait'
        ];
        $request = Request::create('http://subdomain.example.org/login', $method, $params, $cookies, $files, $server);

        $this->beConstructedWith($request, $headerKey);
        $this->getTenant()->shouldBe('vivait');
    }

    function it_should_not_match_a_tenant_from_a_request_that_doesnt_contain_a_header()
    {
        $request = Request::create('http://example.org/sign.up');
        $headerKey = 'tenant';

        $this->beConstructedWith($request, $headerKey);
        $this->shouldThrow('\RuntimeException')->duringGetTenant();
    }
}
