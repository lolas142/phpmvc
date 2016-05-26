<?php
namespace Anax\Comments;
 
/**
 * Model for Comments.
 *
 */
class Comments extends \Anax\MVC\CDatabaseModel
{

     /**
     * Setup table for comments.
     */
    public function setup()
    {
        $this->db->dropTableIfExists('comments')->execute();
 
        $this->db->createTable(
            'comments',
            [
                'id' => ['integer', 'primary key', 'not null', 'auto_increment'],
                'userId' => ['integer', 'not null'],
                'questionId' => ['integer'],
                'answerId' => ['integer'],
                'text' => ['text'],
                'created' => ['datetime'],
                'updated' => ['datetime'],
                'deleted' => ['datetime'],
            ]
        )->execute();

     
        $now = gmdate('Y-m-d H:i:s');
     
        $this->create([
            'userId' => '1',
            'questionId' => '1',
            'text' => 'Vet inte om jag skulle klassa dig som gamer men du spelar spel.',
            'created' => $now
        ]);
     
        $this->create([
            'userId' => '3',
            'questionId' => '2',
            'text' => 'Har också problem. ',
            'created' => $now
        ]);

        $this->create([
            'userId' => '2',
            'questionId' => '2',
            'text' => 'Tack, detta hjälpte!',
            'created' => $now
        ]);

        $this->create([
            'userId' => '1',
            'answerId' => '1',
            'text' => 'Jag vet inte längre var jag skriver dessa testfrågor....',
            'created' => $now
        ]);
    }

    public function getCommentsForAnswer($id) {
           $this->db->select()
             ->from($this->getSource())
             ->where("answerId = ?");
            $this->db->execute([$id]);
            $this->db->setFetchModeClass(__CLASS__);
            return $this->db->fetchAll();
    }

    public function getCommentsForQuestion($id) {
           $this->db->select()
             ->from($this->getSource())
             ->where("questionId = ?");
            $this->db->execute([$id]);
            $this->db->setFetchModeClass(__CLASS__);
            return $this->db->fetchAll();
    }
}