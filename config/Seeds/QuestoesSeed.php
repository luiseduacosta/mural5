<?php
declare(strict_types=1);

use Faker\Factory as FakerFactory;
use Migrations\BaseSeed;

class QuestoesSeed extends BaseSeed
{
    public function getDependencies(): array
    {
        return [
            QuestionariosSeed::class,
        ];
    }

    public function run(): void
    {
        if (!$this->hasTable('questoes') || !$this->hasTable('questionarios')) {
            return;
        }

        $count = (int)($this->fetchRow('SELECT COUNT(*) AS total FROM questoes')['total'] ?? 0);
        if ($count > 0) {
            return;
        }

        $questionarios = $this->fetchAll('SELECT id FROM questionarios ORDER BY id ASC');
        if (!$questionarios) {
            return;
        }
        $questionarioIds = array_map(static fn (array $r): int => (int)$r['id'], $questionarios);

        $faker = FakerFactory::create('pt_BR');
        $now = (new DateTimeImmutable('now'))->format('Y-m-d H:i:s');

        $rows = [];

        $ordem = 1;
        $rows[] = [
            'questionario_id' => 1,
            'text' => 'Como você avalia o estágio de forma geral?',
            'type' => 'select',
            'options' => json_encode(['1' => 'Ruim', '2' => 'Regular', '3' => 'Bom', '4' => 'Ótimo'], JSON_UNESCAPED_UNICODE),
            'created' => $now,
            'modified' => $now,
            'ordem' => $ordem++,
        ];
        $rows[] = [
            'questionario_id' => 1,
            'text' => 'O campo de estágio oferece condições adequadas?',
            'type' => 'boolean',
            'options' => json_encode(['0' => 'Não', '1' => 'Sim'], JSON_UNESCAPED_UNICODE),
            'created' => $now,
            'modified' => $now,
            'ordem' => $ordem++,
        ];
        $rows[] = [
            'questionario_id' => 1,
            'text' => 'Descreva as principais atividades realizadas.',
            'type' => 'textarea',
            'options' => '',
            'created' => $now,
            'modified' => $now,
            'ordem' => $ordem++,
        ];

        $ordem = 1;
        $rows[] = [
            'questionario_id' => 2,
            'text' => 'O supervisor orienta adequadamente as atividades?',
            'type' => 'radio',
            'options' => json_encode(['1' => 'Nunca', '2' => 'Às vezes', '3' => 'Frequentemente', '4' => 'Sempre'], JSON_UNESCAPED_UNICODE),
            'created' => $now,
            'modified' => $now,
            'ordem' => $ordem++,
        ];
        $rows[] = [
            'questionario_id' => 2,
            'text' => 'Quais pontos podem melhorar na supervisão?',
            'type' => 'text',
            'options' => '',
            'created' => $now,
            'modified' => $now,
            'ordem' => $ordem++,
        ];

        foreach ($questionarioIds as $questionarioId) {
            $existing = array_filter($rows, static fn (array $r): bool => (int)$r['questionario_id'] === $questionarioId);
            if (count($existing) >= 5) {
                continue;
            }

            $ordem = 1;
            $questionsToAdd = $faker->numberBetween(3, 6);
            for ($i = 0; $i < $questionsToAdd; $i++) {
                $type = $faker->randomElement(['text', 'textarea', 'select', 'radio', 'checkbox', 'boolean']);

                $options = '';
                if (in_array($type, ['select', 'radio', 'checkbox'], true)) {
                    $optCount = $faker->numberBetween(3, 5);
                    $opts = [];
                    for ($o = 1; $o <= $optCount; $o++) {
                        $opts[(string)$o] = $faker->words(3, true);
                    }
                    $options = json_encode($opts, JSON_UNESCAPED_UNICODE);
                } elseif ($type === 'boolean') {
                    $options = json_encode(['0' => 'Não', '1' => 'Sim'], JSON_UNESCAPED_UNICODE);
                }

                $rows[] = [
                    'questionario_id' => $questionarioId,
                    'text' => $faker->sentence(10),
                    'type' => $type,
                    'options' => $options,
                    'created' => $now,
                    'modified' => $now,
                    'ordem' => $ordem++,
                ];
            }
        }

        $this->insert('questoes', $rows);
    }
}
