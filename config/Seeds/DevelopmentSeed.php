<?php
declare(strict_types=1);

use Migrations\BaseSeed;

class DevelopmentSeed extends BaseSeed
{
    public function run(): void
    {
        $options = ['source' => 'Seeds'];

        $this->call(ConfiguracoesSeed::class, $options);
        $this->call(AreasSeed::class, $options);
        $this->call(InstituicoesSeed::class, $options);
        $this->call(MuralestagiosSeed::class, $options);
        $this->call(VisitasSeed::class, $options);
    }
}
