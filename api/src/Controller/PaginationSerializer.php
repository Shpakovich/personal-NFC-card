<?php

declare(strict_types=1);

namespace App\Controller;

use Knp\Component\Pager\Pagination\PaginationInterface;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     title="Pagination",
 *     description="Пагинация",
 *     @OA\Property(property="count", type="integer", description="Количество элементов в ответе"),
 *     @OA\Property(property="total", type="integer", description="Всего элементов"),
 *     @OA\Property(property="per_page", type="integer", description="Количество элементов на странице"),
 *     @OA\Property(property="page", type="integer", description="Текущая страница"),
 *     @OA\Property(property="pages", type="integer", description="Всего страниц")
 * )
 */
class PaginationSerializer
{
    public static function serialize(PaginationInterface $pagination): array
    {
        return [
            'count' => $pagination->count(),
            'total' => $pagination->getTotalItemCount(),
            'per_page' => $pagination->getItemNumberPerPage(),
            'page' => $pagination->getCurrentPageNumber(),
            'pages' => ceil($pagination->getTotalItemCount() / $pagination->getItemNumberPerPage()),
        ];
    }
}
