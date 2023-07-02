<?php

interface DatabaseInterface
{
    public function insert(string $table, array $data);
}

class Database implements DatabaseInterface
{
    public function insert(string $table, array $data)
    {
        // Insert query
    }
}

interface EmailServiceInterface
{
    public function sendWelcomeEmail(string $email);
}

class EmailService implements EmailServiceInterface
{
    public function sendWelcomeEmail(string $email)
    {
        // Send email
    }
}

interface SMSServiceInterface
{
    public function sendSMS(string $phone, string $message);
}

class SMSService implements SMSServiceInterface
{
    public function sendSMS(string $phone, string $message)
    {
        // Send SMS
    }
}

class UserService
{
    public function __construct(
        protected DatabaseInterface $db,
        protected EmailServiceInterface $mailer,
        protected SMSServiceInterface $smsService,
    ) {
    }

    public function registerUser(array $userData): void
    {
        // Реєстрація користувача в базі даних
        $this->db->insert('users', $userData);

        // Відправка ласкаво просимо повідомлення електронною поштою
        $this->mailer->sendWelcomeEmail($userData['email']);

        // Відправка повідомлення на мобільний телефон
        $this->smsService->sendSMS($userData['phone'], 'Вітаємо з реєстрацією!');
    }
}
