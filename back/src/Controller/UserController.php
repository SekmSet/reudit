<?php

namespace App\Controller;

use App\Entity\Users;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user')]
class UserController extends AbstractController
{

    public function __construct(
        // Avoid calling getFirewallConfig() in the constructor: auth may not
        // be complete yet. Instead, store the entire Security object.
        private Security $security,
        private RequestStack $requestStack,
        private EntityManagerInterface $entityManager
    ) {
    }

    #[Route('/status', name: 'app_user')]
    public function status(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/UserController.php',
            'http' => 200
        ]);
    }

    #[Route('/{id}', name: 'app_user_read_one', methods: 'GET')]
    public function readBy(int $id): JsonResponse
    {
        try {
            $user = $this->entityManager->getRepository(Users::class)->find($id);

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
            ], 500);
        }
    }

    #[Route('/', name: 'app_user_read_all', methods: 'GET')]
    public function readAll(): JsonResponse
    {
        try {
            $users = $this->entityManager->getRepository(Users::class)->findAll();

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
            ], 500);
        }
    }

    #[Route('/', name: 'app_user_create', methods: 'POST')]
    public function create(
        EntityManagerInterface $entityManager,
        Request $request,
        UserPasswordHasherInterface $passwordHasher): JsonResponse
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
                ], 500);
            }

            $user = new Users();
            $hashedPassword = $passwordHasher->hashPassword(
                $user,
                trim($password)
            );

            $user->setPassword($hashedPassword);
            $user->setName(trim($name));
            $user->setEmail(trim($email));
            $user->setRoles(['ROLE_USER']);

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
            ], 500);
        }
    }

    #[Route('/{id}', name: 'app_user_update', methods: 'PUT')]
    public function update(Request $request, int $id, UserPasswordHasherInterface $passwordHasher): JsonResponse
    {
        try {
            if ($id === 0) {
                return $this->json([
                    'message' => 'Internal Servor Error : values have to be not null.',
                    'path' => 'src/Controller/UserController.php',
                    'http' => 500,
                ], 500);
            }

            $user = $this->entityManager->getRepository(Users::class)->find($id);

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
                $hashedPassword = $passwordHasher->hashPassword(
                    $user,
                    trim($password)
                );

                $user->setPassword($hashedPassword);
            }

            // Only Admin can change users's role
            if ($request->request->has("role")) {
                $role = $request->request->get('role');
                $user->setRoles([$role]);
            }

            $this->entityManager->persist($user);
            $this->entityManager->flush();

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
            ], 500);
        }
    }

    #[Route('/{id}', name: 'app_user_delete', methods: 'DELETE')]
    public function delete(int $id): JsonResponse
    {
        try {
            $request = $this->requestStack->getCurrentRequest();
            $firewallName = $this->security->getFirewallConfig($request)?->getName();

            if ($id === 0) {
                return $this->json([
                    'message' => 'Internal Servor Error : values have to be not null.',
                    'path' => 'src/Controller/UserController.php',
                    'http' => 500,
                ], 500);
            }

            $user = $this->entityManager->getRepository(Users::class)->find($id);

            if (!$user) {
                throw $this->createNotFoundException(
                    'No user found for id '.$id
                );
            }

            $this->entityManager->remove($user);
            $this->entityManager->flush();

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
            ], 500);
        }
    }
}
