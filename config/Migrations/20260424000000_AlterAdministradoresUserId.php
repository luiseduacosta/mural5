<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class AlterAdministradoresUserId extends BaseMigration
{
    public function change(): void
    {
        $this->execute('ALTER TABLE `administradores` MODIFY `user_id` INT(11) NULL DEFAULT NULL');
    }
}

