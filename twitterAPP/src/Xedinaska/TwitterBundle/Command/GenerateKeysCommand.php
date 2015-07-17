<?php

namespace Xedinaska\TwitterBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Xedinaska\TwitterBundle\Service\Encoder\BearerTokenGenerator;

class GenerateKeysCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('twitter:keys:generate')
            ->setDescription('Generate keys')
            ->setDefinition(
                new InputDefinition([
                    new InputArgument('consumerKey', InputArgument::REQUIRED, 'Enter consumer key'),
                    new InputArgument('consumerSecret', InputArgument::REQUIRED, 'Enter consumer secret'),
                    new InputOption(
                        'test',
                        null,
                        InputOption::VALUE_NONE,
                        'Check generator (with default Twitter example)'
                    )
                ])
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln($input->getArgument('consumerKey'));
        $output->writeln($input->getArgument('consumerSecret'));
        $output->writeln($input->getOption('test'));

        $consumerKey = $input->getArgument('consumerKey');
        $consumerSecret = $input->getArgument('consumerSecret');

        $bearerTokenGenerator = new BearerTokenGenerator();
        $encodedBearerToken = $bearerTokenGenerator->get64EncodedBearerTokenCredentials($consumerKey, $consumerSecret);

        $output->writeln('Encoded token: ' . $encodedBearerToken);

        if ($input->getOption('test')) {
            $output->writeln('Encoder test result: ' . (int)$bearerTokenGenerator->getSelfDebugResult());
        }
    }
}