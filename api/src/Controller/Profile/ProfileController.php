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
        return $this->json(
            [
                "id" => "11111111-1111-1111-1111-111111111111",
                "card" => [
                    "id" => "00000000-0000-0000-0000-000000000000",
                    "alias" => "nick.norman",
                ],
                "profile" => [
                    "title" => "Main",
                    "name" => "Nick Norman",
                    "nickname" => "nick",
                    "default_name" => "name",
                    "photo" => "path/to/photo.jpg",
                    "post" => "Director",
                    "description" => "...",
                    "is_published" => false,
                ]
            ],
            201
        );
    }
}
