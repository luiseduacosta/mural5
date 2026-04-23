<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class AlterUsersRoleEnum extends BaseMigration
{
    /**
     * Change the `role` enum from 'docente' to 'professor' to match categoria values.
     *
     * @return void
     */
    public function change(): void
    {
        $this->execute("ALTER TABLE `users` CHANGE `role` `role` ENUM('admin','supervisor','professor','aluno') DEFAULT 'aluno'");
    }
}
