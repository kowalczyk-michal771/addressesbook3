<?php

namespace Src\Command;

use Src\Infrastructure\SQLiteContactRepository;

class DeleteContactCommand
{
    /**
     * @var SQLiteContactRepository
     */
    private SQLiteContactRepository $repository;

    /**
     * DeleteContactCommand constructor.
     * @param SQLiteContactRepository $repository
     */
    public function __construct(SQLiteContactRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Removes contact from database
     * @param int $id
     */
    public function execute(int $id): void
    {
        $this->repository->deleteContact($id);
    }
}