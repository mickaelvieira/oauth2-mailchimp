<?php

namespace League\OAuth2\Client\Provider;

use League\OAuth2\Client\Token\AccessToken;
use Psr\Http\Message\ResponseInterface;

/**
 * Class MailChimp
 * @package League\OAuth2\Client\Provider
 */
final class MailChimp extends AbstractProvider
{
    const DOMAIN = 'https://login.mailchimp.com';

    /**
     * {@inheritdoc}
     */
    public function getBaseAuthorizationUrl()
    {
        return sprintf('%s/%s', self::DOMAIN, 'oauth2/authorize');
    }

    /**
     * {@inheritdoc}
     */
    public function getBaseAccessTokenUrl(array $params)
    {
        return sprintf('%s/%s', self::DOMAIN, 'oauth2/token');
    }

    /**
     * {@inheritdoc}
     */
    public function getResourceOwnerDetailsUrl(AccessToken $token)
    {
        return sprintf('%s/%s', self::DOMAIN, 'oauth2/metadata');
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefaultScopes()
    {
        return null;
    }

    /**
     * {@inheritdoc}
     */
    protected function checkResponse(ResponseInterface $response, $data)
    {
    }

    /**
     * {@inheritdoc}
     */
    protected function createResourceOwner(array $response, AccessToken $token)
    {
        return new MailChimpResourceOwner($response);
    }
}
