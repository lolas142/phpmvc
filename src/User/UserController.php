<?php

namespace Anax\User;
 
/**
 * A controller for user and admin related events.
 *
 */
class UserController extends \Anax\MVC\CControllerBasic
{
    private $registerForm;
    private $loginForm;
    private $users;

    public function __construct() {
        $this->formRegister = new \Anax\User\CFormRegister();
        $this->formLogin = new \Anax\User\CFormLogin();
        
        $this->users = new \Anax\User\User();

    }

    public function setDI($di) {
        $this->di = $di;
        $this->formRegister->setDI($this->di);
        $this->formLogin->setDI($this->di);

        $this->users->setDI($this->di);
    }


    /**
    * Initialize the controller.
    *
    * @return void
    */
    public function initialize()
    {
        $this->users = new \Anax\User\User();
        $this->formLogin = new \Anax\User\CFormLogin();
        $this->formRegister = new \Anax\User\CFormRegister();
        
        $this->users->setDI($this->di);
        $this->formLogin->setDI($this->di);
        $this->formRegister->setDI($this->di);
    }

    public function loginAction($login=false, $username=null, $password=null)
    {
        if($login) {
            $res = $this->users->login($username, $password);
            return $res;
        }

        else {
            $status = $this->formLogin->check();

            if($status === true) {
                $this->callbackSuccess($this->formLogin);
            }
            elseif($status === false) {
                $this->callbackFailLogin($this->formLogin);
            }
             return $this->formLogin->getHTML();
        
        }   
    }

    public function logoutAction()
    {
        $this->users->logout();
        $this->redirectTo('login');
    }

    public function listAction()
    {
     
        $all = $this->users->findAll();
        $this->theme->setTitle("Visa alla användare");
        $this->theme->setVariable('pageheader', "<div class='pageheader'><h1>Alla användare</h1></div>");
        $this->views->add('user/list-all', [
            'users' => $all,
        ]);
    }

    public function getUserAction($id = null)
    {     
        if($id === null) {
            $user = $this->users->getOnlineUser();
        }
        elseif (is_numeric($id)) {
            $user = $this->users->find($id);
        }
        return $user;
    }

    public function checkIfLoggedIn()
    {     
        $res = $this->users->checkIfLoggedIn();

        return $res;
    }

    public function idAction($id)
    {     
        
        $edit = false;
        $loggedIn = $this->users->getOnlineUser();
        if ($loggedIn) {
           if($loggedIn->id === $id) {
                $edit = true;
            }
        }
        $user = $this->users->find($id);
        $questions = $this->QuestionsController->getQuestionsByUser($id);
        $answers = $this->AnswersController->getAnswersByUser($id);

        $this->theme->setTitle($user->username);
        $this->theme->setVariable('pageheader', "<div class='pageheader'><h1>" . $user->username . "</h1></div>");
        $this->views->add('user/list-one', [
            'user' => $user,
            'questions' => $questions,
            'discussions' => $answers,
            'edit'      => $edit
        ]);
    }

    public function editAction($id)
    {
        $user = $this->users->find($id);
        $this->formEdit = new \Anax\User\CFormEdit($user);
        $this->formEdit->setDI($this->di);
        $status = $this->formEdit->check();

        if($status === true) {
            $this->callbackSuccess($this->formEdit);
        }
        elseif($status === false) {
            $this->callbackFailRegister($this->formEdit);
        }

        $this->theme->setTitle( "Redigera profil för " . $user->username);
        $this->theme->setVariable('pageheader', "<div class='pageheader'><h1>Redigera profil för " . $user->username . "</h1></div>");
        if($this->users->checkIfLoggedIn()) {
            $this->theme->setVariable('main', $this->formEdit->getHTML());
        }
        else{
            $this->theme->setVariable('main', "
                    <h1>Redigera profil</h1>
                    <a href=" . $this->url->create('login') . ">Logga in för att kunna redigera din profil</a>");
        }


    }

    public function registerAction()
    {
        
        $status = $this->formRegister->check();

        if($status === true) {
            $this->callbackSuccess($this->formRegister);
        }
        elseif($status === false) {
            $this->callbackFailRegister($this->formRegister);
        }
         return $this->formRegister->getHTML();
    }

    public function addAction($username, $password, $email)
    {
        try {
            $res = $this->users->save([
            'username'  => $username,
            'email'    => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
        ]);
            if ($res == true) {
                $url = $this->url->create('user/list/');
                $this->form->AddOutput("<p>Du har blivit registrerad med framgång goch kan nu logga in</p>");
            }
        }
        catch (\Exception $e) {
            //$this->form->AddOutput("<p>Användaren kunde inte bli registrerad, testa med ett annat användarnamn</p>");
            $this->redirectTo();
        }

        
        $this->redirectTo('login');
        return true;
    }

    public function updateAction( $id ,$username, $email, $text)
    {
        try {
            $res = $this->users->save([
            'id'       => $id,
            'username'  => $username,
            'email'    => $email,
            'text'     => $text,
        ]);
            if ($res == true) {
                $this->form->AddOutput("<p>Dina ändringar har sparats</p>");
            }
        }

        catch (\Exception $e) {
            $this->form->AddOutput("<p>Detta användarnamnet är upptaget</p>");
            $this->redirectTo();
        }

        
        $this->redirectTo();
        return true;
    }

    public function getMostActiveUsers($limit)
    {     
        $users = $this->users->findAll();
        $mostActive = array();
        foreach ($users as $user) {
           $questions = $this->QuestionsController->getQuestionsByUser($user->id);
           $answers = $this->AnswersController->getAnswersByUser($user->id);
           $mostActive[$user->id] = count($questions) + count($answers); 
        }
        arsort($mostActive);     
        $mostActiveUsers = array();
        foreach ($mostActive as $userId => $val) {
            foreach ($users as $user) {

                if($user->id == $userId) {
                    $mostActiveUsers[] = $user;

                }
            }
        }
        $topMostActive = array_reverse(array_slice($mostActiveUsers, 0, $limit));
        return $topMostActive;
        //return $mostActive;
    }

    private function callbackSuccess($form)
    {
            // What to do if the form was submitted?
            $user = $this->users->getOnlineUser();
            $this->redirectTo('user/id/' . $user->id);
    }

    private function callbackFailLogin($form)
    {
            // What to do if the form was submitted?
            $form->AddOUtput("<p><i>Användarnamn eller lösenord är felaktiga</i></p>");
            $this->redirectTo();
    }

    private function callbackFailRegister($form)
    {
            // What to do if the form was submitted?
            $form->AddOUtput("<p><i>Något gick fel</i></p>");
            $this->redirectTo();
    }

}
