<?php

namespace spec\League\OAuth2\Client\Provider;

use League\OAuth2\Client\Provider\MailChimpResourceOwner;
use League\OAuth2\Client\Provider\ResourceOwnerInterface;
use PhpSpec\ObjectBehavior;

class MailChimpResourceOwnerSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith([
            'account_id' => '1'
        ]);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(MailChimpResourceOwner::class);
        $this->shouldImplement(ResourceOwnerInterface::class);
    }

    function it_returns_its_id()
    {
        $this->getId()->shouldReturn('1');
    }

    function it_can_be_converted_into_an_array()
    {
        $this->toArray()->shouldReturn([
            'account_id' => '1'
        ]);
    }

}
