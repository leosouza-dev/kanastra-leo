<?php

use App\src\Domain\Entities\Debt;
use App\src\Infrastructure\Services\CsvDebtImporter;
use Illuminate\Http\UploadedFile;
use PHPUnit\Framework\TestCase;

class CsvDebtImporterTest extends TestCase
{
    public function testImport()
    {
        $csvContent = "name,governmentId,email,debtId,debtAmount,debtDueDate\nJohn Doe,123456789,john@example.com,1,100.0,2023-05-15";
        $csvFile = $this->createCsvFile($csvContent);
        $importer = new CsvDebtImporter();
        $debts = $importer->import($csvFile);

        $this->assertIsArray($debts);
        $this->assertNotEmpty($debts);
        $this->assertInstanceOf(Debt::class, $debts[0]);

        $debt = $debts[0];
        $this->assertEquals('John Doe', $debt->getName());
        $this->assertEquals('123456789', $debt->getGovernmentId());
        $this->assertEquals('john@example.com', $debt->getEmail());
        $this->assertEquals(1, $debt->getDebtId());
        $this->assertEquals(100.0, $debt->getDebtAmount());
        $this->assertEquals('2023-05-15', $debt->getDebtDueDate()->format('Y-m-d'));
    }

    private function createCsvFile(string $content): UploadedFile
    {
        $filePath = sys_get_temp_dir() . '/test.csv';
        file_put_contents($filePath, $content);
        return new UploadedFile($filePath, 'test.csv', 'text/csv', null, true);
    }
}
