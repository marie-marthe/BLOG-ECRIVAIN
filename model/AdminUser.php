<?php

namespace model;

use Model;

//require_once "Model.php";

/**
 * Les méthodes de la classe User permettent de vérifier si un utilisateur existe
 * et de gérer ses propriétés (id, email, password).
 */

class AdminUser extends Model
{
    /**
     * Vérifie que l'utilisateur existe dans la BDD
     * $param $email
     * $param $password
     * return boolean vrai si l'utilisateur existe
     */
    public function connect($email, $password)
    {
        $req = 'SELECT id FROM adminUser WHERE email=? AND password=?';
        $user = $this->executeRequest($req, array($email, $password));
        return ($user->rowCount() == 1);
    }

    /**
     * Renvoie un utilisateur existant dans la BDD
     *
     */
    public function getUser($email)
    {
        $req = 'SELECT id as adminUser, email, password FROM adminUser WHERE login=? ';
        $user = $this->executeRequest($req, array($email));
        if ($user->rowCount() == 1)
        {
            return $user->fetch(); // Accès à la première ligne de résultat
        }
        else
        {
            throw new \Exception("Aucun utilisateur ne correspond aux identifiants fournis.");
        }
    }


    public function newPassword($newpassword, $id)
    {
        $newpassword = password_hash($newpassword, $id);
        $req = 'UPDATE adminUser SET password = ? WHERE id = ?';
        $user = $this->executeRequest($req, array($newpassword, $id));
        return $user;
    }
}
