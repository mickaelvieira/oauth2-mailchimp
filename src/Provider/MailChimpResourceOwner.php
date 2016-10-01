<?php

namespace League\OAuth2\Client\Provider;

/**
 * Class MailChimpResourceOwner
 * @package League\OAuth2\Client\Provider
 */
class MailChimpResourceOwner implements ResourceOwnerInterface
{
    /**
     * @var array
     */
    protected $response;

    /**
     * MailChimpResourceOwner constructor.
     * @param array $response
     */
    public function __construct(array $response)
    {
        $this->response = $response;
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->response['user_id'];
    }

    /**
     * @return string
     */
    public function getApiEndPoint()
    {
        return $this->response['api_endpoint'];
    }

    /**
     * @return string
     */
    public function getLoginUrl()
    {
        return $this->response['login_url'];
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        return $this->response;
    }
}
