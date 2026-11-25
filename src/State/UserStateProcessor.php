<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\User;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserStateProcessor implements ProcessorInterface
{
    private UserPasswordHasherInterface $hasher;
    private ProcessorInterface $persister;
    
    public function __construct(
        UserPasswordHasherInterface $pwdHasher,
        #[Autowire(service: "api_platform.doctrine.orm.state.persist_processor")]
        ProcessorInterface $processorInterface
    )
    {
        $this->hasher = $pwdHasher;
        $this->persister = $processorInterface;
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): void
    {
        if ($data instanceof User) {
            $hashedPassword = $this->hasher->hashPassword($data, $data->getPassword());
            $data->setPassword($hashedPassword);
            $this->persister->process($data, $operation, $uriVariables, $context);
        }
    }
}
