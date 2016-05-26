<?php
namespace Anax\Questions;
 
/**
 * Model for Questions.
 *
 */
class Questions extends \Anax\MVC\CDatabaseModel
{

     /**
     * Setup table for questions.
     */
    public function setup()
    {
        $this->db->dropTableIfExists('questions')->execute();
 
        $this->db->createTable(
            'questions',
            [
                'id' => ['integer', 'primary key', 'not null', 'auto_increment'],
                'userId' => ['integer', 'not null'],
                'subject' => ['char(255)'],
                'text' => ['text'],
                'created' => ['datetime'],
                'updated' => ['datetime'],
                'deleted' => ['datetime'],
            ]
        )->execute();

     
        $now = gmdate('Y-m-d H:i:s');
     
        $this->create([
            'userId' => '1',
            'subject' => 'Är man en gamer om man spelar mobilspel?',
            'text' => 'Hej! Jag undrar om man räknas som en gamer om man spelar på mobiel. Jag spelar på min mobil runt 4-5h om dagen och det är mer än vad en del "gamers" gör.',
            'created' => $now
        ]);
     
        $this->create([
            'userId' => '2',
            'subject' => 'Har problem med Skyrim om min skärm.',
            'text' => 'Hejsan allihopa. Jag har problem med skyrim och när jag googlar så hittar jag att det ska bero på min skärm. Är det någon annan som har detta problemet och i så fall har ni lyckats lösa det? ',
            'created' => $now
        ]);

    }


    public function getQuestionsForUser($id) {
        $this->db->select()
        ->from($this->getSource())
        ->where("userId = ?");
        $this->db->execute([$id]);
        $this->db->setFetchModeClass(__CLASS__);
        return $this->db->fetchAll();
    }

    public function getLatestQuestions($limit) {
        $this->db->select()
        ->from($this->getSource())
        ->orderby('created DESC')
        ->limit($limit);
        $this->db->execute();
        $this->db->setFetchModeClass(__CLASS__);
        return $this->db->fetchAll();
    }
}