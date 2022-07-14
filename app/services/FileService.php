<?php


namespace App\services;
use App\Models\Book;
use App\Contracts\BookInterface;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileService
{
    /**
     * FileService constructor.
     * @param BookInterface $bookRepo
     */
    public function __construct(
        protected BookInterface $bookRepo)
    {}

    /**
     * @param $fileService
     * @return array
     */
    public function file($fileService){
    try {
        $image = Storage::putFile('public/photos', $fileService['bookFile']);
        $image = Str::replaceFirst('public', 'storage', $image);
        $bookpdf = Storage::putFile('public/pdfFile', $fileService['bookpdf']);
        $bookpdf = Str::replaceFirst('public', 'storage', $bookpdf);
        return [
            'image' => $image,
            'bookPdf' => $bookpdf,
        ];
    }catch (\Exception $exception){
        return [
            'image' => false,
            'bookPdf' => false,
            'massage'=>$exception->getMessage()
        ];
    }
}

}
