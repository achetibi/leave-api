<?php

namespace App\models;

use PDO;
use PDOException;
use App\core\BaseModel;

class User extends BaseModel
{
    // Roles
    public const ROLE_EMPLOYEE     = 1;
    public const ROLE_MANAGER      = 2;

    // Statues
    public const STATUS_ACTIVE     = 1;
    public const STATUS_INACTIVE   = 2;

    /**
     * Attributes
     */
    public int $id;
    public string $email;
    private string $password;
    public string $first_name;
    public string $last_name;
    public int $role;
    public int $status;
    public int $structure_id;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return $this
     */
    public function setId(int $id): User
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return User
     */
    public function setEmail(string $email): User
    {
        $this->email = mb_strtolower($email);
        return $this;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return User
     */
    public function setPassword(string $password): User
    {
        $this->password = password_hash($password, PASSWORD_BCRYPT);
        return $this;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->first_name;
    }

    /**
     * @param string $first_name
     * @return User
     */
    public function setFirstName(string $first_name): User
    {
        $this->first_name = ucfirst($first_name);
        return $this;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->last_name;
    }

    /**
     * @param string $last_name
     * @return User
     */
    public function setLastName(string $last_name): User
    {
        $this->last_name = mb_strtoupper($last_name);
        return $this;
    }

    /**
     * @return int
     */
    public function getRole(): int
    {
        return $this->role;
    }

    /**
     * @param int $role
     * @return User
     */
    public function setRole(int $role): User
    {
        $this->role = $role;
        return $this;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @param int $status
     * @return User
     */
    public function setStatus(int $status): User
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return int
     */
    public function getStructureId(): int
    {
        return $this->structure_id;
    }

    /**
     * @param int $structure_id
     * @return User
     */
    public function setStructureId(int $structure_id): User
    {
        $this->structure_id = $structure_id;
        return $this;
    }

    /**
     * Get all users
     *
     * @return array
     */
    public static function all() : array
    {
        $query = "
            SELECT 
                id, email, first_name, last_name, role, status, structure_id
            FROM
                users
        ";

        try {
            $statement = static::db()->query($query);

            return $statement->fetchAll(PDO::FETCH_CLASS, static::class) ?: [];
        } catch (PDOException $e) {
            return [];
        }
    }

    /**
     * Find user by ID
     *
     * @param int $id
     * @return User|null
     */
    public static function find(int $id): ?User
    {
        $query = "
            SELECT 
                id, email, first_name, last_name, role, status, structure_id
            FROM
                users
            WHERE
                id = :id
        ";

        try {
            $statement = static::db()->prepare($query);

            $statement->execute([
                'id' => $id
            ]);

            return $statement->fetchObject(static::class) ?: null;
        } catch (PDOException $e) {
            return null;
        }
    }

    /**
     * Find user by Email
     *
     * @param string $email
     * @return User|null
     */
    public static function findByEmail(string $email): ?User
    {
        $query = "
            SELECT 
                id, email, first_name, last_name, role, status, structure_id, password
            FROM
                users
            WHERE
                email = :email
        ";

        try {
            $statement = static::db()->prepare($query);

            $statement->execute([
                'email' => $email
            ]);

            return $statement->fetchObject(static::class) ?: null;
        } catch (PDOException $e) {
            return null;
        }
    }

    /**
     * Create user
     *
     * @return User|null
     */
    public function create(): ?User
    {
        $query = "
            INSERT INTO users 
                (email, password, first_name, last_name, role, status, structure_id)
            VALUES
                (:email, :password, :first_name, :last_name, :role, :status, :structure_id)
        ";

        try {
            $statement = static::db()->prepare($query);

            $statement->execute([
                'email' => $this->email,
                'password' => $this->password,
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'role' => $this->role,
                'status' => $this->status,
                'structure_id' => $this->structure_id
            ]);

            return static::find(static::db()->lastInsertId());
        } catch (PDOException $e) {
            return null;
        }
    }

    /**
     * Update user by ID
     *
     * @return User|null
     */
    public function update(): ?User
    {
        $query = "
            UPDATE users
            SET 
                email = :email,
                first_name = :first_name,
                last_name = :last_name,
                role  = :role,
                status = :status,
                structure_id = :structure_id
            WHERE
                id = :id AND role = :role
        ";

        try {
            $statement = static::db()->prepare($query);

            $statement->execute([
                'id' => $this->id,
                'email' => $this->email,
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'role' => $this->role,
                'status' => $this->status,
                'structure_id' => $this->structure_id
            ]);

            return static::find($this->id);
        } catch (PDOException $e) {
            return null;
        }
    }

    /**
     * Delete user by ID
     *
     * @return bool
     */
    public function delete(): bool
    {
        $query = "
            DELETE
            FROM
                users
            WHERE
                id = :id AND role = :role
        ";

        try {
            $statement = static::db()->prepare($query);

            $statement->execute([
                'id' => $this->getId(),
                'role' => $this->getRole()
            ]);

            return true;
        } catch (PDOException $e) {
            return false;
        }
    }
}
