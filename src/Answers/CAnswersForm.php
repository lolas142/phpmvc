<?php
namespace Anax\Answers;

class CAnswersForm extends \Mos\HTMLForm\CForm
{
    use \Anax\DI\TInjectionaware,
        \Anax\MVC\TRedirectHelpers;
    /**
     * Constructor
     *
     */
    public function __construct()
    {   
       
            
        parent::__construct([], [
        'text' => [
            'type'        => 'textarea',
            'label'       => 'Ditt svar',
            'required'    => true,
            'validation'  => ['not_empty'],
        ],
        'submit' => [
            'type'      => 'submit',
            'callback'  => function() {
                $res = $this->di->dispatcher->forward([
                    'controller' => 'answers',
                    'action'     => 'add',
                    'params'     => [$this->Value('text')]
                ]);

                $this->saveInSession = true;
                return $res;
            }
        ],
    ]);
    
    }


}