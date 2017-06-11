<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class AppUserToggleActiveCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:user:toggle-active')
            ->setDescription('Toggles a users active status.')
            ->addArgument('username', InputArgument::REQUIRED, 'Username to toggle.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $username = $input->getArgument('username');

        $em = $this->getContainer()->get('doctrine.orm.default_entity_manager');
        $user = $em->getRepository('AppBundle:User')->findOneByUsername($username);

        if ($user) {
            $user->setIsActive(!$user->isActive());
            $em->flush();
            $output->writeln('User Toggled.');
            return;
        }

        $output->writeln('No user found.');
    }

}
