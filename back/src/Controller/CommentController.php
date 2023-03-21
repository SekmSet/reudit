<?php

namespace App\Controller;

use App\Entity\Articles;
use App\Entity\Comments;
use App\Entity\Users;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/comment')]
class CommentController extends AbstractController
{
    #[Route('/status', name: 'app_comment', methods: 'GET')]
    public function status(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/CommentController.php',
            'http' => 200
        ]);
    }

    #[Route('/{id}', name: 'app_comment_read_one', methods: 'GET')]
    public function readBy(EntityManagerInterface $entityManager, int $id): JsonResponse
    {
        try {
            $comment = $entityManager->getRepository(Comments::class)->find($id);

            if (!$comment) {
                throw $this->createNotFoundException(
                    'No comment found for id '.$id
                );
            }

            return $this->json([
                'message' => 'Comment found !',
                'path' => 'src/Controller/CommentController.php',
                'http' => 200,
                'Arguments' => ['id' => $id],
                'result' => $comment->serialize()
            ]);
        } catch (\Exception $e) {
            return $this->json([
                'message' => 'Internal Servor Error : Error during getting comment with id ' . $id ,
                'path' => 'src/Controller/CommentController.php',
                'http' => 500,
                'Arguments' => ['id' => $id],
                'result' => '',
                'error' => $e->getMessage(),
            ]);
        }
    }

    #[Route('/', name: 'app_comment_read_all', methods: 'GET')]
    public function readAll(EntityManagerInterface $entityManager): JsonResponse
    {
        try {
            $comments = $entityManager->getRepository(Comments::class)->findAll();

            if (!$comments) {
                throw $this->createNotFoundException(
                    'No comments found'
                );
            }

            $result = [];
            foreach ($comments as $comment) {
                $result[] = $comment->serialize();
            }

            return $this->json([
                'message' => 'Comments found  !',
                'path' => 'src/Controller/CommentController.php',
                'http' => 200,
                'Arguments' => [],
                'result' => $result,
                'error' => '',
            ]);
        } catch (\Exception $e) {
            return $this->json([
                'message' => 'Internal Servor Error : Error during getting all comments !',
                'path' => 'src/Controller/CommentController.php',
                'http' => 500,
                'Arguments' => [],
                'result' => '',
                'error' => $e->getMessage(),
            ]);
        }
    }

    #[Route('/', name: 'app_comment_create', methods: 'POST')]
    public function create(EntityManagerInterface $entityManager, Request $request): JsonResponse
    {
        try {
            $content = $request->request->get('content');
            $author = $request->request->get('author');
            $article = $request->request->get('article');

            if ($content === null && $author === null && $article === null) {
                return $this->json([
                    'message' => 'Internal Servor Error : values have to be not null.',
                    'path' => 'src/Controller/CommentController.php',
                    'http' => 500,
                ]);
            }

            $authorExist = $entityManager->getRepository(Users::class)->find(intval($author));
            $articleExist = $entityManager->getRepository(Articles::class)->find(intval($article));

            if (!$authorExist) {
                throw $this->createNotFoundException(
                    'Author does not exist'
                );
            }

            if (!$articleExist) {
                throw $this->createNotFoundException(
                    'Article does not exist'
                );
            }

            $comment = new Comments();
            $comment->setContent(ucfirst(trim($content)));
            $comment->setAuthor($authorExist);
            $comment->setArticle($articleExist);

            $entityManager->persist($comment);
            $entityManager->flush();

            return $this->json([
                'message' => 'Comments created  !',
                'path' => 'src/Controller/CommentController.php',
                'http' => 200,
                'Arguments' => [],
                'result' => '',
                'error' => '',
            ]);
        } catch (\Exception $e) {
            return $this->json([
                'message' => 'Internal Servor Error : Error during posting comment !',
                'path' => 'src/Controller/CommentController.php',
                'http' => 500,
                'Arguments' => [],
                'result' => '',
                'error' => $e->getMessage(),
            ]);
        }
    }

    #[Route('/{id}', name: 'app_comment_update', methods: 'PUT')]
    public function update(EntityManagerInterface $entityManager, Request $request, int $id): JsonResponse
    {
        try {
            if ($id === 0) {
                return $this->json([
                    'message' => 'Internal Servor Error : values have to be not null.',
                    'path' => 'src/Controller/CommentController.php',
                    'http' => 500,
                ]);
            }

            $comment = $entityManager->getRepository(Comments::class)->find($id);

            if (!$comment) {
                throw $this->createNotFoundException(
                    'No comment found for id '.$id
                );
            }

            if ($request->request->has("content")) {
                $content = $request->request->get('content');
                $comment->setContent(ucfirst(trim($content)));
            }

            $entityManager->persist($comment);
            $entityManager->flush();

            return $this->json([
                'message' => 'Comment correctly updated !',
                'path' => 'src/Controller/CommentController.php',
                'http' => 200,
                'Arguments' => ['id' => $id]
            ]);
        } catch (\Exception $e) {
            return $this->json([
                'message' => 'Internal Servor Error : Error during updating comment !',
                'path' => 'src/Controller/CommentController.php',
                'http' => 500,
                'Arguments' => ['id' => $id],
                'error' => $e->getMessage()
            ]);
        }
    }

    #[Route('/{id}', name: 'app_comment_delete', methods: 'DELETE')]
    public function delete(EntityManagerInterface $entityManager, int $id): JsonResponse
    {
        try {
            if ($id === 0) {
                return $this->json([
                    'message' => 'Internal Servor Error : values have to be not null.',
                    'path' => 'src/Controller/CommentController.php',
                    'http' => 500,
                ]);
            }

            $comment = $entityManager->getRepository(Comments::class)->find($id);

            if (!$comment) {
                throw $this->createNotFoundException(
                    'No comment found for id '.$id
                );
            }

            $entityManager->remove($comment);
            $entityManager->flush();

            return $this->json([
                'message' => 'Comment correctly deleted !',
                'path' => 'src/Controller/CommentController.php',
                'http' => 200,
                'Arguments' => ['id' => $id]
            ]);
        } catch(\Exception $e) {
            return $this->json([
                'message' => 'Internal Servor Error : Error during deleting comment !',
                'path' => 'src/Controller/CommentController.php',
                'http' => 500,
                'Arguments' => ['id' => $id],
                'error' => $e->getMessage()
            ]);
        }    }
}
