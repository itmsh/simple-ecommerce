<?php

namespace App\Controller\Rest\Web;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UsersController extends FOSRestController
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder){
        $this->encoder = $encoder;
    }

    public function postUsersAction(Request $request)
    {

        $user = new User();

        $user->setUsername($request->get('username'));
        $user->setPassword(
            $this->encoder->encodePassword($user, $request->get('password'))
        );
        $user->setEmail($request->get('email'));

        $manager = $this->getDoctrine()->getManager();
        $manager->persist($user);
        $manager->flush();

        $view = $this->view([], Response::HTTP_CREATED);
        return $this->handleView($view);

    } // "post_user"           [POST] /user

}