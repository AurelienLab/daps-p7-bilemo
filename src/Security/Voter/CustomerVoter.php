<?php

namespace App\Security\Voter;

use App\Entity\Customer;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class CustomerVoter extends Voter
{


    public const MANAGE_USERS = 'CUSTOMER_MANAGE_USERS';
    public const SHOW_CUSTOMER = 'CUSTOMER_SHOW_CUSTOMER';


    public function __construct(private Security $security)
    {
    }


    protected function supports(string $attribute, mixed $subject): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [self::MANAGE_USERS, self::SHOW_CUSTOMER])
            && $subject instanceof Customer;
    }


    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {

        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }


        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case self::MANAGE_USERS:
                return $user == $subject || $this->security->isGranted('ROLE_ADMIN');
            case self::SHOW_CUSTOMER:
                return $user == $subject || $this->security->isGranted('ROLE_ADMIN');
        }

        return false;
    }


}
