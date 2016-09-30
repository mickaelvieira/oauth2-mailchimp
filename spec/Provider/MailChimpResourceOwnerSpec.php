<?php

namespace spec\League\OAuth2\Client\Provider;

use League\OAuth2\Client\Provider\MailChimpResourceOwner;
use League\OAuth2\Client\Provider\ResourceOwnerInterface;
use PhpSpec\ObjectBehavior;

class MailChimpResourceOwnerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith([]);
        $this->shouldHaveType(MailChimpResourceOwner::class);
        $this->shouldImplement(ResourceOwnerInterface::class);
    }
}
