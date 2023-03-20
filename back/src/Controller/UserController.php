<?php

namespace App\Controller;

use App\Entity\Users;
use Doctrine\ORM\EntityManagerInterface;
use mysql_xdevapi\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use function Sodium\add;

#[Route('/user')]
class UserController extends AbstractController
{
    #[Route('/status', name: 'app_user')]
    public function status(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/UserController.php',
            'http' => 200
        ]);
    }

    #[Route('/', name: 'app_user_read_all', methods: 'GET')]
    public function readAll(EntityManagerInterface $entityManager): JsonResponse
    {
        try {
            $users = $entityManager->getRepository(Users::class)->findAll();

            if (!$users) {
                throw $this->createNotFoundException(
                    'No users found'
                );
            }

            $result = [];
            foreach ($users as $user) {
                $result[] = $user->serialize();
            }

            return $this->json([
                'message' => 'Users found',
                'path' => 'src/Controller/UserController.php',
                'http' => 200,
                'result' => $result
            ]);
        } catch (\Exception $e) {
            return $this->json([
                'message' => 'Internal Servor Error : Error during getting users !',
                'path' => 'src/Controller/UserController.php',
                'http' => 500,
                'error' => $e->getMessage()
            ]);
        }
    }

    #[Route('/{id}', name: 'app_user_read_one', methods: 'GET')]
    public function readBy(EntityManagerInterface $entityManager, int $id): JsonResponse
    {
        try {
            $user = $entityManager->getRepository(Users::class)->find($id);

            if (!$user) {
                throw $this->createNotFoundException(
                    'No user found for id '.$id
                );
            }

            return $this->json([
                'message' => 'User found !',
                'path' => 'src/Controller/UserController.php',
                'http' => 200,
                'Arguments' => ['id' => $id],
                'result' => $user->serialize()
            ]);
        } catch(\Exception $e) {
            return $this->json([
                'message' => 'Internal Servor Error : Error during getting user !',
                'path' => 'src/Controller/UserController.php',
                'http' => 500,
                'error' => $e->getMessage()
            ]);
        }
    }

    #[Route('/', name: 'app_user_create', methods: 'POST')]
    public function create(EntityManagerInterface $entityManager, Request $request): JsonResponse
    {
        try {
            $name = $request->request->get('name');
            $email = $request->request->get('email');
            $password = $request->request->get('password');
            $role = $request->request->get('role');

            if ($name === null && $email === null && $password === null && $role === null ) {
                return $this->json([
                    'message' => 'Internal Servor Error : values have to be not null.',
                    'path' => 'src/Controller/UserController.php',
                    'http' => 500,
                ]);
            }

            $hash = $this->encryptPassword(trim($password));

            $user = new Users();
            $user->setName(ucfirst(trim($name)));
            $user->setEmail(trim($email));
            $user->setRole(ucfirst(trim($role)));
            $user->setPassword($hash);

            $entityManager->persist($user);
            $entityManager->flush();

            return $this->json([
                'message' => 'User created successfully!',
                'path' => 'src/Controller/UserController.php',
                'http' => 200,
            ]);
        } catch (\Exception $e) {
            return $this->json([
                'message' => 'Internal Servor Error : Error during creating user!',
                'path' => 'src/Controller/UserController.php',
                'http' => 500,
                'error' => $e->getMessage()
            ]);
        }
    }

    #[Route('/update/{id}', name: 'app_user_update', methods: 'PUT')]
    public function update(EntityManagerInterface $entityManager, Request $request, int $id): JsonResponse
    {
        try {
            if ($id === 0) {
                return $this->json([
                    'message' => 'Internal Servor Error : values have to be not null.',
                    'path' => 'src/Controller/UserController.php',
                    'http' => 500,
                ]);
            }

            $user = $entityManager->getRepository(Users::class)->find($id);

            if (!$user) {
                throw $this->createNotFoundException(
                    'No user found for id '.$id
                );
            }

            if ($request->request->has("name")) {
                $name = $request->request->get('name');
                $user->setName(ucfirst(trim($name)));
            }
            if ($request->request->has("password")) {
                $password = $request->request->get('password');
                $hash = $this->encryptPassword(trim($password));
                $user->setPassword($hash);
            }
            if ($request->request->has("name")) {
                $role = $request->request->get('role');
                $user->setRole(ucfirst(trim($role)));
            }

            $entityManager->persist($user);
            $entityManager->flush();

            return $this->json([
                'message' => 'User correctly updated !',
                'path' => 'src/Controller/UserController.php',
                'http' => 200,
                'Arguments' => ['id' => $id]
            ]);
        } catch (\Exception $e) {
            return $this->json([
                'message' => 'Internal Servor Error : Error during updating user!',
                'path' => 'src/Controller/UserController.php',
                'http' => 500,
                'Arguments' => ['id' => $id],
                'error' => $e->getMessage()
            ]);
        }
    }

    #[Route('/delete/{id}', name: 'app_user_delete', methods: 'DELETE')]
    public function delete(EntityManagerInterface $entityManager, int $id): JsonResponse
    {
        try {
            if ($id === 0) {
                return $this->json([
                    'message' => 'Internal Servor Error : values have to be not null.',
                    'path' => 'src/Controller/UserController.php',
                    'http' => 500,
                ]);
            }

            $user = $entityManager->getRepository(Users::class)->find($id);

            if (!$user) {
                throw $this->createNotFoundException(
                    'No user found for id '.$id
                );
            }

            $entityManager->remove($user);
            $entityManager->flush();

            return $this->json([
                'message' => 'User correctly deleted !',
                'path' => 'src/Controller/UserController.php',
                'http' => 200,
                'Arguments' => ['id' => $id]
            ]);
        } catch (\Exception $e) {
            return $this->json([
                'message' => 'Internal Servor Error : Error during deleting user!',
                'path' => 'src/Controller/UserController.php',
                'http' => 500,
                'Arguments' => ['id' => $id],
                'error' => $e->getMessage()
            ]);
        }
    }

    private function encryptPassword($password): string
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }
}
