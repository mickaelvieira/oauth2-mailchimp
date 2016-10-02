<?php

namespace spec\League\OAuth2\Client\Provider;

use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Token\AccessToken;
use PhpSpec\ObjectBehavior;
use League\OAuth2\Client\Provider\MailChimp;
use League\OAuth2\Client\Provider\AbstractProvider;
use Prophecy\Prophet;

class MailChimpSpec extends ObjectBehavior
{

    private $fakeClient;

    function let()
    {
        $this->fakeClient = (new Prophet())->prophesize('GuzzleHttp\ClientInterface');

        $this->beConstructedWith(
            [
                'clientId' => '635959587059',
                'clientSecret' => '0da3e7744949e1406b7b250051ee1a95',
                'redirectUri' => 'http://192.168.1.8/oauth/complete.php'
            ],
            [
                'httpClient' => $this->fakeClient,
            ]
        );
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
        $this->getResourceOwnerDetailsUrl(new AccessToken(['access_token' => '123456']))
            ->shouldReturn('https://login.mailchimp.com/oauth2/metadata');
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

    function it_appends_the_necessary_headers_to_the_request()
    {
        $request = $this->getAuthenticatedRequest('GET', '/endpoint', '12345');
        $request->getHeaders()->shouldReturn([
            'Accept' => ['application/json'],
            'Authorization' => ['OAuth 12345']
        ]);
    }

    function it_should_throw_an_exception_when_the_api_return_an_response_containing_a_client_error()
    {
        $request = (new Prophet())->prophesize('Psr\Http\Message\RequestInterface');
        $response = (new Prophet())->prophesize('Psr\Http\Message\ResponseInterface');
        $response->getHeader('content-type')->willReturn('application/json');

        $body = '{"type":"http://kb.mailchimp.com/api/error-docs/405-method-not-allowed","title":"Method Not Allowed","status":405,"detail":"The requested method and resource are not compatible. See the Allow header for this resource\'s available methods.","instance":""}';
        $response->getBody()->willReturn($body);

        $this->fakeClient->send($request)->willReturn($response);

        $message = 'Method Not Allowed: The requested method and resource are not compatible. See the Allow header for this resource\'s available methods.';

        $this->shouldThrow(new IdentityProviderException($message, 405, json_decode($body, true)))->during('getResponse', [$request]);
    }

    function it_should_throw_an_exception_when_the_api_return_an_response_containing_a_server_error()
    {
        $request = (new Prophet())->prophesize('Psr\Http\Message\RequestInterface');
        $response = (new Prophet())->prophesize('Psr\Http\Message\ResponseInterface');
        $response->getHeader('content-type')->willReturn('application/json');

        $body = '{"type":"http://kb.mailchimp.com/api/error-docs/500-internal-server-error","title":"Internal server error","status":500,"detail":"An unexpected internal error has occurred. Please contact Support for more information.","instance":""}';
        $response->getBody()->willReturn($body);

        $this->fakeClient->send($request)->willReturn($response);

        $message = 'Internal server error: An unexpected internal error has occurred. Please contact Support for more information.';

        $this->shouldThrow(new IdentityProviderException($message, 500, json_decode($body, true)))->during('getResponse', [$request]);
    }
}
