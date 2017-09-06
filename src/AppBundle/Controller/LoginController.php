<?php

namespace AppBundle\Controller;


use Doctrine\Common\Collections\ArrayCollection;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;

class LoginController extends Controller
{
    /**
     * @Rest\View()
     * @Rest\Get("/login")
     */
    public function getLoginAction(Request $request)
    {
        // $users = $this->get('doctrine.orm.entity_manager')
        //     ->getRepository('AppBundle:User')
        //     ->findAll();
        /* @var $users User[] */
        // return $users;
        return new JsonResponse("login");
    }
}
