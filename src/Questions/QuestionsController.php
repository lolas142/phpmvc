<?php

namespace Anax\Questions;
 
/**
 * A controller for question related events
 *
 */
class QuestionsController extends \Anax\MVC\CControllerBasic
{

    private $form;
    private $questions;
    private $currentQuestion;

    public function __construct() {

    }

    /*
     * Sets up dependencies - shoudl be called after setDI
     */ 
    public function setup() {

        $tags = $this->di->TagsController->getTags();

        $this->form = new CQuestionsForm($tags);
        $this->questions = new Questions();

        $this->form->setDI($this->di);
        $this->questions->setDI($this->di);
        
    }



    /**
     * Reset and setup database table
     *
     * @return void
     */
    public function setupAction()
    {
       $this->questions->setup();
    }


    /**
     * List all questions.
     *
     * @return void
     */
    public function listAction()
    {
     
        $all = $this->questions->findAll();
     
        $this->theme->setVariable('pageheader', "<div class='pageheader'><h1>Alla frågor</h1></div>");
        $this->theme->setTitle("Alla frågor");
        $this->views->add('questions/list-all', [
            'questions' => $all,
            'title' => "Alla nedan listas alla frågor",
        ]);
    }

    /**
     * Show one question
     *
     * @param int $id of question to display
     *
     * @return void
     */
    public function idAction($id)
    {     
        $this->currentQuestion = $id; 
        $question = $this->questions->find($id);
        $answerForm = $this->AnswersController->getForm();
        $answers = $this->AnswersController->getAnswers($id);
        
        $this->theme->setVariable('pageheader', "<div class='pageheader'><h1>Frågor</h1></div>");
        $this->theme->setTitle($question->subject);
        $this->views->add('questions/list-one', [
            'question' => $question,
            'form' => $answerForm,
            'answers' => $answers
        ]);
    }


    /**
     * Create new question
     *
     */
    public function createAction()
    {
        if ($this->UserController->checkIfLoggedIn()) {
            $status = $this->form->check();

            if($status === true) {
                $this->callbackSuccess($this->form);
            }
            elseif($status === false) {
                $this->callbackFail($this->form);
            }

            // Prepare the page content
            $this->theme->setVariable('title', "Skapa ny fråga")
                        ->setVariable('pageheader', "<div class='pageheader'><h1>Lägg till ny fråga</h1></div>")
                        ->setVariable('main', "
                    <h1>Lägg till ny fråga</h1>"
                    . $this->form->getHTML()
            );
        }
        else {
            // Prepare the page content
            $this->theme->setVariable('title', "Skapa ny fråga")
                        ->setVariable('pageheader', "<div class='pageheader'><h1>Lägg till ny fråga</h1></div>")
                        ->setVariable('main', "
                    <h1>Lägg till ny fråga</h1>
                    <a href=" . $this->url->create('login') . ">Logga in för att kunna skriva frågor</a>" 
            );
        }

    }

    /*
     * Add a questions to the database and connects it with tags
     */ 
    public function addAction($subject, $text, $oldTags = array(), $newTags = null)
    {
        // Add new tags
        if($newTags) {
            $this->di->TagsController->addAction($newTags);
        }

        // Get user id from logged in user
        $user = $this->UserController->getUserAction();
        $userId = $user->id;
        $now = gmdate('Y-m-d H:i:s');

        try {
            $res = $this->questions->save([
            'subject'  => $subject,
            'text'    => $text,
            'userId' => $userId,
            'created' => $now
        ]);
        }
        catch (\Exception $e) {
            $this->form->AddOutput("<p>Frågan kunde inte sparas</p>");
        }
        // Add tag relationsships between tags and question
        $this->di->TagsController->connectTagsAction($oldTags, $newTags, $this->questions->id );
        
        $this->redirectTo('questions/list');
        return true;
    }


    /*
     * Get lastest questions
     */ 
    public function getLatestQuestions($limit)
    {
        
        $res = $this->questions->getLatestQuestions($limit);
        return $res;

    }

    /*
     * Get questions by id
     */ 
    public function getQuestion($id=null)
    {
        if(!$id) { $id = $this->currentQuestion;}
        $res = $this->questions->find($id);
        $res = $res->getProperties();

        return $res;

    }

    /*
     * Get questions by user is
     */ 
    public function getQuestionsByUser($userId)
    {
        $res = $this->questions->getQuestionsForUser($userId);
        return $res;
    }

    /*
     * Gets the current questions if from url
     */ 
    public function getCurrentQuestionId()
    {
        if($this->currentQuestion) {
            return $this->currentQuestion;
        }
        else {
            $rp = $this->request->getRouteParts();
            $this->currentQuestion = $rp[2];
            return $this->currentQuestion;
        }

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