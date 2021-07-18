<?php

declare(strict_types=1);

namespace App\Controller;

use Knp\Component\Pager\Pagination\PaginationInterface;

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