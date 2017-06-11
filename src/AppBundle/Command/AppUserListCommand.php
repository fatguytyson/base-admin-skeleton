<?php

namespace AppBundle\Command;

use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class AppUserListCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:user:list')
            ->setDescription('Lists users and status.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine.orm.default_entity_manager');
        $users = $em->getRepository('AppBundle:User')->findAll();

        $table = new Table($output);
        $table->setHeaders(['Username','Email','Enabled']);
        /** @var User $user */
        foreach ($users as $user)
            $table->addRow([$user->getUsername(), $user->getEmail(), $user->isEnabled()?'Enabled':'Disabled']);
        $table->render();
    }
}
