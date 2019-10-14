<?php

namespace Ocd\SoapMakerBundle\Maker;

use Symfony\Bundle\MakerBundle\Maker\AbstractMaker;

/**
 * MakeSoapClass
 * 
 */
final class MakeSoapClass extends AbstractMaker
{
    public static function getCommandName(): string
    {
        return 'make:soap:class';
    }

    public function configureCommand(Command $command, InputConfiguration $inputConf)
    {
        $command
            ->setDescription('Creates a new soap class')
            ->addArgument('wsdl', InputArgument::VALUE_REQUIRED, 'The wsdl file/uri')
            ->addArgument('name', InputArgument::VALUE_REQUIRED, 'The service name')
            ->addArgument('namespace', InputArgument::VALUE_REQUIRED, 'The classes namespace')
            ->setHelp(file_get_contents(__DIR__.'/../Resources/help/MakeSoapClass.txt'))
        ;
    }

    public function interact(InputInterface $input, ConsoleStyle $io, Command $command)
    {

        $io->title('Soap Classes Generation');
        $io->text([
            'If you prefer to not use this interactive wizard, provide the',
            'arguments required by this command as follows:',
            '',
            ' $ php bin/console make:soap:class wsdl name namespace',
            '',
            'Now we\'ll ask you for the value of all the missing command arguments.',
        ]);

        // Ask for the wsdl if it's not defined
        $wsdl = $input->getArgument('wsdl');
        if (null !== $wsdl) {
            $io->text(' > <info>wsdl</info>: '.$wsdl);
        } else {
            $wsdl = $io->ask('WSDL file/uri', null, []);
            $input->setArgument('wsdl', $wsdl);
        }
    }

    public function generate(InputInterface $input, ConsoleStyle $io, Generator $generator)
    {
        $serviceClassNameDetails = $generator->createClassNameDetails(
            $input->getArgument('name'),
            $input->getArgument('namespace'),
            '\\SoapClient'
        );

        $generator->generateClass(
            $serviceClassNameDetails->getFullName(),
            'soap/Service.tpl.php',
            []
        );

        $generator->writeChanges();

        $this->writeSuccessMessage($io);

        $io->text([
            'Generation done.',
            '',
        ]);
    }

    public function configureDependencies(DependencyBuilder $dependencies)
    {
        // $dependencies->addClassDependency(
        //     Voter::class,
        //     'security'
        // );
    }

}