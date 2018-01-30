<?php

namespace AppBundle\Command;

use AppBundle\Util\UserManager;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

class AppUserResetPasswordCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:user:reset-password')
            ->setDescription('Resets the password for a user.')
            ->addArgument('username', InputArgument::REQUIRED, 'Username to reset.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $username = $input->getArgument('username');

        $qhelper = $this->getHelper('question');
        $um = $this->getContainer()->get(UserManager::class);
        $user = $um->findUserByUsernameOrEmail($username);

        if ($user) {
            $question = new Question('Enter a Password: ', null);
            $question->setValidator(function ($value) {
                if (strlen($value) < 8) {
                    throw new \RuntimeException(
                        'Come on, make you password longer.'
                    );
                }
                return $value;
            });
            $question->setMaxAttempts('10');
            $question->setHidden(true);
            $question->setHiddenFallback(false);
            $password = $qhelper->ask($input, $output, $question);

            $user->setPlainPassword($password);
            $um->updateUser($user);
            $output->writeln('Password reset.');
            return;
        }

        $output->writeln('No user found.');
    }

}
