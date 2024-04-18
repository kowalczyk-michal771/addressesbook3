<?php

namespace Src\Command;

use Src\Infrastructure\SQLiteContactRepository;
use Src\Entity\Contact;

class AddContactCommand
{
    /**
     * @var SQLiteContactRepository
     */
    private SQLiteContactRepository $repository;

    /**
     * AddContactCommand constructor.
     * @param SQLiteContactRepository $repository
     */
    public function __construct(SQLiteContactRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param string $name
     * @param string $surname
     * @param string $telephone
     * @param string $email
     * @param string $address
     */
    public function execute(
        string $name,
        string $surname,
        string $telephone,
        string $email,
        string $address): void
    {
        $contact = new Contact(null, $name, $surname, $telephone, $email, $address);

        $this->repository->addContact($contact);
    }
}