<?php
namespace App\Command;

//Library classes
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Logger\ConsoleLogger;

//Project classes
use App\Lib\CsvReader;
use App\Lib\Logger;
use App\Repository\Contact;

#[AsCommand(
    name: 'app:import-contact',
    description: 'Import a list of contacts from a CSV file into the contact table'
)]
class ImportContactCommand extends Command{

    const LOG_FILE = 'Import.log';

    protected function execute(InputInterface $input, OutputInterface $output):int
    {
        $file_path = $input->getArgument('file_path');
        $log_msg = '########## BEGIN IMPORT ##########';
        Logger::log($log_msg);
        Logger::log($log_msg, self::LOG_FILE);

        $log_msg = "Importing contacts from : \"$file_path\"";
        Logger::log($log_msg);
        Logger::log($log_msg, self::LOG_FILE);
        try {
            $csv_reader = new CsvReader($file_path);
            $csv_data = $csv_reader->getArray();
            $contact = new Contact();

            $success_count = 0;
            $error_count = 0;

            foreach($csv_data as $csv_line) {
                try {
                    $contact->addContact($csv_line['insee'], $csv_line['telephone']);
                    $success_count++;
                } catch (\Exception $exception) {
                    Logger::log($exception->getMessage());
                    $error_count++;
                }
            }

            $log_msg = "End of import : $success_count success insertions, $error_count failed insertions";
            Logger::log($log_msg);
            Logger::log($log_msg, self::LOG_FILE);

            $log_msg = "########## END IMPORT ##########\n\n";
            Logger::log($log_msg);
            Logger::log($log_msg, self::LOG_FILE);
            return Command::SUCCESS;
        } catch (Exception $exception) {
            return Command::FAILURE;
        }        
    }

    protected function configure():void
    {
        $this->addArgument('file_path', InputArgument::REQUIRED, 'Path of contact file');
    }

}