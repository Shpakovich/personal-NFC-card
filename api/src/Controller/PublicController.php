<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class PublicController extends AbstractController
{
    /**
     * @Route("/", name="api")
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function index(): JsonResponse
    {
        return $this->json(['name' => 'Personal NFS card API']);
    }

    /**
     * @Route("/show/{id}", methods={"GET"}, name="show", requirements={
     *     "id"=Guid::PATTERN
     * })
     *
     * @param string $id
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function show(string $id): JsonResponse
    {
        return $this->json(
            [
                'id' => $id,
                'name' => "nick.norman",
                "profile" => [
                    "photo" => "path/to/photo.jpg",
                    "post" => "Director",
                    "description" => "...",
                    "fields" => [
                        [
                            "id" => "ec982d5b-aea5-4565-99ec-9afef507f498",
                            "title" => "facebook",
                            "value" => "https://facebook.com/...",
                            "type" => "network",
                            "icon" => "path/to/icon.png",
                            "colors" => [
                                "bg" => "#000000",
                                "text" => "#444333"
                            ]
                        ]
                    ],
                    "custom" => [
                        [
                            "id" => "b38285f0-e0eb-4ef9-9a70-ff9b20d44a66",
                            "title" => "facebook",
                            "value" => "https://facebook.com/...",
                            "type" => "network",
                            "icon" => "path/to/icon.png",
                            "colors" => [
                                "bg" => "#000000",
                                "text" => "#444333"
                            ]
                        ]
                    ]
                ]
            ]
        );
    }
}
