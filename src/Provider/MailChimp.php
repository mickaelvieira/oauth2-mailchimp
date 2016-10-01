<?php

namespace League\OAuth2\Client\Provider;

use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Token\AccessToken;
use Psr\Http\Message\ResponseInterface;

/**
 * Class MailChimp
 * @package League\OAuth2\Client\Provider
 */
final class MailChimp extends AbstractProvider
{
    const DC = 'us1';
    const PROTOCOL        = 'https';
    const DOMAIN          = 'mailchimp.com';
    const OAUTH_SUBDOMAIN = 'login';
    const API_SUBDOMAIN   = self::DC . '.api';

    /**
     * {@inheritdoc}
     */
    public function getBaseAuthorizationUrl()
    {
        return sprintf('%s://%s.%s/%s', self::PROTOCOL, self::OAUTH_SUBDOMAIN, self::DOMAIN, 'oauth2/authorize');
    }

    /**
     * {@inheritdoc}
     */
    public function getBaseAccessTokenUrl(array $params)
    {
        return sprintf('%s://%s.%s/%s', self::PROTOCOL, self::OAUTH_SUBDOMAIN, self::DOMAIN, 'oauth2/token');
    }

    /**
     * {@inheritdoc}
     */
    public function getResourceOwnerDetailsUrl(AccessToken $token)
    {
        return sprintf('%s://%s.%s/%s', self::PROTOCOL, self::API_SUBDOMAIN, self::DOMAIN, '3.0');
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
        if (array_key_exists('status', $data)) {

            $status = (int)$data['status'];

            if ($status >= 400) {

                $title = $data['title'];
                $detail = $data['detail'];

                $error = sprintf('%s: %s', $title, $detail);

                throw new IdentityProviderException($error, $status, $data);
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function createResourceOwner(array $response, AccessToken $token)
    {
        return new MailChimpResourceOwner($response);
    }
}
