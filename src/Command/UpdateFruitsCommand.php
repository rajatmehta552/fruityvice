<?php

// src/Command/UpdateFruitsCommand.php

namespace App\Command;

use App\Services\FruitService;
use App\Entity\Fruit;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Message;

class UpdateFruitsCommand extends Command
{
    protected static $defaultName = 'app:update-fruits';
    protected static $defaultDescription = 'Update fruits from https://fruityvice.com/ and save them to database';

    private $fruitService;
    private $entityManager;
    private $mailer;

    public function __construct(FruitService $fruitService, EntityManagerInterface $entityManager, MailerInterface $mailer)
    {
        $this->fruitService = $fruitService;
        $this->entityManager = $entityManager;
        $this->mailer = $mailer;
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $fruits = $this->fruitService->getAllFruits();

        foreach ($fruits as $fruitData) {
            $fruit = $this->entityManager->getRepository(Fruit::class)->findOneBy([
                'name' => $fruitData['name'],
            ]);
            if (!$fruit) {

                $fruit = new Fruit();
                $fruit->setName($fruitData['name']);
                $fruit->setFamily($fruitData['family']);
                $fruit->setCalories($fruitData['nutritions']['calories']);
                $fruit->setFat($fruitData['nutritions']['fat']);
                $fruit->setCarbohydrates($fruitData['nutritions']['carbohydrates']);
                $fruit->setProtein($fruitData['nutritions']['protein']);
                $this->entityManager->persist($fruit);
            }
        }
        $this->entityManager->flush();

        // Send email to dummy admin email

        $message = new TemplatedEmail();
        $message->subject('New fruits added');
        $message->to(new Address('test@yopmail.com'));
        $message->from('admin@yopmail.com');
        $message->htmlTemplate('emails/new_fruits_added.html.twig');
        $message->context([
            'fruits' => $fruits,
        ]);

        $this->mailer->send($message);


        $io->success('Emails Sent');

        return 1;
    }
}
