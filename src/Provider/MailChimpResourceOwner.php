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
        return $this->response['account_id'];
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        return $this->response;
    }
}
