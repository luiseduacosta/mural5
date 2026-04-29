<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Instituicao Entity
 *
 * @property int $id
 * @property string $instituicao
 * @property int|null $area_id
 * @property string|null $natureza
 * @property string $cnpj
 * @property string $email
 * @property string|null $url
 * @property string $endereco
 * @property string $bairro
 * @property string $municipio
 * @property string $cep
 * @property string $telefone
 * @property string|null $beneficio
 * @property string|null $fim_de_semana
 * @property string $local_inscricao
 * @property int $convenio
 * @property int|null $expira
 * @property string|null $seguro
 * @property string|null $observacoes
 * @property int|null $estagiario_count
 *
 * @property \App\Model\Entity\Area $area
 * @property \App\Model\Entity\Estagiario[] $estagiarios
 * @property \App\Model\Entity\Muralestagio[] $muralestagios
 * @property \App\Model\Entity\Visita[] $visitas
 * @property \App\Model\Entity\Supervisor[] $supervisores
 */
class Instituicao extends Entity
{
    protected array $_accessible = [
        'instituicao' => true,
        'area_id' => true,
        'natureza' => true,
        'cnpj' => true,
        'email' => true,
        'url' => true,
        'endereco' => true,
        'bairro' => true,
        'municipio' => true,
        'cep' => true,
        'telefone' => true,
        'beneficio' => true,
        'fim_de_semana' => true,
        'convenio' => true,
        'expira' => true,
        'seguro' => true,
        'observacoes' => true,
        'estagiario_count' => true,
        'area' => true,
        'estagiarios' => true,
        'muralestagios' => true,
        'visitas' => true,
        'supervisores' => true,
    ];
}
