<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UploadController extends AbstractController
{
    /** @Route("/upload", name="upload_test") */
    public function uploadTestAction(Request $request): Response
    {
        if ($request->getMethod() === 'POST') {
            $file = $request->files->get('file');
            if ($file === null) {
                return new Response("No file has been uploaded\n", 400, ['Content-Type' => 'text/plain']);
            }
            @unlink($file->getPathname());
            if ($file->isValid()) {
                return new Response("OK\n", 200, ['Content-Type' => 'text/plain']);
            }

            return new Response($file->getErrorMessage() . "\n", 400, ['Content-Type' => 'text/plain']);
        }

        $html = <<<'HTML'
<form method="POST" enctype="multipart/form-data">
<input type="file" name="file" />
<input type="submit" value="submit" />
</form>
HTML;
        return new Response($html);
    }
}
