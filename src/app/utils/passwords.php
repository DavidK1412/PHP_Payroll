<?php

    const FIXED_SALT = '68_0zVWFrS72GbpRiptideidkQFLfj4v9m3Ti+HighTCS=';
    const FIXED_HASH = 'SHA256';

    function encryptPassword($password): string {
        return hash(FIXED_HASH, $password . FIXED_SALT);
    }

    function validatePassword($password, $hashedPassword): bool {
        $hashedPasswordToCheck = encryptPassword($password);
        if ($hashedPasswordToCheck === $hashedPassword) {
            return true;
        }
        return false;
    }

?>