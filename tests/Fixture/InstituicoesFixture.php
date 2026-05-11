<?php

declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

class InstituicoesFixture extends TestFixture
{
    public $fields = [
        'id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'area_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'natureza' => ['type' => 'string', 'length' => 50, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'instituicao' => ['type' => 'string', 'length' => 120, 'null' => false, 'default' => '', 'comment' => '', 'precision' => null],
        'cnpj' => ['type' => 'string', 'length' => 18, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'email' => ['type' => 'string', 'length' => 90, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'url' => ['type' => 'string', 'length' => 100, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'endereco' => ['type' => 'string', 'length' => 105, 'null' => false, 'default' => '', 'comment' => '', 'precision' => null],
        'bairro' => ['type' => 'string', 'length' => 30, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'municipio' => ['type' => 'string', 'length' => 30, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'cep' => ['type' => 'string', 'length' => 9, 'null' => false, 'default' => '', 'comment' => '', 'precision' => null],
        'telefone' => ['type' => 'string', 'length' => 50, 'null' => false, 'default' => '', 'comment' => '', 'precision' => null],
        'beneficio' => ['type' => 'string', 'length' => 50, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'fim_de_semana' => ['type' => 'string', 'length' => 1, 'null' => true, 'default' => '0', 'comment' => '', 'precision' => null],
        'convenio' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'expira' => ['type' => 'date', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'seguro' => ['type' => 'string', 'length' => 1, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'observacoes' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'estagiario_count' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => true, 'default' => '0', 'comment' => '', 'precision' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
        ],
    ];

    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'area_id' => 1,
                'natureza' => 'Pública',
                'instituicao' => 'Hospital Universitário',
                'cnpj' => '12.345.678/0001-90',
                'email' => 'contato@hu.ufrj.br',
                'url' => 'https://hu.ufrj.br',
                'endereco' => 'Av. Brigadeiro Trompowski s/n',
                'bairro' => 'Cidade Universitária',
                'municipio' => 'Rio de Janeiro',
                'cep' => '21941-590',
                'telefone' => '(21) 3938-1000',
                'beneficio' => 'VT',
                'fim_de_semana' => '0',
                'convenio' => 1,
                'expira' => '2026-12-31',
                'seguro' => '1',
                'observacoes' => 'Convênio ativo',
                'estagiario_count' => 0,
            ],
            [
                'id' => 2,
                'area_id' => 2,
                'natureza' => 'Privada',
                'instituicao' => 'Empresa de Tecnologia Ltda',
                'cnpj' => '98.765.432/0001-10',
                'email' => 'rh@tecltda.com.br',
                'url' => 'https://tecltda.com.br',
                'endereco' => 'Rua da Tecnologia, 500',
                'bairro' => 'Centro',
                'municipio' => 'Rio de Janeiro',
                'cep' => '20040-010',
                'telefone' => '(21) 3333-4444',
                'beneficio' => 'VR',
                'fim_de_semana' => '1',
                'convenio' => 1,
                'expira' => '2027-06-30',
                'seguro' => '0',
                'observacoes' => null,
                'estagiario_count' => 0,
            ],
        ];
        parent::init();
    }
}
