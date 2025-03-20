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


#[AsCommand(
    name: 'app:import-contact',
    description: 'Import a list of contacts from a CSV file into the contact table'
)]
class ImportContactCommand extends Command{

    protected function execute(InputInterface $input, OutputInterface $output):int
    {
        $file_path = $input->getArgument('file_path');

        //TODO : try/catch ?
        $csv_reader = new CsvReader($file_path);

        $output->writeln("Importing contacts from : \"$file_path\"");

        $csv_data = $csv_reader->getArray();



        //$logger = new ConsoleLogger($output);
        //$logger->info('Hello world !');

        //In case of success
        return Command::SUCCESS;

        //In case of wrong inputs
        return Command::INVALID;

        //In case of failure
        return Command::FAILURE;
    }

    protected function configure():void
    {
        $this->addArgument('file_path', InputArgument::REQUIRED, 'Path of contact file');
    }

}