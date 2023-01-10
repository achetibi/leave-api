<?php

namespace App\models;

use App\core\BaseModel;
use PDO;
use PDOException;

class Request extends BaseModel
{
    // Statues
    public const STATUS_PENDING = 1;
    public const STATUS_ACCEPTED = 2;
    public const STATUS_REFUSED = 3;

    // Attributes
    public int $id;
    public string $title;
    public string $date_start;
    public string $date_end;
    public ?string $comment;
    public int $status;
    public int $user_id;

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
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return Request
     */
    public function setTitle(string $title): Request
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getDateStart(): string
    {
        return $this->date_start;
    }

    /**
     * @param string $date_start
     * @return Request
     */
    public function setDateStart(string $date_start): Request
    {
        $this->date_start = $date_start;
        return $this;
    }

    /**
     * @return string
     */
    public function getDateEnd(): string
    {
        return $this->date_end;
    }

    /**
     * @param string $date_end
     * @return Request
     */
    public function setDateEnd(string $date_end): Request
    {
        $this->date_end = $date_end;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getComment(): ?string
    {
        return $this->comment;
    }

    /**
     * @param string|null $comment
     * @return Request
     */
    public function setComment(?string $comment): Request
    {
        $this->comment = $comment;
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
     * @return Request
     */
    public function setStatus(int $status): Request
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->user_id;
    }

    /**
     * @param int $user_id
     * @return Request
     */
    public function setUserId(int $user_id): Request
    {
        $this->user_id = $user_id;
        return $this;
    }

    /**
     * Get all authenticated requests
     *
     * @return array
     */
    public static function all()
    {
        $query = "
            SELECT 
                id, title, date_start, date_end, status, comment
            FROM
                requests
            WHERE
                user_id = :user_id
        ";

        try {
            if (user()->getRole() === User::ROLE_MANAGER) {
                $query = "
                    SELECT
                        requests.id, requests.title, requests.date_start, requests.date_end, requests.status, requests.comment
                    FROM requests
                        LEFT JOIN users ON users.id = requests.user_id
                        LEFT JOIN structures ON structures.id = users.structure_id
                    WHERE 
                        structures.manager_id = :user_id
                
                ";
            }

            $statement = static::db()->prepare($query);

            $statement->execute([
                'user_id' => user()->getId()
            ]);

            return $statement->fetchAll(PDO::FETCH_CLASS, static::class) ?: [];
        } catch (PDOException | \ReflectionException $e) {
            if (getenv('APP_ENV') === 'dev') {
                exit($e->getMessage());
            }

            return [];
        }
    }

    public static function find($id)
    {
        $query = "
            SELECT 
                id, title, date_start, date_end, status, comment, user_id
            FROM
                requests
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
            if (getenv('APP_ENV') === 'dev') {
                exit($e->getMessage());
            }

            return null;
        }
    }

    public function create()
    {
        $query = "
            INSERT INTO requests 
                (title, date_start, date_end, status, user_id)
            VALUES
                (:title, :date_start, :date_end, :status, :user_id)
        ";

        try {
            $statement = static::db()->prepare($query);

            $statement->execute([
                'title' => $this->title,
                'date_start' => $this->date_start,
                'date_end' => $this->date_end,
                'status' => $this->status,
                'user_id' => $this->user_id
            ]);

            return static::find(static::db()->lastInsertId());
        } catch (PDOException $e) {
            if (getenv('APP_ENV') === 'dev') {
                exit($e->getMessage());
            }

            return null;
        }
    }

    public function update()
    {
        $query = "
            UPDATE requests
            SET 
                status = :status,
                comment = :comment
            WHERE
                id = :id
        ";

        try {
            $statement = static::db()->prepare($query);

            $statement->execute([
                'id' => $this->id,
                'status' => $this->status,
                'comment' => $this->comment
            ]);

            return static::find($this->id);
        } catch (PDOException $e) {
            if (getenv('APP_ENV') === 'dev') {
                exit($e->getMessage());
            }

            return null;
        }
    }

    public function delete()
    {
        $query = "
            DELETE
            FROM
                requests
            WHERE
                id = :id
        ";

        try {
            $statement = static::db()->prepare($query);

            $statement->execute([
                'id' => $this->id,
            ]);

            return true;
        } catch (PDOException $e) {
            if (getenv('APP_ENV') === 'dev') {
                exit($e->getMessage());
            }

            return false;
        }
    }
}
