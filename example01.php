<?php

class OrderData
{
    public function __construct(
        protected string $title,
        protected ReportInterface $type,
        protected array $list,
    ) {
    }

    public function getType(): ReportInterface
    {
        return $this->type;
    }
}

class OrderProcessor
{
    public function __construct(
        protected ReportInterface $report
    ) {
    }

    public function processOrder(OrderData $order)
    {
        $this->report->generateReport($order);
    }
}


interface ReportFormatInterface
{
    public function generate(OrderData $data);
}

class PDFReport implements ReportFormatInterface
{
    public function generate(OrderData $data): void
    {
        // Логіка генерації звіту у форматі PDF
        var_dump($data, 'PDF');
    }
}

class CSVReport implements ReportFormatInterface
{
    public function generate(OrderData $data): void
    {
        // Логіка генерації звіту у форматі CSV
        var_dump($data, 'CSV');
    }
}

interface ReportInterface
{
    public function generateReport(OrderData $data): void;
}

abstract class Report
{
    public function __construct(
        protected ReportFormatInterface $format,
    ) {
    }
}

class ProductReport extends Report implements ReportInterface
{
    public function generateReport(OrderData $data): void
    {
        $this->format->generate($data);
    }
}

class ServiceReport extends Report implements ReportInterface
{
    public function generateReport(OrderData $data): void
    {
        $this->format->generate($data);
    }
}

class DeliveryReport extends Report implements ReportInterface
{
    public function generateReport(OrderData $data): void
    {
        $this->format->generate($data);
    }
}

$report = new ProductReport(new CSVReport());

$orderData = new OrderData('Lorem Ipsum', $report, [
    [
        'id' => 66,
        'title' => 'Lorem ipsum',
        'amount' => 10,
    ],
    [
        'id' => 22,
        'title' => 'Lorem ipsum dolorem',
        'amount' => 5,
    ],
]);
$report->generateReport($orderData);
