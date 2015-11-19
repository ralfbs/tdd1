<?php

/**
 * TDD
 *
 * @category  TDD
 * @copyright Copyright (c) 2015 by hr-interactive. All rights reserved.
 * @author    Ralf Schneider
 */

/**
 * Class UserController
 */
class UserController
{

    public function resetPasswordAction()
    {

        if (!isset($_POST['email'])) {
            return new ErrorView('resetPassword', 'Keine E-Mail');
        }

        $db = new PDO(Config::get('dsn'));

        $stmt = $db->prepare('SELECT * FROM Users WHERE email=:email');
        $stmt->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row == false) {
            return new ErrorView('resetPassword', 'Keine Benutzer mit dieser E-Mail');
        }
        $code = CryptHelper::getConfirmationCode();

        $stmt = $db->prepare('UPDATE Users SET code=:code WHERE email=:email');
        $stmt->bindValue(':code', $code, PDO::PARAM_STR);
        $stmt->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
        $stmt->execute();

        mail($_POST['email'], 'Reset Password', 'Confirmation Code: ' . $code);

        return new View('PasswordResetRequested');

    }
}