<?php
namespace Anax\Answers;
 
/**
 * Model for Answers.
 *
 */
class Answers extends \Anax\MVC\CDatabaseModel
{

     /**
     * Setup table for answrs.
     */
    public function setup()
    {
        $this->db->dropTableIfExists('answers')->execute();
 
        $this->db->createTable(
            'answers',
            [
                'id' => ['integer', 'primary key', 'not null', 'auto_increment'],
                'userId' => ['integer', 'not null'],
                'questionId' => ['integer', 'not null'],
                'text' => ['text'],
                'created' => ['datetime'],
                'updated' => ['datetime'],
                'deleted' => ['datetime'],
            ]
        )->execute();

     
        $now = gmdate('Y-m-d H:i:s');
     
        $this->create([
            'userId' => '2',
            'questionId' => '1',
            'text' => 'Jag skulle inte säga att du är en "gamer" men det är vad jag tycker. Jag förstår vad du menar om att du spelar mycket men jag anser att man bör spela på mer än bara sin mobil.',
            'created' => $now
        ]);

        $this->create([
            'userId' => '3',
            'questionId' => '1',
            'text' => 'Jag tycker faktiskt att du är en gamer. Det spelar ingen roll om du spelar på mobilen, på consol eller dator. Spel som spel!',
            'created' => $now
        ]);
     
        $this->create([
            'userId' => '1',
            'questionId' => '2',
            'text' => 'Jag har samma problem. Jag har låst min skärm till 60hz och det funkar för tillfället. Testa att googla ditt grafikkort och hur man tvingar det till lägre hz.',
            'created' => $now
        ]);

    }

    public function getAnswersforQuestion($id) {
           $this->db->select()
             ->from($this->getSource())
             ->where("questionId = ?");
            $this->db->execute([$id]);
            $this->db->setFetchModeClass(__CLASS__);
            return $this->db->fetchAll();
    }


    public function getAnswersForUser($id) {
        $this->db->select()
        ->from($this->getSource())
        ->where("userId = ?");
        $this->db->execute([$id]);
        $this->db->setFetchModeClass(__CLASS__);
        return $this->db->fetchAll();
    }
}