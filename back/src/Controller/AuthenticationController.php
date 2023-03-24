<?php

namespace App\Controller;

use App\Entity\Users;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\Security\Core\User\UserInterface;

#[Route('/authentication')]
class AuthenticationController extends AbstractController
{
    #[Route('/status', name: 'app_authentication_status', methods: 'GET')]
    public function status(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/AuthenticationController.php',
            'http' => 200
        ]);
    }

    #[Route('/login', name: 'api_authentication_login', methods: 'POST')]
    public function index(#[CurrentUser] ?Users $user, Security $security): JsonResponse
    {
        $token = $security->getToken();

        return $this->json([
            'user'  => $user->getUserIdentifier(),
            'token' => $token,
        ]);
    }

}
