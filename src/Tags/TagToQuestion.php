<?php
namespace Anax\Tags;
 
/**
 * Model for Users.
 *
 */
class TagToQuestion extends \Anax\MVC\CDatabaseModel
{

    public function dropTable()
    {
        $this->db->dropTableIfExists('tagtoquestion')->execute();
    }

     /**
     * Setup table for tags to questions.
     *
     * @return boolean true or false if saving went okey.
     */
    public function setup()
    {
        $this->db->dropTableIfExists('tagtoquestion')->execute();
        $this->db->createTable(
            'tagtoquestion',
            [
                'idTags' => ['integer', 'not null'],
                'idQuestions' => ['integer', 'not null'],
            ]
        )->execute();

        $this->create([
            'idQuestions' => '1',
            'idTags' => '1',
        ]);
        $this->create([
            'idQuestions' => '2',
            'idTags' => '1',
        ]);
        $this->create([
            'idQuestions' => '2',
            'idTags' => '2',
        ]);
    }


    public function getQuestionsByTag($tagId) {
        
        $this->db->select("idQuestions")
        ->from('tagtoquestion')
        ->where("idTags = ?");
        $this->db->execute([$tagId]);
        $this->db->setFetchMode(\PDO::FETCH_NUM);
        $res = $this->db->fetchAll();
        return $res;
    }

    public function getTagsByQuestion($qId) {
        
        $this->db->select("idTags")
        ->from('tagtoquestion')
        ->where("idQuestions = ?");
        $this->db->execute([$qId]);
        $this->db->setFetchMode(\PDO::FETCH_NUM);
        $res = $this->db->fetchAll();
        return $res;
    }
}