<?php

include_once __DIR__ . '/UserTableMock.php';

/**
 * Created by PhpStorm.
 * User: user1
 * Date: 19.11.2015
 * Time: 15:21
 */
class UserControllerTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var \Application\UserController
     */
    protected $controller;

    /**
     * @var PDO
     */
    protected $db;


    public static function setUpBeforeClass()
    {

    }

    public function setUp()
    {
        $this->controller = new \Application\UserController();
    }

    public function tearDown()
    {
        unset($this->db);
        unset($this->controller);
    }

    public function testInstanceOf()
    {
        $this->assertInstanceOf('Application\UserController', $this->controller);
    }

    public function testErrorViewWithoutPostEmail()
    {
        $ret = $this->controller->resetPasswordAction();
        $this->assertInstanceOf('Application\ErrorView', $ret);
    }

    public function testErrorViewUserNichtInDb()
    {
        $_POST['email'] = 'nichtindb';

        $userTableMock = $this->getMock('Application\UserTable');
        $userTableMock->method('getUserByEmail')->willReturn(false);
        $this->controller->setUserTable($userTableMock);

        $ret = $this->controller->resetPasswordAction();
        $this->assertInstanceOf('Application\ErrorView', $ret);
    }

    public function testUserInDb()
    {
        $_POST['email'] = 'foo';

        $userTableMock = $this->getMock('Application\UserTable');
        $userTableMock->method('getUserByEmail')->willReturn(array('code' => 'abc'));

        $this->controller->setUserTable($userTableMock);

        $ret = $this->controller->resetPasswordAction();
        $this->assertInstanceOf('Application\View', $ret);
        $this->assertNotInstanceOf('Application\ErrorView', $ret);
    }

    public function testUpdateCode()
    {
        $_POST['email'] = 'foo';

        $userTableMock = $this->getMockBuilder('Application\UserTable')
            ->setMethods(array('getUserByEmail', 'updateCodeByEmail'))
            ->getMock();
        $userTableMock->method('getUserByEmail')->willReturn(array('code' => 'foo'));

        $userTableMock->expects($this->once())
            ->method('updateCodeByEmail')
            ->with($this->logicalAnd($this->isType('string')), $this->stringContains('foo'));

        $this->controller->setUserTable($userTableMock);

        $ret = $this->controller->resetPasswordAction();
        $this->assertInstanceOf('Application\View', $ret);
        $this->assertNotInstanceOf('Application\ErrorView', $ret);
    }


    public function testMailer()
    {
        $_POST['email'] = 'foo';

        $this->injectTableMock($this->controller);

        $mailMock = $this->getMockBuilder('Application\Mailer')
            ->setMethods(array('send'))
            ->getMock();
        $mailMock->expects($this->once())->method('send')
            ->with($this->equalTo($_POST['email']), $this->stringContains("Reset"), $this->stringContains("Code"));

        $this->controller->setMailer($mailMock);

        $this->controller->resetPasswordAction();
    }

    /**
     * @param $controller
     */
    protected function injectTableMock($controller)
    {
        $userTableMock = $this->getMockBuilder('Application\UserTable')
            ->setMethods(array('getUserByEmail', 'updateCodeByEmail'))
            ->getMock();
        $userTableMock->method('getUserByEmail')->willReturn(array('code' => 'abc'));

        $controller->setUserTable($userTableMock);
    }

}