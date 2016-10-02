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
    /** @var string */
    protected $clientName;

    const PROTOCOL        = 'https';
    const DOMAIN          = 'login.mailchimp.com';

    /**
     * {@inheritdoc}
     */
    public function getBaseAuthorizationUrl()
    {
        return sprintf('%s://%s/%s', self::PROTOCOL, self::DOMAIN, 'oauth2/authorize');
    }

    /**
     * {@inheritdoc}
     */
    public function getBaseAccessTokenUrl(array $params)
    {
        return sprintf('%s://%s/%s', self::PROTOCOL, self::DOMAIN, 'oauth2/token');
    }

    /**
     * {@inheritdoc}
     */
    public function getResourceOwnerDetailsUrl(AccessToken $token)
    {
        return sprintf('%s://%s/%s', self::PROTOCOL, self::DOMAIN, 'oauth2/metadata');
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

    /**
     * {@inheritdoc}
     */
    protected function getAuthorizationHeaders($token = null)
    {
        $headers = [
            'Accept'        => 'application/json',
            'Authorization' => sprintf('OAuth %s', $token)
        ];

        if ($this->clientName) {
            $headers['User-Agent'] = $this->clientName;
        }

        return $headers;
    }
}
