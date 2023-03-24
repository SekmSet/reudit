<?php

namespace App\Controller;

use App\Entity\Categories;
use App\Entity\Users;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/category')]
class CategoryController extends AbstractController
{
    #[Route('/status', name: 'app_category')]
    public function status(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/CategoryController.php',
            'http' => 200
        ], 200);
    }

    #[Route('/{id}', name: 'app_category_read_one', methods: 'GET')]
    public function readBy(EntityManagerInterface $entityManager, string $id): JsonResponse
    {
        try {
            $category = $entityManager->getRepository(Categories::class)->find($id);

            if (!$category) {
                throw $this->createNotFoundException(
                    'No category found for id '.$id
                );
            }

            return $this->json([
                'message' => 'Welcome to your new controller!',
                'path' => 'src/Controller/CategoryController.php',
                'http' => 200,
                'Arguments' => ['id' => $id],
                'result' => $category->serialize()
            ]);
        } catch (\Exception $e) {
            return $this->json([
                'message' => 'Internal Servor Error : Error during getting category !',
                'path' => 'src/Controller/CategoryController.php',
                'http' => 500,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    #[Route('/', name: 'app_category_read_all', methods: 'GET')]
    public function readAll(EntityManagerInterface $entityManager): JsonResponse
    {
        try {
            $categories = $entityManager->getRepository(Categories::class)->findAll();

            if (!$categories) {
                throw $this->createNotFoundException(
                    'No categories found'
                );
            }

            $result = [];
            foreach ($categories as $category) {
                $result[] = $category->serialize();
            }

            return $this->json([
                'message' => 'Categories found',
                'path' => 'src/Controller/CategoryController.php',
                'http' => 200,
                'result' => $result
            ]);
        } catch (NotFoundHttpException $e) {
            return $this->json([
                'message' => 'No categories found',
                'path' => 'src/Controller/CategoryController.php',
                'http' => 200,
                'result' => []
            ], 200);
        } catch (\Exception $e) {
            return $this->json([
                'message' => 'Internal Servor Error : Error during getting categories !',
                'path' => 'src/Controller/CategoryController.php',
                'http' => 500,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    #[Route('/', name: 'app_category_create', methods: 'POST')]
    public function create(EntityManagerInterface $entityManager, Request $request): JsonResponse
    {
        try {
            $name = $request->request->get('label');

            if ($name === null) {
                return $this->json([
                    'message' => 'Internal Servor Error : values have to be not null.',
                    'path' => 'src/Controller/CategoryController.php',
                    'http' => 500,
                ], 500);
            }

            $category = new Categories();
            $category->setLabel(ucfirst(trim($name)));

            $entityManager->persist($category);
            $entityManager->flush();

            return $this->json([
                'message' => 'Category created successfully!',
                'path' => 'src/Controller/CategoryController.php',
                'http' => 200,
            ]);
        } catch (\Exception $e) {
            return $this->json([
                'message' => 'Internal Servor Error : Error during creating category !',
                'path' => 'src/Controller/CategoryController.php',
                'http' => 500,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    #[Route('/{id}', name: 'app_category_update', methods: 'PUT')]
    public function update(EntityManagerInterface $entityManager, Request $request, int $id): JsonResponse
    {
        try {
            if ($id === 0) {
                return $this->json([
                    'message' => 'Internal Servor Error : values have to be not null.',
                    'path' => 'src/Controller/CategoryController.php',
                    'http' => 500,
                ], 500);
            }

            $category = $entityManager->getRepository(Categories::class)->find($id);

            if (!$category) {
                throw $this->createNotFoundException(
                    'No category found for id '.$id
                );
            }

            if ($request->request->has("label")) {
                $name = $request->request->get('label');
                $category->setLabel(ucfirst(trim($name)));
            }

            $entityManager->persist($category);
            $entityManager->flush();

            return $this->json([
                'message' => 'Category correctly updated !',
                'path' => 'src/Controller/CategoryController.php',
                'http' => 200,
                'Arguments' => ['id' => $id]
            ]);
        } catch (\Exception $e) {
            return $this->json([
                'message' => 'Internal Servor Error : Error during updating category !',
                'path' => 'src/Controller/CategoryController.php',
                'http' => 500,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    #[Route('/{id}', name: 'app_category_delete', methods: 'DELETE')]
    public function delete(EntityManagerInterface $entityManager, int $id): JsonResponse
    {
        try {
            if ($id === 0) {
                return $this->json([
                    'message' => 'Internal Servor Error : values have to be not null.',
                    'path' => 'src/Controller/CategoryController.php',
                    'http' => 500,
                ], 500);
            }

            $category = $entityManager->getRepository(Categories::class)->find($id);

            if (!$category) {
                throw $this->createNotFoundException(
                    'No category found for id '.$id
                );
            }

            $entityManager->remove($category);
            $entityManager->flush();

            return $this->json([
                'message' => 'Category correctly deleted !',
                'path' => 'src/Controller/CategoryController.php',
                'http' => 200,
                'Arguments' => ['id' => $id]
            ]);
        } catch (\Exception $e) {
            return $this->json([
                'message' => 'Internal Servor Error : Error during deleting category !',
                'path' => 'src/Controller/CategoryController.php',
                'http' => 500,
                'Arguments' => ['id' => $id],
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
