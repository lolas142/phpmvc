<?php

namespace Anax\Comments;
 
/**
 * A controller for users and admin related events.
 *
 */
class CommentsController extends \Anax\MVC\CControllerBasic
{

    private $form;
    private $comments;

    public function __construct() {

    }

    public function setup() {

        $this->comments = new Comments();
        $this->comments->setDI($this->di);
        
    }



    /**
     * Reset and setup database table
     *
     * @return void
     */
    public function setupAction()
    {
       $this->comments->setup();
    }





    // Register
    /**
     * Add new user.
     * @param type string - question or answer
     * @param id, int
     * @return void, but writes to view
     *
     */
    public function formAction($type, $id)
    {
        // Check if answer or question and get form
        if($type == 'answer') {
            $this->form = new CCommentsForm($id, null);
            $this->form->setDI($this->di);
            $content = $this->AnswersController->getAnswerById($id);
            $comments = $this->getCommentsForAnswer($id);
        }
        elseif ($type == 'question') {
            $this->form = new CCommentsForm(null, $id);
            $this->form->setDI($this->di);
            $content = $this->QuestionsController->getQuestion($id);
            $comments = $this->getCommentsForQuestion($id);
        }

        // Get form and send output
        if ($this->UserController->checkIfLoggedIn()) {
            $status = $this->form->check();

            if($status === true) {
                $this->callbackSuccess($this->form);
            }
            elseif($status === false) {
                $this->callbackFail($this->form);
            }
            $form = $this->form->getHTML();

            // Prepare the page content
            $this->theme->setVariable('pageheader', "<div class='pageheader'><h1>Kommentera</h1></div>");
            $this->theme->setTitle('Kommentera');
            $this->views->add('comments/list-one', [
                'content' => $content,
                'comments' => $comments,
                'form' => $form,
            ]);
        }

        // Ask user to login if not logged in
        else {
            // Prepare the page content
            $this->theme->setVariable('title', "Kommentera")
                        ->setVariable('pageheader', "<div class='pageheader'><h1>Kommentera</h1></div>")
                        ->setVariable('main', "
                    <h1>Kommentera</h1>
                    <a href=" . $this->url->create('login') . ">Logga in för att kunna kommentera</a>" 
            );
        }

    }


    /**
     * Get comments for answer
     * @param id int
     * @return array 
     */
    public function getCommentsForAnswer($id)
    {
        $res = $this->comments->getCommentsForAnswer($id);

        return $res;   

    }

    /**
     * Get comments for Questions
     * @param id int
     * @return array 
     */
    public function getCommentsForQuestion($id)
    {
        $res = $this->comments->getCommentsForQuestion($id);

        return $res;   

    }

    /**
     * Add comment
     * @param id int
     * @param answerId int (optional)
     * @param questionId int (optional)
     * @return boolean - redirects to same url
     */
    public function addCommentAction($text, $answerId = null, $questionId = null)
    {
        // Get user id from logged in user
        $user = $this->UserController->getUserAction();
        $userId = $user->id;
        $now = gmdate('Y-m-d H:i:s');

        try {
            $res = $this->comments->save([
            'text'    => $text,
            'userId' => $userId,
            'questionId' => $questionId,
            'answerId' => $answerId,
            'created' => $now
        ]);
        }
        catch (\Exception $e) {
            $this->form->AddOutput("<p>Kommentaren kunde inte sparas</p>");
            $this->form->AddOutput($e->getMessage());
        }
        
        $this->redirectTo();
        return true;
    }


    private function callbackSuccess($form)
    {
            // What to do if the form was submitted?
            $form->AddOUtput("<p><i>Form was submitted and the callback method returned TRUE</i></p>");
            $this->redirectTo();
    }

    private function callbackFail($form)
    {
            // What to do if the form was submitted?
            $form->AddOUtput("<p><i>Form was submitted and the callback method returned FALSE</i></p>");
            $this->redirectTo();
    }



 
}