<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class BackfillAdministradores extends BaseMigration
{
    public function up(): void
    {
        $this->execute(
            "INSERT INTO administradores (nome, user_id)
             SELECT COALESCE(NULLIF(u.email, ''), CONCAT('Administrador ', u.id)), u.id
             FROM users u
             LEFT JOIN administradores a ON a.user_id = u.id
             WHERE u.categoria = '1' AND a.id IS NULL"
        );
    }

    public function down(): void
    {
        $this->execute(
            "DELETE a FROM administradores a
             INNER JOIN users u ON u.id = a.user_id
             WHERE u.categoria = '1'"
        );
    }
}
