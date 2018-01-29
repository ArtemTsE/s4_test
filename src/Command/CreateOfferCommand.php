<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateOfferCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('app:create-offer-api')
            ->setDescription('Creates an Offer using API.')
            ->setHelp('This command allows you to create an Offer using API')
        ;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute(
        InputInterface $input,
        OutputInterface $output
    ) {
        $output->writeln('Creating an offer...');

        $options = [
            CURLOPT_URL => 'http://www.symfony4_test.local/api/offer',
        ];

        $curl_wrapper = $this
            ->getApplication()
            ->getKernel()
            ->getContainer()
            ->get('metaer_curl_wrapper.curl_wrapper');

        try {
            $curl_wrapper->getQueryResult($options);
        } catch (CurlWrapperException $e) {
        }
    }
}