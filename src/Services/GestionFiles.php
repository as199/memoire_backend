<?php

namespace App\Services;

use Symfony\Component\HttpFoundation\Request;

class GestionFiles
{

    public function getPostFile(Request $request, string $key)
    {
        $uploadedFile = $request->files->get($key);
        if($uploadedFile){
            $filePath = $uploadedFile->getRealPath();
            $file = fopen($filePath,'r+');
        }else{
            $file = null;
        }
        return $file;
    }

    public function getPutFile(Request $request, string $fileName = null)
    {
        $raw = $request->getContent();
        $delimiteur = "multipart/form-data; boundary=";
        $boundary = "--" . explode($delimiteur, $request->headers->get("content-type"))[1];
        $elements = str_replace([$boundary, 'Content-Disposition: form-data;', "name="], "", $raw);
        $elementsTab = explode("\r\n\r\n", $elements);
        $data = [];
        for ($i = 0; isset($elementsTab[$i + 1]); $i += 2) {
            $key = str_replace(["\r\n", ' "', '"'], '', $elementsTab[$i]);
            if (strchr($key, $fileName)) {
                $stream = fopen('php://memory', 'r+');
                fwrite($stream, $elementsTab[$i + 1]);
                rewind($stream);
                $data[$fileName] = $stream;
            } else {
                $val = str_replace(["\r\n", "--"],'',$elementsTab[$i+1]);
                $data[$key] = $val;
            }
        }
        return $data;
    }
}