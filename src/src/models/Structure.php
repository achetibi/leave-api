<?php

namespace App\models;

use PDO;
use PDOException;
use App\core\BaseModel;

class Structure extends BaseModel
{
    /**
     * Attributes
     */
    public int $id;
    public string $name;
    public ?int $parent_id;
    public ?int $manager_id;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Structure
     */
    public function setName(string $name): Structure
    {
        $this->name = ucfirst($name);
        return $this;
    }

    /**
     * @return int|null
     */
    public function getParentId(): ?int
    {
        return $this->parent_id;
    }

    /**
     * @param int|null $parent_id
     * @return Structure
     */
    public function setParentId(?int $parent_id): Structure
    {
        $this->parent_id = $parent_id;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getManagerId(): ?int
    {
        return $this->manager_id;
    }

    /**
     * @param int|null $manager_id
     * @return Structure
     */
    public function setManagerId(?int $manager_id): Structure
    {
        $this->manager_id = $manager_id;
        return $this;
    }

    /**
     * Get all structures
     *
     * @return array
     */
    public static function all(): array
    {
        $query = "
            SELECT
                structures.id,
                structures.name,
                
                IF(structures.parent_id, JSON_OBJECT(
                    'id', parent.id,
                    'name', parent.name
                ), NULL) AS parent,
                
                IF(structures.manager_id, JSON_OBJECT(
                    'id', manager.id,
                    'email', manager.email,
                    'first_name', manager.first_name,
                    'last_name', manager.last_name,
                    'status', manager.status
                ), NULL) AS manager
            FROM
                structures
            LEFT JOIN structures AS parent ON structures.parent_id = parent.id
            LEFT JOIN users AS manager ON structures.manager_id = manager.id
        ";

        try {
            $statement = self::db()->query($query);

            return $statement->fetchAll(PDO::FETCH_CLASS, static::class) ?: [];
        } catch (\PDOException $e) {
            return [];
        }
    }

    /**
     * Find structure by ID
     *
     * @param int $id
     * @return Structure|null
     */
    public static function find(int $id): ?Structure
    {
        $query = "
            SELECT
                structures.id,
                structures.name,

                IF(structures.parent_id, JSON_OBJECT(
                    'id', parent.id,
                    'name', parent.name
                ), NULL ) AS parent,
                
                IF(structures.manager_id, JSON_OBJECT(
                    'id', manager.id,
                    'email', manager.email,
                    'first_name', manager.first_name,
                    'last_name', manager.last_name,
                    'status', manager.status
                ), NULL ) AS manager
            FROM
                structures
            LEFT JOIN
                    structures AS parent
                        ON structures.parent_id = parent.id
            LEFT JOIN
                    users AS manager
                        ON structures.manager_id = manager.id
            WHERE
                structures.id = :id
        ";

        try {
            $statement = self::db()->prepare($query);

            $statement->execute([
                'id' => $id
            ]);

            return $statement->fetchObject(static::class) ?: null;
        } catch (PDOException $e) {
            return null;
        }
    }

    /**
     * Create structure
     *
     * @return Structure|null
     */
    public function create(): ?Structure
    {
        $query = "
            INSERT INTO structures 
                (name, parent_id, manager_id)
            VALUES
                (:name, :parent_id, :manager_id)
        ";

        try {
            $statement = self::db()->prepare($query);

            $statement->execute([
                'name' => $this->name,
                'parent_id' => $this->parent_id ?? null,
                'manager_id' => $this->manager_id ?? null
            ]);

            return static::find(static::db()->lastInsertId());
        } catch (PDOException $e) {
            return null;
        }
    }

    /**
     * Update structure by ID
     *
     * @return Structure|null
     */
    public function update(): ?Structure
    {
        $query = "
            UPDATE structures
            SET
                name = :name,
                parent_id = :parent_id,
                manager_id = :manager_id
            WHERE
                id = :id
        ";

        try {
            $statement = self::db()->prepare($query);

            $statement->execute([
                'id' => $this->id,
                'name' => $this->name,
                'parent_id' => $this->parent_id,
                'manager_id' => $this->manager_id
            ]);

            return static::find($this->id);
        } catch (PDOException $e) {
            return null;
        }
    }

    /**
     * Delete structure by ID
     *
     * @return bool
     */
    public function delete(): bool
    {
        $query = "
            DELETE
            FROM
                structures
            WHERE
                id = :id
        ";

        try {
            $statement = self::db()->prepare($query);

            $statement->execute([
                'id' => $this->id
            ]);

            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Find users by structure ID
     *
     * @return array
     */
    public function employees(): array
    {
        $ROLE_EMPLOYEE = User::ROLE_EMPLOYEE;

        $query = "
            SELECT
                structures.id,
                structures.name,
                COUNT(u.id) as users_count,
                IF(COUNT(u.id), JSON_ARRAYAGG(JSON_OBJECT(
                    'id', u.id,
                    'email', u.email,
                    'first_name', u.first_name,
                    'last_name', u.last_name,
                    'status', u.status
                )), NULL ) AS users
            FROM
                structures
            LEFT JOIN
                    users AS u
                        ON u.structure_id = structures.id
            WHERE
                structures.id = :id AND u.role = $ROLE_EMPLOYEE

            GROUP BY
                structures.id
        ";

        try {
            $statement = self::db()->prepare($query);

            $statement->execute([
                'id' => $this->id
            ]);

            return $statement->fetchAll(PDO::FETCH_CLASS, static::class) ?: [];
        } catch (PDOException $e) {
            return [];
        }
    }

    public function leave()
    {

    }
}
