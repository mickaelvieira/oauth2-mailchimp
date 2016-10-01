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
            'dc' => 'us1',
            'role' => 'owner',
            'accountname' => 'My awesome company',
            'user_id' => 12345,
            'login' => [
                'email' => 'username@example.com',
                'avatar' => null,
                'login_id' => 54321,
                'login_name' => 'username',
                'login_email' => 'username@example.com'
            ],
            'login_url' => 'https://login.mailchimp.com',
            'api_endpoint' => 'https://us1.api.mailchimp.com'
        ]);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(MailChimpResourceOwner::class);
        $this->shouldImplement(ResourceOwnerInterface::class);
    }

    function it_returns_the_user_id()
    {
        $this->getId()->shouldReturn(12345);
    }

    function it_returns_api_end_point()
    {
        $this->getApiEndPoint()->shouldReturn('https://us1.api.mailchimp.com');
    }

    function it_returns_the_login_url()
    {
        $this->getLoginUrl()->shouldReturn('https://login.mailchimp.com');
    }

    function it_can_be_converted_into_an_array()
    {
        $this->toArray()->shouldReturn([
            'dc' => 'us1',
            'role' => 'owner',
            'accountname' => 'My awesome company',
            'user_id' => 12345,
            'login' => [
                'email' => 'username@example.com',
                'avatar' => null,
                'login_id' => 54321,
                'login_name' => 'username',
                'login_email' => 'username@example.com'
            ],
            'login_url' => 'https://login.mailchimp.com',
            'api_endpoint' => 'https://us1.api.mailchimp.com'
        ]);
    }

}
