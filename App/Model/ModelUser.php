<?php

namespace App\Model;

class ModelUser
{
    private $id;
    private $name;
    private $password;
    private $passwordHash;

    public function save()
    {
        $db = \Core\Context::i()->getDb();
        $insert = $db->exec(
            "INSERT INTO news (title, content) VALUES (:title, content)",
            __METHOD__,
            ['title' => 'Привет, MVC', 'content' => $this->passwordHash]
        );
        if (!$insert){
            return true;
        }
        $id = $db->lastUnsertId();
        $this->id = $id;
    }

    public function getIdDb()
    {
        $db = \Core\Context::i()->getDb();
        $data = $db->fetchAll('SELECT * FROM news', __METHOD__);
        if ($data) {
            $this->loadData($data);
            return true;
        }

        return false;
    }

    public function loadData(array $data)
    {
        if ($data) {
            if (isset($data['id'])) {
                $this->id = $data['id'];
            }
            $this->name = $data['title'];
            $this->passwordHash = $data['content'];
        }
    }

    public static function getListMethod(array $ids)
    {
        $db = \Core\Context::i()->getDb();
        foreach ($ids as $id){
            $id = (int)$id;
        }
        $idsStr = implode(',', $ids);
        $data = $db->fetchAll("SELECT * FROM news WHERE `id` IN($idsStr)",
            __METHOD__);
        if (!$data) {
            return [];
        }
        $res = [];
        foreach ($data as $item) {
            $model = new self();
            $model->loadData($item);
            $res[] = $model;
        }

        return $res;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password): void
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getPasswordHash()
    {
        return $this->passwordHash;
    }

    /**
     * @param mixed $passwordHash
     */
    public function setPasswordHash($passwordHash): void
    {
        $this->passwordHash = $passwordHash;
    }

    public static function genPasswordHash(string $password)
    {
        return sha1($password . 'fjuj.,322La.,d');
    }

}