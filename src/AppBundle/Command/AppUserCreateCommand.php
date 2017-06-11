<?php

namespace AppBundle\Command;

use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

class AppUserCreateCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:user:create')
            ->setDescription('Creates a User.')
            ->addOption('username', 'u', InputOption::VALUE_OPTIONAL, 'Username for the new user.')
            ->addOption('email', 'm', InputOption::VALUE_OPTIONAL, 'Email for the new user.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $qhelper = $this->getHelper('question');

        $username = $input->getOption('username');
        $question = new Question('Enter a Username: '.($username?"[$username]":''), $username);
        $question->setNormalizer(function ($value) {
            return $value?trim($value):'';
        });
        $question->setValidator(function ($value) {
            if (!preg_match('/^[a-z0-9_]{3,20}$/i', $value)) {
                throw new \RuntimeException(
                    'Username consists of a-z, 0-9, underscores (_), and from 3 to 20 characters long'
                );
            }
            return $value;
        });
        $question->setMaxAttempts('10');
        $username = $qhelper->ask($input, $output, $question);

        $email = $input->getOption('email');
        $question = new Question('Enter an Email: '.($email?"[$email]":''), $email);
        $question->setNormalizer(function ($value) {
            return $value?trim($value):'';
        });
        $question->setValidator(function ($value) {
            if (!preg_match('/^([a-z0-9_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$/i', $value)) {
                throw new \RuntimeException(
                    'This is not a valid email'
                );
            }
            return $value;
        });
        $question->setMaxAttempts('10');
        $email = $qhelper->ask($input, $output, $question);

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

        $em = $this->getContainer()->get('doctrine.orm.default_entity_manager');
        $user = new User();
        $user->setUsername($username)->setEmail($email)->setIsActive(true)->setPassword(password_hash($password, PASSWORD_BCRYPT, ['cost' => 13]));
        $em->persist($user);
        $em->flush();
        $output->writeln('User Created!');
    }

}
