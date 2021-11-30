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
    /**
     * Displays Argonauts datas to home page
     */

    public function showArgonauts(): string
    {
        $manager = new HomeManager();
        //select list of argonauts name from DB, order by name in ASC order
        $argonauts = $manager->selectAll('name');

        return $this->twig->render('Home/index.html.twig', ['argonauts' => $argonauts]);
    }
    /**
     * Form validation and add new Argonauts names into DB
     */
    public function addArgonauts(): string
    {
        //remove spaces before and after word, put everything in LowerCase and the only first letter in Uppercase
        $name = trim(ucwords(strtolower($_POST['name'])));
        $errors = [];
        //check if FORM is submitted
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        //check if field is empty, return an error if not
            if (empty($_POST['name'])) {
                return $errors[] = "The name field should not be empty";
            }
        //check if data lenght is < to 70 caracters like in DB
            if (strlen($name) > 70) {
                return $errors[] = "Names number of caracters cannot be greater than 70";
            }
        //else send it in DB
            $manager = new HomeManager();
            $manager->add($name);
            header('Location:/');
        }
        return $this->twig->render('Home/index.html.twig', ['errors' => $errors]);
    }
}
