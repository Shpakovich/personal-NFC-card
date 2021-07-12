<?php

declare(strict_types=1);

namespace App\Controller\Profile;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/profile", name="profile")
 */
class ProfileController extends AbstractController
{
    /**
     * @Route("/create", methods={"POST"}, name=".create")
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function create(): JsonResponse
    {
        return $this->json([], 201);
    }
}
