<?php
declare(strict_types=1);

use Faker\Factory as FakerFactory;
use Migrations\BaseSeed;

class RespostasSeed extends BaseSeed
{
    public function getDependencies(): array
    {
        return [
            QuestionariosSeed::class,
            QuestoesSeed::class,
            EstagiariosSeed::class,
        ];
    }

    public function run(): void
    {
        if (
            !$this->hasTable('respostas')
            || !$this->hasTable('questoes')
            || !$this->hasTable('questionarios')
            || !$this->hasTable('estagiarios')
        ) {
            return;
        }

        $count = (int)($this->fetchRow('SELECT COUNT(*) AS total FROM respostas')['total'] ?? 0);
        if ($count > 0) {
            return;
        }

        $questionarioId = 1;

        $questoes = $this->fetchAll('SELECT id, text, type, options FROM questoes WHERE questionario_id = ' . $questionarioId . ' ORDER BY ordem ASC');
        if (!$questoes) {
            return;
        }

        $estagiarios = $this->fetchAll('SELECT id FROM estagiarios ORDER BY id ASC LIMIT 120');
        if (!$estagiarios) {
            return;
        }

        $faker = FakerFactory::create('pt_BR');
        $now = (new DateTimeImmutable('now'))->format('Y-m-d H:i:s');

        $rows = [];
        foreach ($estagiarios as $estagiario) {
            $response = [];

            foreach ($questoes as $questao) {
                $key = 'avaliacao' . (int)$questao['id'];
                $type = (string)$questao['type'];
                $text = (string)$questao['text'];
                $options = (string)($questao['options'] ?? '');

                $valor = null;
                $textoValor = null;

                if (in_array($type, ['select', 'radio', 'checkbox', 'boolean'], true)) {
                    $opcoes = json_decode($options, true);
                    if ($type === 'boolean') {
                        $opcoes = ['0' => 'Não', '1' => 'Sim'];
                    }
                    if (is_array($opcoes) && $opcoes) {
                        $keys = array_keys($opcoes);
                        $valor = (string)$faker->randomElement($keys);
                        $textoValor = (string)($opcoes[$valor] ?? $valor);
                    } else {
                        $valor = '1';
                        $textoValor = '1';
                    }
                } elseif ($type === 'textarea') {
                    $valor = $faker->paragraph();
                    $textoValor = $valor;
                } else {
                    $valor = $faker->sentence(8);
                    $textoValor = $valor;
                }

                $response[$key] = [
                    'pergunta' => $text,
                    'valor' => $valor,
                    'texto_valor' => $textoValor,
                ];
            }

            $rows[] = [
                'questionario_id' => $questionarioId,
                'estagiario_id' => (int)$estagiario['id'],
                'response' => json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE),
                'created' => $now,
                'modified' => $now,
            ];
        }

        $this->insert('respostas', $rows);
    }
}
