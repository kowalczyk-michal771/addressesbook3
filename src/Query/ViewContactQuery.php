<?php

namespace Src\Query;

use Src\Infrastructure\SQLiteContactRepository;

class ViewContactQuery
{
    /**
     * @var SQLiteContactRepository
     */
    private SQLiteContactRepository $repository;

    /**
     * ViewContactQuery constructor.
     * @param SQLiteContactRepository $repository
     */
    public function __construct(SQLiteContactRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Gets contacts from database
     * @param array $filters
     * @return array
     */
    public function execute(array $filters = []): array
    {
        return $this->repository->getAllContacts($filters);
    }
}