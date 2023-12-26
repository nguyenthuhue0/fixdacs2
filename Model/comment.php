<?php

class Comment
{
    private $db;
    private $commentId;
    private $userId;
    private $articleId;
    private $commentText;
    private $dateCommented;

    private $parentComId;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    // Getter and setter methods for commentId, userId, articleId, commentText, and dateCommented

    public function getCommentId()
    {
        return $this->commentId;
    }

    public function setCommentId($commentId)
    {
        $this->commentId = $commentId;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    public function getArticleId()
    {
        return $this->articleId;
    }

    public function setArticleId($articleId)
    {
        $this->articleId = $articleId;
    }

    public function getCommentText()
    {
        return $this->commentText;
    }

    public function setCommentText($commentText)
    {
        $this->commentText = $commentText;
    }

    public function getDateCommented()
    {
        return $this->dateCommented;
    }

    public function setDateCommented($dateCommented)
    {
        $this->dateCommented = $dateCommented;
    }
    public function setParentComId($parentComId)
    {
        $this->parentComId = $parentComId;
    }

    public function saveToDatabase()
    {
        try {
            $stmt = $this->db->prepare(
                "INSERT INTO comment (articleId, userId, commentText, dateCommented, parentComId) 
                 VALUES (:articleId, :userId, :commentText, :dateCommented, :parentComId)"
            );

            $stmt->bindParam(':articleId', $this->articleId);
            $stmt->bindParam(':userId', $this->userId);
            $stmt->bindParam(':commentText', $this->commentText);
            $stmt->bindParam(':dateCommented', $this->dateCommented);
            $stmt->bindParam(':parentComId', $this->parentComId);

            $stmt->execute();
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
        }
    }
    public function updateInDatabase()
    {
        try {
            $stmt = $this->db->prepare(
                "UPDATE comment 
                SET commentText = :commentText
                WHERE commentId = :commentId"
            );

            $stmt->bindParam(':commentText', $this->commentText);
            $stmt->bindParam(':commentId', $this->commentId);

            $stmt->execute();
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
        }
    }
    public function loadCommentsByArticleId($articleId)
    {
        try {
            $sql = "SELECT * FROM comment WHERE articleId = :articleID ORDER BY dateCommented DESC";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':articleID', $articleId);
            $stmt->execute();
            $rowCount = $stmt->rowCount();

            $comments = [];

            if ($rowCount > 0) {
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $comment = new Comment($this->db);
                    $comment->setCommentId($row['commentId']);
                    $comment->setUserId($row['userId']);
                    $comment->setArticleId($row['articleId']);
                    $comment->setCommentText($row['commentText']);
                    $comment->setDateCommented($row['dateCommented']);

                    $comments[] = $comment;
                }
            }

            return $comments;
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
        }
    }
    public function deleteComment($id) {
        try {
            $sql = "DELETE FROM comment WHERE commentId = :commentId";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':commentId', $id);
            $stmt->execute();
    
            $rowCount = $stmt->rowCount();
    
            return $rowCount > 0;
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
        }
    }
}
?>