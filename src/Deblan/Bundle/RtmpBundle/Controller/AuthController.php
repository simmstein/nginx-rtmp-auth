<?php

namespace Deblan\Bundle\RtmpBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Simon Vieille <simon@deblan.fr>
 */
class AuthController extends Controller
{
    /**
     * @param Request $request
     *
     * @return Response
     *
     * @Route("/auth", name="auth")
     */
    public function authAction(Request $request)
    {
        $authProvider = $this->container->get('rtmp.auth.propel_provider');

        $authProvider->handleRequest($request);

        return new Response(null, $authProvider->isValid() ? 200 : 401);
    }
}
