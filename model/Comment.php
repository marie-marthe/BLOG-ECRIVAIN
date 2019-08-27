<?php

namespace Vanessa\Projet3\Model;

use \Vanessa\Projet3\Framework\Model;

//require_once 'Framework/Model.php';

class Comment extends Model
{
    /**
     * Affiche tous les commentaires dans admin/comments
     * @return \PDOStatement
     */
    public function getAllComments()
    {
        $sql ='SELECT c.id, c.author, c.com_content, c.post_id, c.nb_report, DATE_FORMAT(c.date, \'%d/%m/%Y\') AS date_fr,
        p.id AS post_id, p.title AS post_title
        FROM comment AS c
        LEFT JOIN post AS p ON p.id = c.post_id
        ORDER BY c.nb_report DESC, c.id DESC ';
        $comments = $this->executeRequest($sql);
        return $comments;
    }

    /**
     * Afficher les commentaires d'un post post/post
     * @param $postId
     * @return \PDOStatement
     */
    public function getComments($postId)
    {
        $sql ='SELECT id, author, com_content, DATE_FORMAT(date, \'%d/%m/%Y\') AS date_fr FROM comment WHERE post_id = ?';
        $comments = $this->executeRequest($sql, array($postId));
        return $comments;
    }



    /**
     * Permet l'enregistrement d'un nv commentaire lors d'une saisie dans le formulaire présent dans Post.php
     * @param $author
     * @param $comcontent
     * @param $postId
     */
    public function postComment($com_postId, $author, $comcontent)
    {
        $sql = 'INSERT INTO comment(post_id, author, com_content, date)' . ' values(?, ?, ?, NOW())';
        $comment = $this->executeRequest($sql, array($com_postId, $author, $comcontent));
        return $comment;
    }


    /**
     * Méthode pour compter le nombre de commentaires
     * count permet de compter le nombre d'enregistrement dans la table.
     * @return mixed
     */
    public function getNumberComments()
    {
        $sql = 'SELECT count(*) as nbComments from comment';
        $result = $this->executeRequest($sql);
        $line = $result->fetch(); // Le résultat comporte toujours une ligne.
        return $line['nbComments'];
    }


    /**
     * Affiche le dernier commentaire dans le tableau de bord
     * en admin/index
     */
    public function lastComment()
    {
        $sql = 'SELECT id, author, com_content, DATE_FORMAT(date, \'%d/%m/%Y\') AS date_fr FROM comment ORDER BY date DESC LIMIT 0,1';
        $comments = $this->executeRequest($sql);
        return $comments;
    }


    /**
     * Méthode pour afficher un commentaire
     * dans post/moderation
     * dans admin/comment
     */
    public function getComment($id)
    {
        $sql = 'SELECT c.id, c.author, c.com_content, c.post_id, c.nb_report, DATE_FORMAT(c.date, \'%d/%m/%Y\') AS date_fr,
        p.id AS post_id, p.title AS post_title
        FROM comment AS c
        LEFT JOIN post AS p ON c.post_id = p.id
        WHERE c.id = ?';
        $comment = $this->executeRequest($sql, array($id));

        if($comment->rowCount() > 0) // RowCount retourne le nombre de lignes affectées par le dernier appel à la fonction PDOStatement
        {
            return $comment->fetch(); // Accès à la 1e ligne de résultat
        }

        else
        {
            throw new \Exception('Aucun commentaire ne correspond à l\'identifiant suivant : ' .$id . '.<br/>');
        }
    }


    /**
     * Méthode pour enregistrer le signalement d'un commentaire dans la BDD.
     * dans post/moderation
     */
    public function signal($id)
    {
        $sql = 'UPDATE comment SET nb_report = nb_report + 1 WHERE id = ?';
        $comment = $this->executeRequest($sql, array($id));
        return $comment;
    }


    /**
     * Méthode pour remettre nb_report à 0, ce qui permet de valider le commentaire
     * (après signalement) via la méthode confirmComment dans le controllerAdmin.
     */
    public function validate($id)
    {
        $sql = 'UPDATE comment SET nb_report = 0 WHERE id = ?';
        $comment = $this->executeRequest($sql, array($id));
        return $comment;
    }


    /**
     * Méthode pour supprimer le commentaire de la BDD
     * (après signalement)
     */
    public function delete($id)
    {
        $sql = 'DELETE FROM comment WHERE id = ?';
        $comment = $this->executeRequest($sql, array($id));
        return $comment;
    }
}


