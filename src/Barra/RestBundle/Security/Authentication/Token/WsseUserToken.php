<?php

namespace Barra\RestBundle\Security\Authentication\Token;

use Symfony\Component\Security\Core\Authentication\Token\AbstractToken;

/**
 * Class WsseUserToken
 * Represents user's authentication data present in the request and then delivers his data across the security context
 * @link http://symfony.com/doc/current/cookbook/security/custom_authentication_provider.html#the-token
 * @package Barra\RestBundle\Security\Authentication\Token
 */
class WsseUserToken extends AbstractToken
{
    public $created;
    public $digest;
    public $nonce;

    /**
     * @param array $roles
     */
    public function __construct(array $roles = array())
    {
        parent::__construct($roles);

        // If the user has roles, consider it authenticated
        $this->setAuthenticated(count($roles) > 0);
    }

    public function getCredentials()
    {
        return '';
    }
}