<?php
declare(strict_types=1);

use Faker\Factory as FakerFactory;
use Migrations\BaseSeed;

class FolhadeatividadesSeed extends BaseSeed
{
    public function getDependencies(): array
    {
        return [
            EstagiariosSeed::class,
        ];
    }

    public function run(): void
    {
        if (!$this->hasTable('folhadeatividades') || !$this->hasTable('estagiarios')) {
            return;
        }

        $count = (int)($this->fetchRow('SELECT COUNT(*) AS total FROM folhadeatividades')['total'] ?? 0);
        if ($count > 0) {
            return;
        }

        $estagiarios = $this->fetchAll('SELECT id FROM estagiarios ORDER BY id ASC LIMIT 80');
        if (!$estagiarios) {
            return;
        }
        $estagiarioIds = array_map(static fn (array $r): int => (int)$r['id'], $estagiarios);

        $faker = FakerFactory::create('pt_BR');

        $atividades = [
            'Atendimento e acolhimento de usuários',
            'Levantamento de informações sociais',
            'Reunião de equipe e discussão de caso',
            'Registro em prontuário e relatórios',
            'Visita institucional',
            'Encaminhamentos e orientações',
            'Acompanhamento de atividades do setor',
        ];

        $rows = [];
        foreach ($estagiarioIds as $estagiarioId) {
            $dias = $faker->numberBetween(2, 5);
            for ($d = 0; $d < $dias; $d++) {
                $dia = $faker->dateTimeBetween('-60 days', '-1 day')->format('Y-m-d');

                $entries = $faker->numberBetween(1, 3);
                $startHour = $faker->randomElement([8, 9, 10, 13, 14, 15]);
                for ($e = 0; $e < $entries; $e++) {
                    $inicio = sprintf('%02d:%02d:00', $startHour, $faker->randomElement([0, 15, 30, 45]));
                    $durationHours = $faker->randomElement([1, 2]);
                    $finalHour = min(23, $startHour + $durationHours);
                    $final = sprintf('%02d:%02d:00', $finalHour, $faker->randomElement([0, 15, 30, 45]));

                    $rows[] = [
                        'estagiario_id' => $estagiarioId,
                        'dia' => $dia,
                        'inicio' => $inicio,
                        'final' => $final,
                        'atividade' => $faker->randomElement($atividades),
                    ];

                    $startHour = $finalHour;
                }
            }
        }

        $this->insert('folhadeatividades', $rows);
    }
}
