<?php
session_start();

use Phalcon\Mvc\Controller;
use Phalcon\Mvc\Model\Manager;

class IndexController extends Controller
{
    public function indexAction()
    {
        $ch = curl_init();
        if ($_POST) {
            
            $book = urlencode($this->request->getPost('search_box'));
            $url = 'https://openlibrary.org/search.json?q=' . $book;
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $result = curl_exec($ch);
            $result = json_decode($result, true)['docs'];
            $this->view->books = array_slice($result, 0, 10);
        }
    }
    public function singlepageAction($isbn)
    {
        $ch = curl_init();
        $url = 'https://openlibrary.org/api/books?bibkeys=olid:' . $isbn . '&jscmd=details&format=json';
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = json_decode(curl_exec($ch), true);
        $this->view->book = $result['olid:' . $isbn . '']['details'];
    }
    public function googleBooksAction($isbn)
    {
        $ch = curl_init();
        $url = 'https://openlibrary.org/api/books?bibkeys=olid:' . $isbn . '&jscmd=details&format=json';
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = json_decode(curl_exec($ch), true);
        $this->view->book = $result['olid:' . $isbn . '']['details'];
    }
    public function googleAction($id)
    {
        $ch = curl_init();
        $url = "https://www.google.co.in/books/edition/_/".$id."?hl=en";
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_exec($ch);
        die;
    }
}
