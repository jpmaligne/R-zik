<?php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest; // alias pour toutes les annotations
use AppBundle\Form\Type\CredentialsType;
use AppBundle\Entity\AuthToken;
use AppBundle\Entity\Credentials;
use AppBundle\Security\AuthTokenAuthenticator;

class AuthTokenController extends Controller
{
    /**
     * @Rest\View(statusCode=Response::HTTP_CREATED, serializerGroups={"auth-token"})
     * @Rest\Post("/auth-tokens")
     */
    public function postAuthTokensAction(Request $request)
    {
        $credentials = new Credentials();
        $form = $this->createForm(CredentialsType::class, $credentials);

        $form->submit($request->request->all());

        if (!$form->isValid()) {
            return $form;
        }

        $em = $this->get('doctrine.orm.entity_manager');

        $user = $em->getRepository('AppBundle:User')
                   ->findOneByEmail($credentials->getLogin());

        if (!$user) { // L'utilisateur n'existe pas
            return $this->invalidCredentials();
        }

        //Si l'utilisateur existe, on verifie ses token et leurs validité, on supprime les anciens tokens
        $userService = $this->get('user_service');
        $authToken = $userService->clearOutdatedTokens($user->getId());
        if(!empty($authToken)) {
            return $authToken;
        }

        $encoder = $this->get('security.password_encoder');
        $isPasswordValid = $encoder->isPasswordValid($user, $credentials->getPassword());

        if (!$isPasswordValid) { // Le mot de passe n'est pas correct
            return $this->invalidCredentials();
        }

        $authToken = new AuthToken();
        $authToken->setValue(base64_encode(random_bytes(50)));
        $date = new \DateTime('now');
        $authToken->setCreatedAt($date);
        $authToken->setUser($user);
        $em->persist($authToken);
        $em->flush();

        return $authToken;
    }

    /**
     * @Rest\View(statusCode=Response::HTTP_NO_CONTENT)
     * @Rest\Delete("/auth-tokens/{id}")
    */
    public function removeAuthTokenAction(Request $request)
    {
        $em = $this->get('doctrine.orm.entity_manager');
        $authToken = $em->getRepository('AppBundle:AuthToken')
                        ->find($request->get('id'));
        /* @var $authToken AuthToken */
 
        $connectedUser = $this->get('security.token_storage')->getToken()->getUser();
 
        if ($authToken && $authToken->getUser()->getId() === $connectedUser->getId()) {
            $em->remove($authToken);
            $em->flush();
        } else {
            throw new \Symfony\Component\HttpKernel\Exception\BadRequestHttpException();
        }
    }

    /**
    * @Rest\View(statusCode=Response::HTTP_OK, serializerGroups={"auth-token"})
    * @Rest\Get("/auth-tokens")
    */
   public function getAuthTokensAction(Request $request)
   {
       /** @var EntityManager $em */
       $em = $this->get('doctrine.orm.entity_manager');
       $authTokens = $em->getRepository('AppBundle:AuthToken')
                        ->findBy(['value' => $request->headers->get('x-auth-token')]);
       if(empty($authTokens))
       {
           return $this->invalidCredentials();
       }
       return $authTokens;
   }

    private function invalidCredentials()
    {
        return \FOS\RestBundle\View\View::create(['message' => 'Invalid credentials'], Response::HTTP_BAD_REQUEST);
    }

    private function userNotFound()
    {
        return \FOS\RestBundle\View\View::create(['message' => 'User not found'], Response::HTTP_NOT_FOUND);
    }
}
