<?php

namespace AppBundle\Command;

use AppBundle\Util\UserManager;
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

        $um = $this->getContainer()->get(UserManager::class);
        $user = $um->findUserByUsernameOrEmail($username);

        if ($user) {
            $user->setEnabled(!$user->isEnabled());
            $um->updateUser($user);
            $output->writeln('User Toggled.');
            $output->writeln($user->getUsername() . ' now ' . ($user->isEnabled() ? 'Active' : 'Inactive'));
            return;
        }

        $output->writeln('No user found.');
    }

}
