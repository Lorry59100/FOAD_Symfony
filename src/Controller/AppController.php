<?php

namespace App\Controller;

use App\Entity\Answers;
use App\Entity\Questions;
use App\Form\AskQuestionType;
use App\Form\AnswerQuestionType;
use App\Repository\QuestionsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AppController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(Request $request, EntityManagerInterface $entityManager, QuestionsRepository $questionsRepository): Response
    {
        /* POSER UNE QUESTION */
        $question = new Questions();
        $form = $this->createForm(AskQuestionType::class, $question);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $question->addUser($this->getUser());
            $entityManager->persist($question);
            $entityManager->flush();
        }

        /* LISTE DES QUESTIONS */
        $questionList = $questionsRepository->findAll();

        /* QUESTIONS DE L'UTILISATEUR */
        $currentUser = $this->getUser();
        $userQuestions = [];
        if ($currentUser) {
            $userQuestions = $currentUser->getQuestions()->toArray();
        }
        
        return $this->render('app/index.html.twig', [
            'controller_name' => 'AppController',
            'form' => $form->createView(),
            'questionList' => $questionList,
            'userQuestions' => $userQuestions,
        ]);
    }

    /**
     * @Route("/answer/{id}", name="answer_question")
     */
    public function answerQuestion(Request $request, EntityManagerInterface $entityManager, QuestionsRepository $questionsRepository, $id): Response
    {
        $question = $questionsRepository->find($id);
        $answer = new Answers();
        $form = $this->createForm(AnswerQuestionType::class, $answer);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $answer->setVote(0);
            $entityManager->persist($answer);
            $question->addAnswer($answer);
            $entityManager->persist($question);
            $entityManager->flush();
        }

        return $this->render('app/answer_question.html.twig', [
            'form' => $form->createView(),
            'question' => $question,
        ]);
    }
}
