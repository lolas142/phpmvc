<?php
namespace Anax\User;

class CFormLogin extends \Mos\HTMLForm\CForm
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
        'username' => [
            'type'        => 'text',
            'label'       => 'Användarnamn',
            'required'    => true,
            'validation'  => ['not_empty'],
        ],
        'password' => [
            'type'        => 'password',
            'label'       => 'Lösenord',
            'required'    => true,
            'validation'  => ['not_empty'],
        ],
        'submit' => [
            'type'      => 'submit',
            'value'     => 'Logga in',
            'callback'  => function() {

                $res = $this->di->dispatcher->forward([
                    'controller' => 'user',
                    'action'     => 'login',
                    'params'     => [true ,$this->Value('username'), $this->Value('password')]
                ]);

                $this->saveInSession = true;
                return $res;
            }
        ],
    ]);

    }
}