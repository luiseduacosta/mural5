<?php
declare(strict_types=1);

use Migrations\BaseSeed;

class DevelopmentSeed extends BaseSeed
{
    public function run(): void
    {
        $options = ['source' => 'Seeds'];

        $this->call(TurnosSeed::class, $options);
        $this->call(TurmasSeed::class, $options);
        $this->call(ComplementosSeed::class, $options);
        $this->call(CategoriasSeed::class, $options);
        $this->call(UsersSeed::class, $options);
        $this->call(AdministradoresSeed::class, $options);
        $this->call(AlunosSeed::class, $options);
        $this->call(ConfiguracoesSeed::class, $options);
        $this->call(AreasSeed::class, $options);
        $this->call(InstituicoesSeed::class, $options);
        $this->call(ProfessoresSeed::class, $options);
        $this->call(SupervisoresSeed::class, $options);
        $this->call(InstSuperSeed::class, $options);
        $this->call(EstagiariosSeed::class, $options);
        $this->call(QuestionariosSeed::class, $options);
        $this->call(QuestoesSeed::class, $options);
        $this->call(RespostasSeed::class, $options);
        $this->call(AvaliacoesSeed::class, $options);
        $this->call(FolhadeatividadesSeed::class, $options);
        $this->call(MuralestagiosSeed::class, $options);
        $this->call(VisitasSeed::class, $options);
        $this->call(InscricoesSeed::class, $options);
    }
}
