<?php
namespace Eni\Blog\Command;

use Eni\Blog\Services\SearchService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ExportCommand extends Command
{
    private $searchService;

    public function __construct(SearchService $searchService)
    {
        $this->searchService = $searchService;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            // Configuration du nom
            ->setName('eniblog:export')
            // Configuration de la description
            // Visible lors de l'appel à ./bin/console list
            ->setDescription('Exporte les articles')
            ->addArgument(
                'filter',
                InputArgument::OPTIONAL,
                'Mot clé pour filtrer les articles'
            )
            ->addOption(
                'format',
                null,
                InputOption::VALUE_OPTIONAL,
                'yml, table'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('Export des articles de blog');
        
        $sectionName = 'Recherche des articles';
        $filter = $input->getArgument('filter');
        if ($filter) {
            $sectionName .= ' (Filtre: '.$filter.')';
        }
        $io->section($sectionName);

        $io->progressStart();
        $dataTable = [];
        for ($i = 1; $i <= 3; $i++) {
            $io->progressAdvance();

            $dataTable[] = [$i, 'Article '.$i];
        }
        $io->progressFinish();
        
        if ('table' == $input->getOption('format')) {
            $io->table(
                ['id', 'name'],
                $dataTable
            );
        }
        ;

        $io->error($this->searchService->getNoResultsMessage());
        
        $io->success('Export terminé!');
    }
}