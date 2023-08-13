<?php

namespace App\Controller;

use App\Repository\CustomerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

class ChangepassController extends AbstractController
{
    public function __construct(private EntityManagerInterface $entityManager, ) {}

    #[Route('/changepass', name: 'app_changepass')]
    public function index(Request $request, UserPasswordHasherInterface $passwordHasher): Response
    {
        $user = $this->getUser();

        if (!$user instanceof PasswordAuthenticatedUserInterface) {
            throw new \LogicException('The user class must implement PasswordAuthenticatedUserInterface.');
        }

        $data = json_decode($request->getContent(), true);
        $currentPassword = $data['currentPassword'];

        if ($passwordHasher->isPasswordValid($user, $currentPassword)) {
            return new Response(null, Response::HTTP_OK);
        } else {
            return new Response(null, Response::HTTP_UNAUTHORIZED);
        }
    }

    #[Route('/changepassword', name: 'app_changepassword', methods: ['POST'])]
    public function changePassword(Request $request, UserPasswordHasherInterface $passwordHasher): Response
    {
        $data = json_decode($request->getContent(), true);
        $newPassword = $data['newPassword'];

        $user = $this->getUser();

        if (!$user instanceof PasswordAuthenticatedUserInterface) {
            throw new \LogicException('The user class must implement PasswordAuthenticatedUserInterface.');
        }

        // Hash and update the new password
        $hashedPassword = $passwordHasher->hashPassword($user, $newPassword);
        $user->setPassword($hashedPassword);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return new Response(null, Response::HTTP_OK);
    }
}
