<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;

class WordController extends Controller
{
    public function generate(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'date' => 'required|date',
        ]);

        $phpWord = new PhpWord();
        $section = $phpWord->addSection();
        $section->addText('Название документа: ' . $request->input('title'));
        $section->addText('Дата создания документа: ' . $request->input('date'));

        $tempFile = tempnam(sys_get_temp_dir(), 'doc');
        $phpWord->save($tempFile, 'Word2007');

        return response()->download($tempFile, 'document.docx')->deleteFileAfterSend(true);
    }
}
