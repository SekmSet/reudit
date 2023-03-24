<?php

namespace App\Controller;

use App\Entity\Articles;
use App\Entity\Categories;
use App\Entity\Label;
use App\Entity\Users;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

#[Route('/article')]
class ArticleController extends AbstractController
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }


    #[Route('/status', name: 'app_article_status')]
    public function status(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/ArticleController.php',
            'http' => 200
        ]);
    }

    #[Route('/{id}', name: 'app_article_read_one', methods: 'GET')]
    public function readBy(int $id): JsonResponse
    {
        try {
            $article = $this->entityManager->getRepository(Articles::class)->find($id);

            if (!$article) {
                throw $this->createNotFoundException(
                    'No article found for id ' . $id
                );
            }

            return $this->json([
                'message' => 'Article found !',
                'path' => 'src/Controller/ArticleController.php',
                'http' => 200,
                'Arguments' => ['id' => $id],
                'result' => $article->serialize()
            ]);
        } catch (\Exception $e) {
            return $this->json([
                'message' => 'Internal Servor Error : Error during getting article !',
                'path' => 'src/Controller/ArticleController.php',
                'http' => 500,
                'Arguments' => ['id' => $id],
                'error' => $e
            ], 500);
        }
    }

    #[Route('/', name: 'app_article_read_all', methods: 'GET')]
    public function readAll(): JsonResponse
    {
        try {
            $articles = $this->entityManager->getRepository(Articles::class)->findAll();

            if (!$articles) {
                throw $this->createNotFoundException(
                    'No articles found'
                );
            }

            $result = [];
            foreach ($articles as $article) {
                $result[] = $article->serialize();
            }

            return $this->json([
                'message' => 'Articles found',
                'path' => 'src/Controller/ArticleController.php',
                'http' => 200,
                'result' => $result
            ]);
        } catch (\Exception $e) {
            return $this->json([
                'message' => 'Internal Servor Error : Error during getting articles !',
                'path' => 'src/Controller/ArticleController.php',
                'http' => 500,
                'error' => $e
            ], 500);
        }
    }

    #[Route('/', name: 'app_article_create', methods: 'POST')]
    public function create(Request $request, UserInterface $user): JsonResponse
    {
        try {
            $title = $request->request->get('title');
            $content = $request->request->get('content');
            $category = $request->request->get('category');
            $label = $request->request->get('label');

            if ($title === null && $content === null && $category === null && $label === null) {
                return $this->json([
                    'message' => 'Internal Servor Error : values have to be not null.',
                    'path' => 'src/Controller/ArticleController.php',
                    'http' => 500,
                ]);
            }

            $authorExist = $this->entityManager->getRepository(Users::class)->find($user->getUserIdentifier());
            $labelExist = $this->entityManager->getRepository(Label::class)->find(intval($label));
            $categoryExist = $this->entityManager->getRepository(Categories::class)->find(intval($category));

            if (!$authorExist) {
                throw $this->createNotFoundException(
                    'Author does not exist'
                );
            }

            if (!$labelExist) {
                throw $this->createNotFoundException(
                    'Label does not exist'
                );
            }

            if (!$categoryExist) {
                throw $this->createNotFoundException(
                    'Category does not exist'
                );
            }

            $article = new Articles();
            $article->setTitle(ucfirst(ucfirst(trim($title))));
            $article->setContent(ucfirst(trim($content)));
            $article->setAuthor($authorExist);
            $article->setLabel($labelExist);
            $article->setCategory($categoryExist);

            $this->entityManager->persist($article);
            $this->entityManager->flush();

            return $this->json([
                'message' => 'New article created successfully!',
                'path' => 'src/Controller/ArticleController.php',
                'http' => 201,
            ], 201);
        } catch (\Exception $e) {
            return $this->json([
                'message' => 'Internal Servor Error : Error during creating article !',
                'path' => 'src/Controller/ArticleController.php',
                'http' => 500,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    #[Route('/{id}', name: 'app_article_update', methods: 'PUT')]
    public function update(Request $request, int $id): JsonResponse
    {
        try {
            if ($id === 0) {
                return $this->json([
                    'message' => 'Internal Servor Error : values have to be not null.',
                    'path' => 'src/Controller/ArticleController.php',
                    'http' => 500,
                ], 500);
            }

            $article = $this->entityManager->getRepository(Articles::class)->find($id);

            if (!$article) {
                throw $this->createNotFoundException(
                    'No article found for id ' . $id
                );
            }

            if ($request->request->has("title")) {
                $title = $request->request->get('title');
                $article->setTitle(ucfirst(trim($title)));
            }
            if ($request->request->has("content")) {
                $content = $request->request->get('content');
                $article->setContent($content);
            }

            if ($request->request->has("category")) {
                $category = $request->request->get('category');

                $categoryExist = $this->entityManager->getRepository(Categories::class)->find(intval($category));

                if (!$categoryExist) {
                    throw $this->createNotFoundException(
                        'Category does not exist'
                    );
                }

                $article->setCategory($categoryExist);
            }

            if ($request->request->has("label")) {
                $label = $request->request->get('label');

                $labelExist = $this->entityManager->getRepository(Label::class)->find(intval($label));

                if (!$labelExist) {
                    throw $this->createNotFoundException(
                        'Label does not exist'
                    );
                }

                $article->setLabel($labelExist);
            }

            $this->entityManager->persist($article);
            $this->entityManager->flush();

            return $this->json([
                'message' => 'Article correctly updated!',
                'path' => 'src/Controller/ArticleController.php',
                'http' => 200,
                'Arguments' => ['id' => $id]
            ]);
        } catch (\Exception $e) {
            return $this->json([
                'message' => 'Internal Servor Error : Error during updating article !',
                'path' => 'src/Controller/ArticleController.php',
                'http' => 500,
                'Arguments' => ['id' => $id],
                'error' => $e
            ], 500);
        }
    }

    #[Route('/{id}', name: 'app_article_delete', methods: 'DELETE')]
    public function delete(int $id): JsonResponse
    {
        try {
            if ($id === 0) {
                return $this->json([
                    'message' => 'Internal Servor Error : values have to be not null.',
                    'path' => 'src/Controller/ArticleController.php',
                    'http' => 500,
                ], 500);
            }

            $article = $this->entityManager->getRepository(Articles::class)->find($id);

            if (!$article) {
                throw $this->createNotFoundException(
                    'No article found for id ' . $id
                );
            }

            $this->entityManager->remove($article);
            $this->entityManager->flush();

            return $this->json([
                'message' => 'Article correctly deleted !',
                'path' => 'src/Controller/ArticleController.php',
                'http' => 200,
                'Arguments' => ['id' => $id]
            ]);
        } catch (\Exception $e) {
            return $this->json([
                'message' => 'Internal Servor Error : Error during deleting article !',
                'path' => 'src/Controller/ArticleController.php',
                'http' => 500,
                'Arguments' => ['id' => $id],
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
