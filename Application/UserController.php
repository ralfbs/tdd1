<?php

/**
 * TDD
 *
 * @category  TDD
 * @copyright Copyright (c) 2015 by hr-interactive. All rights reserved.
 * @author    Ralf Schneider
 */
namespace Application;

/**
 * Class UserController
 */
class UserController
{

    protected $userTable;

    /**
     * @var Mailer
     */
    protected $mailer;

    public function resetPasswordAction()
    {
        if (!isset($_POST['email'])) {
            return new ErrorView('resetPassword', 'Keine E-Mail');
        }

        $userTable = $this->getUserTable();
        $row = $userTable->getUserByEmail($_POST['email']);

        if ($row == false) {
            return new ErrorView('resetPassword', 'Keine Benutzer mit dieser E-Mail');
        }
        $code = CryptHelper::getConfirmationCode();

        $this->getUserTable()->updateCodeByEmail($code, $_POST['email']);

        $this->getMailer()->send($_POST['email'], 'Reset Password', 'Confirmation Code: ' . $code);

        return new View('PasswordResetRequested');
    }

    /**
     * @return mixed
     */
    public function getUserTable()
    {
        if (empty($this->userTable)) {
            $this->userTable = new UserTable();
        }
        return $this->userTable;
    }

    /**
     * @param mixed $userTable
     */
    public function setUserTable($userTable)
    {
        $this->userTable = $userTable;
    }

    /**
     * @return Mailer
     */
    public function getMailer()
    {
        if (empty($this->mailer)) {
            $this->mailer = new Mailer();
        }
        return $this->mailer;
    }

    /**
     * @param Mailer $mailer
     */
    public function setMailer($mailer)
    {
        $this->mailer = $mailer;
    }


}