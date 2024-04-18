<?php

namespace Src\Infrastructure;

use Src\Entity\Contact;
use PDO;

class SQLiteContactRepository
{
    /**
     * @var PDO
     */
    private PDO $connection;

    /**
     * Allowed filters keys
     * @var array|string[]
     */
    private array $allowedFilters = ['name', 'surname', 'telephone', 'email'];

    /**
     * SQLiteContactRepository constructor.
     * @param PDO $connection
     */
    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Adds contact do database
     * @param Contact $contact
     */
    public function addContact(Contact $contact): void
    {
        $stmt = $this->connection->prepare(
            'INSERT INTO contacts (name, surname, telephone, email, address) VALUES (?, ?, ?, ?, ?)'
        );

        $stmt->execute([
            $contact->getName(),
            $contact->getSurname(),
            $contact->getTelephone(),
            $contact->getEmail(),
            $contact->getAddress()
        ]);
    }

    /**
     * Retrieves all contact from database
     * + filtering if needed
     * @param array $filters
     * @return array
     */
    public function getAllContacts(array $filters = []): array
    {
        $query = 'SELECT * FROM contacts';

        $conditions = [];
        $params = [];

        foreach ($filters as $key => $value) {
            if (!in_array($key, $this->allowedFilters)) {
                continue;
            }

            $conditions[] = "$key LIKE ?";
            $params[] = '%' . $value . '%';
        }

        if (!empty($conditions)) {
            $query .= ' WHERE ' . implode(' AND ', $conditions);
        }

        $stmt = $this->connection->prepare($query);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, Contact::class);
    }

    /**
     * Checks if contact exist
     * @param int $id
     * @return bool
     */
    public function existsContact(int $id): bool
    {
        $stmt = $this->connection->prepare("SELECT COUNT(*) FROM contacts WHERE id = ?");
        $stmt->execute([$id]);

        return $stmt->fetchColumn() > 0;
    }

    /**
     * Removes contact from database
     * @param int $id
     */
    public function deleteContact(int $id): void
    {
        $stmt = $this->connection->prepare('DELETE FROM contacts WHERE id = ?');
        $stmt->execute([$id]);
    }
}