<?php

namespace Barra\RestBundle\Security\Authentication\Provider;

use Symfony\Component\Security\Core\Authentication\Provider\AuthenticationProviderInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\NonceExpiredException;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Barra\RestBundle\Security\Authentication\Token\WsseUserToken;


/**
 * Class WsseProvider
 * Verification of the WsseUserToken
 * @link http://symfony.com/doc/current/cookbook/security/custom_authentication_provider.html#the-authentication-provider
 * @see Barra\RestBundle\DependencyInjection\Security\Factory\WsseFactory.php
 * @package Barra\RestBundle\Security\Authentication\Provider
 */
class WsseProvider implements AuthenticationProviderInterface
{
    private $userProvider;
    private $cacheDir;

    /**
     * @param UserProviderInterface $userProvider
     * @param $cacheDir
     */
    public function __construct(UserProviderInterface $userProvider, $cacheDir)
    {
        $this->userProvider = $userProvider;
        $this->cacheDir     = $cacheDir;
    }



    /**
     * @param TokenInterface $token
     * @return WsseUserToken|TokenInterface
     * @throws \Symfony\Component\Security\Core\Exception\AuthenticationException
     */
    public function authenticate(TokenInterface $token)
    {
        $user = $this->userProvider->loadUserByUsername($token->getUsername());

        if ($user && $this->validateDigest($token->digest, $token->nonce, $token->created, $user->getPassword())) {
            $authenticatedToken = new WsseUserToken($user->getRoles());
            $authenticatedToken->setUser($user);

            return $authenticatedToken;
        }

        throw new AuthenticationException('The WSSE authentication failed.');
    }



    /**
     * Validates digest
     * @link https://github.com/symfony/symfony-docs/pull/3134#issuecomment-27699129
     */
    protected function validateDigest($digest, $nonce, $created, $secret)
    {
        if (strtotime($created) > time()) // Check created time is not in the future
            return new AuthenticationException("created time is in the future");

        if (time() - strtotime($created) > 300) // Expire timestamp after 5 minutes
            return new AuthenticationException("Timestamp is too old");

        // Validate that the nonce is *not* used in the last 5 minutes. if it has, this could be a replay attack
        if (file_exists($this->cacheDir.'/'.$nonce) && file_get_contents($this->cacheDir.'/'.$nonce) + 300 > time())
            throw new NonceExpiredException('Previously used nonce detected');

        if (!is_dir($this->cacheDir)) // If cache directory does not exist we create it
            mkdir($this->cacheDir, 0777, true);

        file_put_contents($this->cacheDir.'/'.$nonce, time());

        $expected = base64_encode(sha1(base64_decode($nonce).$created.$secret, true));
        if ($digest !== $expected) // Validate Secret
            throw new AuthenticationException("Bad credentials. Digest is not the one expected.");

        return true;
    }


    /**
     * Tells the authentication manager whether or not to use this provider for the given token
     * He will then ask the next provider if given
     * @param TokenInterface $token
     * @return bool
     */
    public function supports(TokenInterface $token)
    {
        return $token instanceof WsseUserToken;
    }
}
