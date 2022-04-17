<?php

namespace App\Interfaces\Models;

interface UserInterface extends BaseModelInterface
{
    const TABLE = 'users';
    const FIRST_NAME = 'first_name';
    const LAST_NAME = 'last_name';
    const EMAIL = 'email';
    const PASSWORD = 'password';
    const EMAIL_VERIFIED_AT = 'email_verified_at';
    const ROLE = 'role';

    const ROLE_ADMIN = 'admin';
    const ROLE_CUSTOMER = 'customer';
    const ROLE_RESTAURANT = 'restaurant';
    const ROLE_DELIVERY = 'delivery';
    const ROLES = [self::ROLE_ADMIN, self::ROLE_CUSTOMER, self::ROLE_RESTAURANT, self::ROLE_DELIVERY,];
}
