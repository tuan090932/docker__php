<?php

use PHPUnit\Framework\TestCase;
use App\Controllers\AuthController;

class AuthControllerTest extends TestCase
{
    private $authController;

    protected function setUp(): void
    {
        $this->authController = new AuthController();
    }

    public function testLoginPostWithLoginOnly()
    {
        // Arrange
        $mockHandleLoginService = $this->createMock(\App\Services\HandleLoginService::class);
        $mockHandleLoginService->expects($this->once())
            ->method('handle_data_login')
            ->with($this->equalTo(['email' => 'test@example.com', 'password' => 'password']));
        $mockHandleLoginService->expects($this->once())
            ->method('handle_login')
            ->with($this->equalTo(['email' => 'test@example.com', 'password' => 'password']), $this->equalTo(false));
        $authController = new AuthController();
        $authController->HandleLoginService = $mockHandleLoginService;

        // Act
        $data = [
            'email' => 'test@example.com',
            'password' => 'password',
            'login' => true,
        ];

        // Assert
        $authController->login_post($data);
    }
}
