<?php

/**
 * Created by PhpStorm.
 * User: aurelwcs
 * Date: 08/04/19
 * Time: 18:40
 */

namespace App\Controller;

use App\Model\HomeManager;

class HomeController extends AbstractController
{
    /**
     * Display home page
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */

    public function index(): string
    {
        $manager = new HomeManager();
        //select list of argonauts name from DB, order by name in ASC order
        $argonauts = $manager->selectAll('name');
        $errors = [];
        //check if FORM is submitted
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            //remove spaces before and after word, put everything in LowerCase and the only first letter in Uppercase
            $name = trim(ucwords(strtolower($_POST['name'])));
            if (empty($_POST['name'])) {
                $errors[] = "The name field should not be empty";
            }
            if (strlen($name) > 70) {
                $errors[] = "Number of characters cannot be greater than 70";
            }
            if (is_numeric($name)) {
                $errors[] = "Names should be in alphanumeric characters";
            }
            //check if data is already in DB, or field empty, or name above 70 letters,
            foreach ($argonauts as $argonaut) {
                if (in_array($name, $argonaut)) {
                    $errors[0] = "This name is already in the list";
                }
            }
            if (empty($errors)) {
                $manager->add($name);
            }
        }
        $argonauts = $manager->selectAll('name');
        return $this->twig->render('Home/index.html.twig', [
            'argonauts' => $argonauts,
            'errors' => $errors
        ]);
    }
}
