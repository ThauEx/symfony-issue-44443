<?php

namespace App\Command;

use Goutte\Client;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

class UploadTestCommand extends Command
{
    protected static $defaultName = 'app:upload-test';

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $helper = $this->getHelper('question');

        $output->writeln('Please start a webserver on port 8008, e.g. symfony serve --port 8008');
        $question = new Question('Press any key to continue.');
        $question->setHidden(true);
        $question->setHiddenFallback(false);

        $helper->ask($input, $output, $question);

        $file = $this->createFile('1', '1-mb');

        $client = new Client();
        $client->request('GET', 'https://127.0.0.1:8008/upload');

        $client->submitForm('submit', [
            'file' => $file,
        ]);

        $output->writeln($client->getResponse()->getContent());

        if ($client->getResponse()->getStatus() === 200) {
            return 0;
        }

        return 1;
    }

    private function createFile(string $size, string $name): string
    {
        $filename = dirname(__DIR__) .  "/../var/cache/$name";
        $file = fopen($filename, 'cb');
        ftruncate($file, $size<<20);
        fclose($file);

        return $filename;
    }
}
