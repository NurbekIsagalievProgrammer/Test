<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WordGenerationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_generates_a_word_document()
    {
        // Данные для запроса
        $data = [
            'title' => 'Test Document',
            'date' => '2024-07-25',
        ];

        // Выполнение POST-запроса
        $response = $this->post('api/generate', $data);

        // Проверка, что запрос вернул статус 200
        $response->assertStatus(200);

        // Проверка, что заголовок Content-Disposition присутствует
        $response->assertHeader('Content-Disposition');

        // Получение заголовка Content-Disposition
        $contentDisposition = $response->headers->get('Content-Disposition');

        // Отладочная информация
        dump($contentDisposition);

        // Проверка, что заголовок содержит ожидаемое имя файла
        $this->assertStringContainsString('attachment; filename=document.docx', $contentDisposition);

        // Сохранение документа во временную директорию
        $tempDir = storage_path('app/temp');
        if (!is_dir($tempDir)) {
            mkdir($tempDir, 0755, true);
        }
        $tempFilePath = $tempDir . '/document.docx';
        file_put_contents($tempFilePath, $response->getContent());

        // Проверка существования файла
        $this->assertFileExists($tempFilePath);

        // Удаление временного файла
        unlink($tempFilePath);
    }
}
