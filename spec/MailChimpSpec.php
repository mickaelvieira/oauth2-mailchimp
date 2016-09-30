<?php

namespace spec\League\OAuth2\Client;

use PhpSpec\ObjectBehavior;
use League\OAuth2\Client\MailChimp;
use League\OAuth2\Client\Provider\AbstractProvider;

class MailChimpSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(MailChimp::class);
        $this->shouldHaveType(AbstractProvider::class);
    }
}
