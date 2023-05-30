<?php

namespace Vpos;

class Core
{
    const PAGE_NAME_HOMEPAGE = 'Home';
    const PAGE_NAME_RESULT = 'Result';
    const PAGE_NAME_NOT_FOUND = 'NotFound';
    const PAGE_NAME_REVIEW = 'Review';

    public $pageName;

    function __construct()
    {
        $this->pageName = array_key_exists('isSuccessful', $_POST) ?
            self::PAGE_NAME_RESULT :
            self::pageParameter();
    }

    function getPageName()
    {
        return $this->pageName;
    }

    function setPageName($newName)
    {
        $this->pageName = $newName;
    }

    function getRelativePagePath()
    {
        return '../pages/' . $this->getPageName() . '.php';
    }

    function getAbsolutePagePath()
    {
        return __DIR__ . '/' . $this->getRelativePagePath();
    }

    function isPageExists()
    {
        return file_exists($this->getAbsolutePagePath());
    }

    static function pageParameter()
    {
        return isset($_GET['p']) ? $_GET['p'] : self::PAGE_NAME_HOMEPAGE;
    }

    private function loadPageData()
    {
        if (
            !array_key_exists('p', $_GET) &&
            !array_key_exists('isSuccessful', $_POST)
        ) return null;

        switch ($this->getPageName()) {
            case 'Form':
                $type = new \Vpos\Type();
                $parameters = $type->getParameters();
                $action = $type->getAction();

                $data = [
                    'Amount' => 27.3,
                    'OtherTrxCode' => 'FO' . rand(1000, 10000)
                ];
                unset($parameters['CheckKey']);

                return [
                    'dummyData' => $data,
                    'parameters' => $parameters,
                    'action' => $action
                ];
            case 'Review':
                return [
                    'CheckKey' => hash(
                        'sha256',
                        $_POST['vpos']['fields']['DealerCode'] . 'MK' .
                        $_POST['vpos']['fields']['Username'] . 'PD' .
                        $_POST['vpos']['fields']['Password']
                    )];
            case 'Result':
                return [
                    'success' =>
                        array_key_exists('isSuccessful', $_POST) &&
                        $_POST["isSuccessful"] == "True",
                    'errorMessage' => $_POST['resultMessage']
                ];
            default:
                return [];
        }
    }

    function checkRedirect() {
        if (array_key_exists('p', $_GET) && $_GET['p'] == 'post') {
            include_once __DIR__ . '/' . 'redirect.php';
        }
    }

    function load()
    {
        if (
            !$this->isPageExists() or
            (
                isset($_GET['p']) and
                $_GET['p'] === self::PAGE_NAME_REVIEW and
                !isset($_POST['vpos'])
            )
        ) {
            http_response_code(404);

            $this->setPageName(self::PAGE_NAME_NOT_FOUND);
        }

        $pageData = $this->loadPageData();
        include_once $this->getAbsolutePagePath();
    }
}