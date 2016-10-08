<?php

namespace Deblan\Bundle\RtmpBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @author Simon Vieille <simon@deblan.fr>
 */
class AuthController extends Controller
{
    /**
     * @Route("/auth", name="auth")
     * @param Request $request
     *
     * @return \Symfony\Bundle\FrameworkBundle\Controller\Response
     */
    public function authAction(Request $request)
    {
    }
}
