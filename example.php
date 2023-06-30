<?php

class Database
{
    public function insert(string $table, array $data)
    {
        // Insert query
    }
}

class EmailService
{
    public function sendWelcomeEmail(string $email)
    {
        // Send email
    }
}

class SMSService
{
    public function sendSMS(string $phone, string $message)
    {
        // Send SMS
    }
}

class UserService
{
    public function __construct(
        protected Database $db,
        protected EmailService $mailer,
        protected SMSService $smsService,
    ) {
    }

    public function registerUser($userData): void
    {
        // Реєстрація користувача в базі даних
        $this->db->insert('users', $userData);

        // Відправка ласкаво просимо повідомлення електронною поштою
        $this->mailer->sendWelcomeEmail($userData['email']);

        // Відправка повідомлення на мобільний телефон
        $this->smsService->sendSMS($userData['phone'], 'Вітаємо з реєстрацією!');
    }
}
