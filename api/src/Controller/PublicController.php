<?php

declare(strict_types=1);

namespace App\Controller;

use App\Fetcher\Profile;
use App\Fetcher\User;
use App\Model\Entity\Common\Id;
use OpenApi\Annotations as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class PublicController extends AbstractController
{
    /**
     * @Route("/", methods={"GET"}, name="home")
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
     * @OA\Response(
     *     response=200,
     *     description="Профиль найден",
     *     @OA\JsonContent(
     *         @OA\Property(property="card", type="object", description="Карта",
     *             @OA\Property(property="id", type="string", description="ID"),
     *             @OA\Property(property="alias", type="string", description="Псевдоним карты"),
     *         ),
     *         @OA\Property(property="profile", type="object", description="Профиль",
     *             @OA\Property(property="name", type="string", description="Имя"),
     *             @OA\Property(property="photo", type="object", description="Фотография",
     *                 @OA\Property(property="path", type="string", description="Путь до картинки"),
     *             ),
     *             @OA\Property(property="post", type="string", description="Должность"),
     *             @OA\Property(property="description", type="string", description="Описание"),
     *             @OA\Property(property="fields", type="array", description="Поля"),
     *             @OA\Property(property="custom", type="array", description="Пользовательские поля"),
     *         )
     *     )
     * )
     *
     * @OA\Response(response=404, description="Профиль не найден")
     *
     * @OA\Tag(name="Public")
     *
     * @param string $identity
     * @param \App\Fetcher\User\ProfileFetcher $profiles
     * @param \App\Fetcher\Profile\FieldFetcher $fields
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function show(string $identity, User\ProfileFetcher $profiles, Profile\FieldFetcher $fields): JsonResponse
    {
        $filter = (new User\Filter())
            ->withIdentity($identity)
            ->withIsOnlyPublished(true);

        try {
            $profile = $profiles->getOneByFilter($filter);
        } catch (\DomainException $e) {
            throw new NotFoundHttpException($e->getMessage());
        }

        $profileFields = $fields->getAllByProfileId(new Id($profile['id']));

        $photo = null;
        if (!empty($profile['photo_path'])) {
            $photo = [
                'path' => $profile['photo_path'],
            ];
        }

        return $this->json(
            [
                'card' => [
                    'id' => $profile['card_id'],
                    'alias' => $profile['card_alias'],
                ],
                'profile' => [
                    'id' => $profile['id'],
                    'name' => $profile['name'],
                    'photo' => $photo,
                    'post' => $profile['post'],
                    'description' => $profile['description'],
                    'fields' => $this->groupFields($profileFields),
                    'custom' => [
                        [
                            'id' => 'b38285f0-e0eb-4ef9-9a70-ff9b20d44a66',
                            'title' => 'facebook',
                            'value' => 'https://facebook.com/...',
                            'icon' => 'path/to/icon.png',
                            'colors' => [
                                'bg' => '#000000',
                                'text' => '#444333'
                            ]
                        ]
                    ]
                ]
            ]
        );
    }

    private function groupFields(array $fields): array
    {
        $result = [];

        foreach ($fields as $field) {
            $group = $field['field_type_name'];
            $result[$group][] = [
                'id' => $field['field_id'],
                'title' => $field['field_title'],
                'value' => $field['field_value'],
                'sort' => $field['field_sort'],
                'type' => [
                    'id' => $field['field_type_id'],
                    'name' => $field['field_type_name'],
                    'sort' => $field['field_type_sort'],
                ],
                'icon' => $field['field_icon_path'],
                'colors' => [
                    'bg' => $field['field_bg_color'],
                    'text' => $field['field_text_color'],
                ],
            ];
        }

        return $result;
    }
}
