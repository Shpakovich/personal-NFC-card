<?php

declare(strict_types=1);

namespace App\Controller;

use App\Event\Profile\ShowEvent;
use App\Fetcher\Profile;
use App\Fetcher\User;
use App\Model\Entity\Common\Id;
use App\Model\Service\Storage\Storage;
use OpenApi\Annotations as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class PublicController extends AbstractController
{
    private Storage $storage;
    private EventDispatcherInterface $dispatcher;

    public function __construct(Storage $storage, EventDispatcherInterface $dispatcher)
    {
        $this->storage = $storage;
        $this->dispatcher = $dispatcher;
    }

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
     *             @OA\Property(property="fields", type="object", description="Поля",
     *                 @OA\Property(property="type_name", type="array", description="Поля типа",
     *                     @OA\Items(
     *                         @OA\Property(property="id", type="string", description="ID"),
     *                         @OA\Property(property="title", type="string", description="Заголовок"),
     *                         @OA\Property(property="volue", type="string", description="Значение"),
     *                         @OA\Property(property="sort", type="integer", description="Порядок вывода"),
     *                         @OA\Property(property="type", type="object", description="Тип",
     *                             @OA\Property(property="id", type="string", description="ID"),
     *                             @OA\Property(property="name", type="string", description="Название"),
     *                             @OA\Property(property="sort", type="integer", description="Порядок вывода"),
     *                         ),
     *                         @OA\Property(property="icon", type="string", description="Путь до иконки"),
     *                         @OA\Property(property="colors", type="object", description="Цвета",
     *                             @OA\Property(property="bg", type="string", description="Цвет фона"),
     *                             @OA\Property(property="text", type="string", description="Цвет текста"),
     *                         ),
     *                     )
     *                 ),
     *             ),
     *             @OA\Property(property="custom", type="array", description="Пользовательские поля",
     *                 @OA\Items(
     *                     @OA\Property(property="id", type="string", description="ID"),
     *                     @OA\Property(property="title", type="string", description="Заголовок"),
     *                     @OA\Property(property="volue", type="string", description="Значение"),
     *                     @OA\Property(property="sort", type="integer", description="Порядок вывода"),
     *                     @OA\Property(property="icon", type="string", description="Путь до иконки"),
     *                     @OA\Property(property="colors", type="object", description="Цвета",
     *                         @OA\Property(property="bg", type="string", description="Цвет фона"),
     *                         @OA\Property(property="text", type="string", description="Цвет текста"),
     *                     ),
     *                 )
     *             ),
     *         )
     *     )
     * )
     *
     * @OA\Response(response=404, description="Профиль не найден")
     *
     * @OA\Tag(name="Public")
     *
     * @param string $identity
     * @param \App\Fetcher\Profile\Profile\ProfileFetcher $profiles
     * @param \App\Fetcher\Profile\Field\FieldFetcher $fields
     * @param \App\Fetcher\Profile\FieldCustom\FieldFetcher $customFields
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     * @throws \Doctrine\DBAL\Driver\Exception
     * @throws \Doctrine\DBAL\Exception
     * @throws \Symfony\Component\Serializer\Exception\ExceptionInterface
     */
    public function show(
        string $identity,
        Profile\Profile\ProfileFetcher $profiles,
        Profile\Field\FieldFetcher $fields,
        Profile\FieldCustom\FieldFetcher $customFields
    ): JsonResponse {
        $filter = (new User\Filter())
            ->withIdentity($identity)
            ->withIsOnlyPublished(true);

        try {
            $profile = $profiles->getOneByFilter($filter);
        } catch (\DomainException $e) {
            throw new NotFoundHttpException($e->getMessage());
        }

        $profileFields = $fields->getAllByProfileId(new Id($profile->id));
        $profileCustomFields = $customFields->getAllByProfileId(new Id($profile->id));

        $photo = null;
        if (!empty($profile->photoPath)) {
            $photo = [
                'path' => $this->storage->url($profile->photoPath),
            ];
        }

        /** @var string $profile->userCardId */
        $this->dispatcher->dispatch(new ShowEvent($profile->userCardId, $profile->id));

        return $this->json(
            [
                'card' => [
                    'id' => $profile->cardId,
                    'alias' => $profile->cardAlias,
                ],
                'profile' => [
                    'id' => $profile->id,
                    'name' => $profile->name,
                    'photo' => $photo,
                    'post' => $profile->post,
                    'description' => $profile->description,
                    'fields' => $this->groupFields($profileFields),
                    'custom' => $this->customFields($profileCustomFields)
                ]
            ]
        );
    }

    /**
     * @param \App\Fetcher\Profile\Field\FieldDto[] $fields
     * @return array
     */
    private function groupFields(array $fields): array
    {
        $result = [];

        foreach ($fields as $field) {
            $group = $field->typeName;

            $icon = null;
            if (!empty($field->iconPath)) {
                $icon = [
                    'path' => $this->storage->url($field->iconPath)
                ];
            }

            $result[$group][] = [
                'id' => $field->id,
                'title' => $field->title,
                'value' => $field->value,
                'sort' => $field->sort,
                'type' => [
                    'id' => $field->typeId,
                    'name' => $field->typeName,
                    'sort' => $field->typeSort,
                ],
                'icon' => $icon,
                'colors' => [
                    'bg' => $field->bgColor,
                    'text' => $field->textColor,
                ],
            ];
        }

        return $result;
    }

    /**
     * @param \App\Fetcher\Profile\FieldCustom\FieldDto[] $fields
     * @return array
     */
    private function customFields(array $fields): array
    {
        return array_map(
            function (Profile\FieldCustom\FieldDto $field) {
                $icon = null;
                if (!empty($field->iconPath)) {
                    $icon = [
                        'path' => $this->storage->url($field->iconPath)
                    ];
                }

                return [
                    'id' => $field->id,
                    'title' => $field->title,
                    'value' => $field->value,
                    'sort' => $field->sort,
                    'icon' => $icon,
                    'colors' => [
                        'bg' => $field->bgColor,
                        'text' => $field->textColor
                    ]
                ];
            },
            $fields
        );
    }
}
