<?php
namespace Anax\Questions;

class CQuestionsForm extends \Mos\HTMLForm\CForm
{
    use \Anax\DI\TInjectionaware,
        \Anax\MVC\TRedirectHelpers;
    /**
     * Constructor
     *
     */
    public function __construct($tags = array())
    {   
        if(isset($tags[0])) {
            foreach ($tags as $tag) {
                $tagoptions[$tag->id] = $tag->name; 
            }
            
        parent::__construct([], [
        'subject' => [
            'type'        => 'text',
            'label'       => 'Rubrik',
            'required'    => true,
            'validation'  => ['not_empty'],
        ],
        'text' => [
            'type'        => 'textarea',
            'label'       => 'Fråga',
            'required'    => true,
            'validation'  => ['not_empty'],
        ],
        'old_tags' => [
            'type'        => 'select-multiple',
            'options'     => $tagoptions,
            'label'       => 'Befintliga taggar',
        ],
        'new_tags' => [
            'type'        => 'text',
            'label'       => 'Skapa nya taggar, separera med komma-tecken',
        ],
        'submit' => [
            'type'      => 'submit',
            'callback'  => function() {
                $old_tags = null;
                if(isset($_POST['old_tags'])) {
                    $old_tags = $_POST['old_tags'];
                }

                $res = $this->di->dispatcher->forward([
                    'controller' => 'questions',
                    'action'     => 'add',
                    'params'     => [$this->Value('subject'), $this->Value('text'), $old_tags, $this->Value('new_tags')]
                ]);

                $this->saveInSession = true;
                return $res;
            }
        ],
    ]);
    }
    
    else {
                parent::__construct([], [
        'subject' => [
            'type'        => 'text',
            'label'       => 'Rubrik',
            'required'    => true,
            'validation'  => ['not_empty'],
        ],
        'text' => [
            'type'        => 'textarea',
            'label'       => 'Fråga',
            'required'    => true,
            'validation'  => ['not_empty'],
        ],
        'tags_new' => [
            'type'        => 'text',
            'label'       => 'Skapa nya taggar, separera med komma-tecken',
        ],
        'submit' => [
            'type'      => 'submit',
            'callback'  => function() {

                $res = $this->di->dispatcher->forward([
                    'controller' => 'questions',
                    'action'     => 'add',
                    'params'     => [$this->Value('subject'), $this->Value('text')]
                ]);

                $this->saveInSession = true;
                return $res;
            }
        ],
        'submit-fail' => [
            'type'      => 'submit',
            'callback'  => function() {
                $this->AddOutput("<p><i>DoSubmitFail(): Form was submitted but I failed to process/save/validate it</i></p>");
                return false;
            }
        ],
    ]);

    }

    }


}