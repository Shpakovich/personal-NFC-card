<?php

declare(strict_types=1);

namespace App\Controller;

use OpenApi\Annotations as OA;
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
     * @Route("/show/{identity}", methods={"GET"}, name="show")
     *
     * @OA\Get(
     *     summary="Вывести информацию по профилю, который привязан к карте"
     * )
     *
     * @OA\Parameter(
     *     name="identity",
     *     in="path",
     *     required=true,
     *     description="Идентификатор карты (ID или псевдоним)",
     *     @OA\Schema(type="string")
     * )
     *
     * @OA\Response(response=404, description="Карта не найдена")
     *
     * @OA\Tag(name="Public")
     *
     * @param string $identity
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function show(string $identity): JsonResponse
    {
        if ($identity !== '00000000-0000-0000-0000-000000000000' && $identity !== 'nick.norman') {
            throw new \DomainException('Card not found', 404);
        }

        return $this->json(
            [
                "card" => [
                    "id" => "00000000-0000-0000-0000-000000000000",
                    "alias" => "nick.norman",
                ],
                "profile" => [
                    "name" => "Nick Norman",
                    "photo" => "path/to/photo.jpg",
                    "post" => "Director",
                    "description" => "...",
                    "fields" => [
                        "network" => [
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
                            ],
                        ],
                        "phone" => [
                            [
                                "id" => "ec982d5b-aea5-4565-99ec-9afef507f400",
                                "title" => "Work",
                                "value" => "+79004005060",
                                "type" => "phone",
                                "icon" => "path/to/icon.png",
                                "colors" => [
                                    "bg" => "#000000",
                                    "text" => "#444333"
                                ]
                            ],
                            [
                                "id" => "ec982d5b-aea5-4565-99ec-9afef507f500",
                                "title" => "Home",
                                "value" => "+78006005060",
                                "type" => "phone",
                                "icon" => "path/to/icon.png",
                                "colors" => [
                                    "bg" => "#000000",
                                    "text" => "#444333"
                                ]
                            ],
                        ]
                    ],
                    "custom" => [
                        [
                            "id" => "b38285f0-e0eb-4ef9-9a70-ff9b20d44a66",
                            "title" => "facebook",
                            "value" => "https://facebook.com/...",
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
