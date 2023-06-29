<?php

class DataManager
{
    public function saveData(array $data)
    {
        // Збереження даних в базі даних
    }

    public function displayData(array $data)
    {
        // Відображення даних на веб-сторінці
    }
}

class Authetication
{
    public function authenticate(string $username, string $password, string $role)
    {
        // Логіка аутентифікації користувача
    }
}

class User
{
    public function displayProfile(int $userId)
    {
        // Відображення профілю користувача
    }
}

interface FileHandlerInterface
{
    // Читання файлу
    public function read();

    // Запис даних в файл
    public function write(OrderData $data);
}

class TxtFileHandler implements FileHandlerInterface
{

    public function read()
    {
        // Логіка читання TXT файлу
    }

    public function write(OrderData $data)
    {
        // Логіка запису TXT файлу
    }
}

class CsvFileHandler implements FileHandlerInterface
{

    public function read()
    {
        // Логіка читання CSV файлу
    }

    public function write(OrderData $data)
    {
        // Логіка запису CSV файлу
    }
}

class FileManager
{
    public function readFile(FileHandlerInterface $filename)
    {

        // визначення розширення $ext
        $filename->read();
    }

    public function writeFile(FileHandlerInterface $filename, OrderData $data)
    {
        // визначення розширення $ext
        $filename->write($data);
    }
}

class OrderData
{
    public function __construct(
        private readonly int $id,
        protected string $title,
        protected array $list,
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }
}

class Order
{
    public function displayOrderInfo(OrderData $orderData)
    {

        // Відображення інформації про замовлення
    }
}

class OrderProcessor
{
    public function processOrder(Order $order)
    {
        // Обробка замовлення
    }
}
