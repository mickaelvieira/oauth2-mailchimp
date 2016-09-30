<?php

namespace spec\League\OAuth2\Client\Provider;

use League\OAuth2\Client\Token\AccessToken;
use PhpSpec\ObjectBehavior;
use League\OAuth2\Client\Provider\MailChimp;
use League\OAuth2\Client\Provider\AbstractProvider;

class MailChimpSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith([
            'clientId' => '635959587059',
            'clientSecret' => '0da3e7744949e1406b7b250051ee1a95',
            'redirectUri' => 'http://192.168.1.8/oauth/complete.php'
        ]);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(MailChimp::class);
        $this->shouldHaveType(AbstractProvider::class);
    }

    function it_returns_the_base_authorization_url()
    {
        $this->getBaseAuthorizationUrl()->shouldReturn('https://login.mailchimp.com/oauth2/authorize');
    }


    function it_returns_the_base_access_token_url()
    {
        $this->getBaseAccessTokenUrl([])->shouldReturn('https://login.mailchimp.com/oauth2/token');
    }

    function it_returns_the_resource_owner_details_url()
    {
        $this->getResourceOwnerDetailsUrl(new AccessToken(['access_token' => '123456']))->shouldReturn('https://login.mailchimp.com/oauth2/metadata');
    }

    function it_builds_the_authorization_url()
    {
        $options = [
            'state' => '123456'
        ];

        $this->getAuthorizationUrl($options)->shouldReturn(
            'https://login.mailchimp.com/oauth2/authorize?state=123456&response_type=code&approval_prompt=auto&client_id=635959587059&redirect_uri=http%3A%2F%2F192.168.1.8%2Foauth%2Fcomplete.php'
        );
    }

}
