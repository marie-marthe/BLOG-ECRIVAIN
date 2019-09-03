<?php

namespace model;

use Model;

//require_once 'Model.php';

class Post extends Model
{

    /**
     * Pour afficher le dernier chapitre en home
     * vue home/index
     * @return \PDOStatement
     */
    public function lastPost()
    {

        $req = $bdd->query('SELECT id, titre, contenu, DATE_FORMAT(date_creation, \'%d/%m/%Y à %Hh%imin%ss\') AS date_creation_fr FROM billets ORDER BY date_creation DESC LIMIT 0, 2');
        $posts = $this->executeRequest($req);
        return $posts;
    }


    /**
     * Pour afficher tous les posts
     * @return PDOStatement
     */
    public function getPosts()
    {
        $req = $bdd->query('SELECT id, titre, contenu, DATE_FORMAT(date_creation, \'%d/%m/%Y à %Hh%imin%ss\') AS date_creation_fr, titre(c.id) as nbcontenu FROM billets as p 
        LEFT JOIN contenu as c ON p.id = c.titre GROUP BY p.id ORDER BY p.date_creation';
        $posts = $this->executeRequest($req);
        return $posts;
    }

    /**
     * Pour afficher le contenu d'un post
     * @param $postId
     * @return mixed
     * @throws Exception
     */
    public function getPost($postId)
    {
        $req = $bdd->prepare('SELECT id, titre, contenu, DATE_FORMAT(date_creation, \'%d/%m/%Y à %Hh%imin%ss\') AS date_creation_fr FROM billets WHERE id = ?');;
        $post = $this->executeRequest($req, array($postId));

        if($post->rowCount() > 0) // RowCount retourne le nombre de lignes affectées par le dernier appel à la fonction PDOStatement
        {
            return $post->fetch(); // Accès à la 1e ligne de résultat
        }

        else
        {
            throw new \Exception('Aucun billet ne correspond à l\'identifiant suivant : ' .$postId . '.<br/>');
        }
    }


    /**
     * Méthode pour compter le nombre de posts publiés.
     * count permet de compter le nombre d'enregistrement dans la table.
     * @return mixed
     */
    Public function getNumberPosts()
    {
        $req = 'SELECT count(*) as nbcontenu from billets';
        $result = $this->executeRequest($req);
        $line = $result->fetch(); // Le résultat comporte toujours une ligne
        return $line['nbPosts'];
    }


    /**
     * Méthode ajouter un post
     */
    public function addPost($title, $content)
    {
        $req = 'INSERT INTO post(title, contenu, date_creation)' . ' values(?,?, NOW())';
        $post = $this->executeRequest($req, array($title, $content));
        return $post;
    }


    /**
     * Méthode mettre à jour un post
     */
    public function updatePost($title, $content, $id)
    {
        $req = 'UPDATE billets SET title = ? , contenu = ? WHERE id = ?';
        $post = $this->executeRequest($req, array($title, $content, $id));
        return $post;
    }


    /**
     * Méthode supprimer un post
     */
    public function deletePost($id)
    {
        $req = 'DELETE FROM billets WHERE id = ?';
        $post = $this->executeRequest($req, array($id));
        return $post;
    }

}
