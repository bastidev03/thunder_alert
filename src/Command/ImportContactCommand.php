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

    const START_COMMAND = '########## BEGIN IMPORT ##########';

    const END_COMMAND = "########## END IMPORT ##########\n";


    protected function execute(InputInterface $input, OutputInterface $output):int
    {
        $file_path = $input->getArgument('file_path');

        $symfony_logger = new ConsoleLogger($output);
        Logger::log(self::START_COMMAND);
        $symfony_logger->warning(self::START_COMMAND);
        Logger::log(self::START_COMMAND, self::LOG_FILE);

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
                    $symfony_logger->warning($exception->getMessage());
                    $error_count++;
                }
            }

            $log_msg = "End of import : $success_count success insertions, $error_count failed insertions";
            Logger::log($log_msg);
            Logger::log($log_msg, self::LOG_FILE);

            Logger::log(self::END_COMMAND);
            Logger::log(self::END_COMMAND, self::LOG_FILE);
            return Command::SUCCESS;

        } catch (\Exception $exception) {

            $error_msg = "Error during import : ".$exception->getMessage();
            Logger::log($error_msg, self::LOG_FILE);
            
            Logger::log(self::END_COMMAND);
            Logger::log(self::END_COMMAND, self::LOG_FILE);

            throw($exception);
            return Command::FAILURE;
        }        
    }

    protected function configure():void
    {
        $this->addArgument('file_path', InputArgument::REQUIRED, 'Path of contact file');
    }

}