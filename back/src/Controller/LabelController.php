<?php

namespace App\Controller;

use App\Entity\Categories;
use App\Entity\Label;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/label')]
class LabelController extends AbstractController
{
    #[Route('/status', name: 'app_label')]
    public function status(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/LabelController.php',
            'http' => 200
        ]);
    }

    #[Route('/{id}', name: 'app_label_read_one', methods: 'GET')]
    public function readBy(EntityManagerInterface $entityManager, string $id): JsonResponse
    {
        try {
            $label = $entityManager->getRepository(Label::class)->find($id);

            if (!$label) {
                throw $this->createNotFoundException(
                    'No label found for id '.$id
                );
            }

            return $this->json([
                'message' => 'Label found !',
                'path' => 'src/Controller/LabelController.php',
                'http' => 200,
                'Arguments' => ['id' => $id],
                'result' => $label->serialize()
            ]);
        } catch (\Exception $e) {
            return $this->json([
                'message' => 'Internal Servor Error : Error during getting label !',
                'path' => 'src/Controller/CategoryController.php',
                'http' => 500,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    #[Route('/', name: 'app_label_read_all', methods: 'GET')]
    public function readAll(EntityManagerInterface $entityManager): JsonResponse
    {
        try {
            $labels = $entityManager->getRepository(Label::class)->findAll();

            $result = [];
            foreach ($labels as $label) {
                $result[] = $label->serialize();
            }

            return $this->json([
                'message' => 'Labels found',
                'path' => 'src/Controller/LabelController.php',
                'http' => 200,
                'result' => $result
            ]);
        } catch (NotFoundHttpException $e) {
            return $this->json([
                'message' => 'No label found',
                'path' => 'src/Controller/LabelController.php',
                'http' => 200,
                'result' => []
            ], 200);
        } catch (\Exception $e) {
            return $this->json([
                'message' => 'Internal Servor Error : Error during getting labels !',
                'path' => 'src/Controller/CategoryController.php',
                'http' => 500,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    #[Route('/', name: 'app_label_create', methods: 'POST')]
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

            $label = new Label();
            $label->setLabel(ucfirst(ucfirst(trim($name))));

            $entityManager->persist($label);
            $entityManager->flush();

            return $this->json([
                'message' => 'Label created successfully!',
                'path' => 'src/Controller/LabelController.php',
                'http' => 200,
            ]);
        } catch (\Exception $e) {
            return $this->json([
                'message' => 'Internal Servor Error : Error during creating label!',
                'path' => 'src/Controller/CategoryController.php',
                'http' => 500,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    #[Route('/{id}', name: 'app_label_update', methods: 'PUT')]
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

            $label = $entityManager->getRepository(Label::class)->find($id);

            if (!$label) {
                throw $this->createNotFoundException(
                    'No label found for id '.$id
                );
            }

            if ($request->request->has("label")) {
                $name = $request->request->get('label');
                $label->setLabel(ucfirst(trim($name)));
            }

            $entityManager->persist($label);
            $entityManager->flush();

            return $this->json([
                'message' => 'Label correctly updated !',
                'path' => 'src/Controller/LabelController.php',
                'http' => 200,
            ]);
        } catch (\Exception $e) {
            return $this->json([
                'message' => 'Internal Servor Error : Error during updating label !',
                'path' => 'src/Controller/CategoryController.php',
                'http' => 500,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    #[Route('/{id}', name: 'app_label_delete', methods: 'DELETE')]
    public function delete(EntityManagerInterface $entityManager, int $id): JsonResponse
    {
        try {
            if ($id === 0) {
                return $this->json([
                    'message' => 'Internal Servor Error : values have to be not null.',
                    'path' => 'src/Controller/LabelController.php',
                    'http' => 500,
                ], 500);
            }

            $label = $entityManager->getRepository(Label::class)->find($id);

            if (!$label) {
                throw $this->createNotFoundException(
                    'No label found for id '.$id
                );
            }

            $entityManager->remove($label);
            $entityManager->flush();

            return $this->json([
                'message' => 'Label correctly deleted !',
                'path' => 'src/Controller/LabelController.php',
                'http' => 200,
                'Arguments' => ['id' => $id]
            ]);
        } catch(\Exception $e) {
            return $this->json([
                'message' => 'Internal Servor Error : Error during deleting label !',
                'path' => 'src/Controller/LabelController.php',
                'http' => 200,
                'Arguments' => ['id' => $id],
                'error' => $e
            ], 500);
        }

    }
}
