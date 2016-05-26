<?php
namespace Anax\User;

class CFormRegister extends \Mos\HTMLForm\CForm
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
        'pwd-repeat' => [
            'type'        => 'password',
            'label'       => 'Repetera lösenord',
            'required'    => true,
             'validation' => [
                'match' => 'password'
            ],
        ],
        'email' => [
            'type'        => 'text',
            'required'    => true,
            'validation'  => ['not_empty', 'email_adress'],
        ],
        'submit' => [
            'type'      => 'submit',
            'value'     => 'Registrera dig',
            'callback'  => function() {

                $res = $this->di->dispatcher->forward([
                    'controller' => 'user',
                    'action'     => 'add',
                    'params'     => [$this->Value('username'), $this->Value('password'), $this->Value('email')]
                ]);

                $this->saveInSession = true;
                return $res;
            }
        ],
    ]);

    }

    public function getUsername() {
        return $this->Value('username');
    }
}