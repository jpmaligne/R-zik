<?php
namespace AppBundle\Services;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\PreAuthenticatedToken;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationFailureHandlerInterface;
use Symfony\Component\Security\Http\Authentication\SimplePreAuthenticatorInterface;
use Symfony\Component\Security\Http\HttpUtils;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\EntityManager;
use AppBundle\Security\AuthTokenAuthenticator;

class UserService
{

    protected $authTokenRepository;
    protected $userRepository;
    protected $authTokenAuthenticator;
    protected $em;

    public function __construct(EntityRepository $authTokenRepository, EntityRepository $userRepository, AuthTokenAuthenticator $authTokenAuthenticator, EntityManager $em)
    {
        $this->authTokenRepository = $authTokenRepository;
        $this->userRepository = $userRepository;
        $this->authTokenAuthenticator = $authTokenAuthenticator;
        $this->em = $em;
    }

    public function clearOutdatedTokens($id)
    {
        $requestedUser = $this->userRepository->findBy(['id' => $id]);
        if(empty($requestedUser)) {
            return $this->userNotFound();
        }
        $authTokens = $this->authTokenRepository->findBy(['user' => $requestedUser]);
        /* @var $authToken AuthToken */
        if (!$authTokens) {
            return null;
        } else {
            $authservice = $this->authTokenAuthenticator;
            $lastToken = end($authTokens);
            if($authservice->isTokenValid($lastToken)) { //Si le dernier token est valide
                for($i=0; $i<count($authTokens) - 1; $i++) { //On supprime tous les tokens de cet user 
                    $this->em->remove($authTokens[$i]);
                    $this->em->flush();
                }
                return $lastToken;
            } else {
                return null;
            }
        }
    }
}