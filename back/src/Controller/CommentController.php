<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/comment')]
class CommentController extends AbstractController
{
    #[Route('/status', name: 'app_comment')]
    public function status(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/CommentController.php',
            'http' => 200
        ]);
    }

    #[Route('/{id}', name: 'app_comment_read_one')]
    public function readBy(string $id): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/CommentController.php',
            'http' => 200,
            'Arguments' => ['id' => $id]
        ]);
    }

    #[Route('/{id}', name: 'app_comment_read_all')]
    public function readAll(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/CommentController.php',
            'http' => 200,
        ]);
    }

    #[Route('/create', name: 'app_comment_create', methods: 'POST')]
    public function create(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/CommentController.php',
            'http' => 200,
        ]);
    }

    #[Route('/update/{id}', name: 'app_comment_update', methods: 'PUT')]
    public function update(string $id): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/CommentController.php',
            'http' => 200,
            'Arguments' => ['id' => $id]
        ]);
    }

    #[Route('/delete/{id}', name: 'app_comment_delete', methods: 'DELETE')]
    public function delete(string $id): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/CommentController.php',
            'http' => 200,
            'Arguments' => ['id' => $id]
        ]);
    }
}
