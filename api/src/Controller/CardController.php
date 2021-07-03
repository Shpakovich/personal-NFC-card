<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/card", name="card")
 */
class CardController extends AbstractController
{
    /**
     * @Route(name="", methods={"POST"})
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function card(): Response
    {
        return $this->json(
            [
                'id' => "69b0d264-518e-4889-9949-2fac14fefb61",
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
