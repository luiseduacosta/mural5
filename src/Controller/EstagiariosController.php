<?php

declare(strict_types=1);

namespace App\Controller;

/**
 * Estagiarios Controller
 *
 * @property \App\Model\Table\EstagiariosTable $Estagiarios
 * @method \App\Model\Entity\Estagiario[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class EstagiariosController extends AppController
{

    public function initialize(): void
    {
        parent::initialize();
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index($id = NULL)
    {

        $periodo = $this->getRequest()->getQuery('periodo');

        if (empty($periodo)) {
            $configuracao = $this->fetchTable('Configuracoes');
            $configuracoes = $configuracao->find()->select(['mural_periodo_atual'])->first();
            $periodo = $configuracoes->mural_periodo_atual;
        }

        if ($periodo) {
            $query = $this->Estagiarios->find('all')
                ->where(['Estagiarios.periodo' => $periodo])
                ->contain(['Alunos', 'Professores', 'Supervisores', 'Instituicoes', 'Turmaestagios']);
        } else {
            $query = $this->Estagiarios->find('all')
                ->contain(['Alunos', 'Professores', 'Supervisores', 'Instituicoes', 'Turmaestagios']);
        }
        $config = $this->paginate = ['sortableFields' => ['id', 'Alunos.nome', 'registro', 'turno', 'nivel', 'Instituicoes.instituicao', 'Supervisores.nome', 'Professores.nome']];
        $estagiarios = $this->paginate($query, $config);

        /* Todos os periódos */
        $periodototal = $this->Estagiarios->find('list', [
            'keyField' => 'periodo',
            'valueField' => 'periodo',
            'order' => 'periodo'
        ]);
        $periodos = $periodototal->toArray();

        $this->set(compact('estagiarios', 'periodo', 'periodos'));
    }

    /**
     * View method
     *
     * @param string|null $id Estagiario id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {

        if ($id == null) {
            $this->Flash->error(__('Nao ha registros de estagiarios para esse numero!'));
            return $this->redirect(['action' => 'index']);
        }

        $estagiario = $this->Estagiarios->find()
            ->contain(['Alunos', 'Instituicoes', 'Supervisores', 'Professores', 'Turmaestagios', 'Folhadeatividades', 'Avaliacoes'])
            ->where(['Estagiarios.id' => $id])
            ->first();

        if (!isset($estagiario)) {
            $this->Flash->error(__('Nao ha registros de estagiarios para esse numero!'));
            return $this->redirect(['action' => 'index']);
        }

        $this->set(compact('estagiario'));
    }

    /**
     * Add method
     *
     * Os estagiarios sao adicionados por meio do Termodecompromisso.
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {

        /** Capturo o id do aluno se estiver cadastrado e envio para o formulario. */
        $aluno_id = $this->Authentication->getIdentityData('aluno_id');
        if ($aluno_id) {
            $alunotabela = $this->fetchTable('Alunos');
            $alunoestagiarios = $alunotabela->find()
                ->contain(['Estagiarios' => ['sort' => ['nivel' => 'desc']]])
                ->where(['id' => $aluno_id])
                ->first();
            if (isset($alunoestagiarios)) {
                foreach ($alunoestagiarios->estagiarios as $alunoestagiario) {
                    $alunoDeEstagio[] = $alunoestagiario;
                }
            } else {
                $alunoDeEstagio[] = 'Sem alunos';
            }

            $this->set('aluno_id', $aluno_id);
            $this->set('estudanteestagiarios', $alunoestagiarios);
            $this->set('estudantedeestagio', $alunoDeEstagio[0]);
        }

        $estagiario = $this->Estagiarios->newEmptyEntity();

        $configuracao = $this->fetchTable('Configuracoes');
        $periodo_atual = $configuracao->find()->select(['mural_periodo_atual'])->first();
        $periodo = $periodo_atual->mural_periodo_atual;

        if ($this->request->is('post')) {
            $estagiario = $this->Estagiarios->patchEntity($estagiario, $this->request->getData());
            if ($this->Estagiarios->save($estagiario)) {
                $this->Flash->success(__('Registro de estagiario inserido.'));
                return $this->redirect(['action' => 'view', $estagiario->id]);
            }
            $this->Flash->error(__('Registro de estagiário não foi inserido. Tente novamente.'));
        }
        $alunos = $this->Estagiarios->Alunos->find('list');
        $instituicoes = $this->Estagiarios->Instituicoes->find('list');
        $supervisores = $this->Estagiarios->Supervisores->find('list');
        $professores = $this->Estagiarios->Professores->find('list');
        $turmaestagios = $this->Estagiarios->Turmaestagios->find('list');
        $this->set(compact('periodo', 'estagiario', 'alunos', 'instituicoes', 'supervisores', 'professores', 'turmaestagios'));
    }

    /**
     * termodecompromisso method
     * There three situations in this function:
     * 1. If the student is not a estagiario then create a new record with the nivel 1.
     * 2. If the student is a estagiario then check the periodo from the Configuracoes table and if it is the same update the record or if it is different create a new record.
     * 3. Finaly define which is the next nivel of the estagiario. May be the same nivel if it is a update. If it is a new record then the nivel is the next of the last record of the estagiario. But there is a max nivel defined from the value of the field ajuste2020, that can be 3 if ajuste2020 is 1 or 4 if ajuste2020 is 0. When the student reach the max nivel (3 or 4) then the next nivel is always 9.
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     *
     */
    public function termodecompromisso($id = NULL)
    {
        /** Vou utilizar a tabela configurações */
        $configuracaotabela = $this->fetchTable('Configuracoes');
        $configuracoes = $configuracaotabela->find()->select(['mural_periodo_atual'])->first();
        $periodoatual = $configuracoes->mural_periodo_atual;

        /** Vou utilizar a tabela estagiarios */
        $estagiariotabela = $this->fetchTable('Estagiarios');

        // Administrador pode inserir o termo de compromisso para qualquer aluno
        if ($this->Authentication->getIdentityData('categoria_id') == '1') {
            $aluno_id = $this->getRequest()->getQuery('aluno_id');
        } else {
            $aluno_id = $this->Authentication->getIdentityData('aluno_id');
        }

        /** Sem aluno não tem como continuar */
        if (empty($aluno_id)) {
            $this->Flash->error(__('Nao ha registros de estagiarios para esse numero!'));
            return $this->redirect(['action' => 'index']);
        }

        /** Busco se ha algum registo de estagiario para esse aluno */
        $estagiariotabela = $this->fetchTable('Estagiarios');
        $estagiario = $estagiariotabela->find()->where(['aluno_id' => $aluno_id])->first();

        /** Se não tem estagiário cadastra novo estagiário com o nivel 1 */
        if (empty($estagiario)) {
            $this->Flash->info(__('Cadastre o estagiário nível I.'));
        }

        /** This cames from the url query string. It can be obtained from the select form. */
        $instituicao_id = $this->getRequest()->getQuery('instituicao_id');

        /** Vou utilizar a tabela instituicoes to the select options form to pick the instituicao_id */
        $instituicaotabela = $this->fetchTable('Instituicoes');

        /** Vou utilizar a tabela supervisores to select the supervisor of the selected instituicao */
        $supervisortabela = $this->fetchTable('Supervisores');

        /** Vou utilizar a tabela professores to select one professor. */
        $professortabela = $this->fetchTable('Professores');

        /** Vou utilizar a tabela turmaestagios */
        $turmaestagiotabela = $this->fetchTable('Turmaestagios');

        if ($this->getRequest()->is('post')) {

            /** Gets the data from the form to update or insert a new record */
            $dados = $this->getRequest()->getData();

            /** There must be an institution */
            if (empty($dados['instituicao_id'])) {
                $this->Flash->error(__('Selecione uma instituição de estágio.'));
                return $this->redirect(['action' => 'termodecompromisso']);
            }

            /** If there is not supervisor selected then the value should be null */
            if (empty($dados['supervisor_id'])) {
                $dados['supervisor_id'] = null;
            }

            /** Verify if it is an existing estagiario the period has to be the same as the current period for an update otherwise it is an insertion */
            $configuracaotabela = $this->fetchTable('Configuracoes');
            $configuracoes = $configuracaotabela->find()->select(['mural_periodo_atual'])->first();
            $periodoatual = $configuracoes->mural_periodo_atual;
            /** Verify the estagiarios periodo */
            $estagiario = $estagiariotabela->find()->where(['aluno_id' => $dados['aluno_id']])->first();
            // Periodoatual is the current period and $estagiario['periodo'] is the period from the form
            if ($estagiario['periodo'] != $periodoatual) {
                // Add a new record to estagiarios  
                $estagiario = $estagiariotabela->newEmptyEntity();
                $estagiario = $estagiariotabela->patchEntity($estagiario, $dados);
                if ($estagiariotabela->save($estagiario)) {
                    $this->Flash->success(__('Estágio inserido.'));
                    return $this->redirect(['action' => 'view', $estagiario->id]);
                }
                $this->Flash->error(__('Estágio não foi inserido. Tente novamente.'));
                return $this->redirect(['action' => 'view', $estagiario->id]);
            } else {
                // Update an existing record
                $estagiario = $estagiariotabela->get($dados['id'], [
                    'contain' => [],
                ]);
                $estagiarioresultado = $estagiariotabela->patchEntity($estagiario, $dados);
                if ($estagiariotabela->save($estagiarioresultado)) {
                    $this->Flash->success(__('Estágio atualizado.'));
                    return $this->redirect(['action' => 'view', $estagiario->id]);
                }
                $this->Flash->error(__('Estágio não foi atualizado. Tente novamente.'));
                return $this->redirect(['action' => 'view', $estagiario->id]);
            }
            $this->Flash->success(__('Estágio criado ou atualizado.'));
            return $this->redirect(['action' => 'view', $estagiario->id]);

        } // Finaliza post

        /** Calculo o periodo atual para estimar o nivel de estágio do Termo de Compromisso. */
        $configuracaotabela = $this->fetchTable('Configuracoes');
        $configuracoes = $configuracaotabela->find()->first();
        $periodoatual = $configuracoes->mural_periodo_atual;
        
        if (!isset($aluno_id)) {
            $this->Flash->error(__('Sem parâmetros para fazer o Termo de Compromisso'));
            return $this->redirect(['controller' => 'Alunos', 'action' => 'index']);
        }
        
        /** Capturo o último estágio do estagiário */
        $ultimoestagio = $estagiariotabela->find()
            ->contain(['Alunos', 'Instituicoes', 'Supervisores'])
            ->where(['Estagiarios.aluno_id' => $aluno_id])
            ->order(['Estagiarios.nivel' => 'desc'])
            ->first();

        /** Nivel do estagiario */
        if ($ultimoestagio) {
           $max_nivel = ($ultimoestagio->ajuste2020 == 1) ? 3 : 4;
            if ($ultimoestagio->periodo != $periodoatual) {
                $nivel = $ultimoestagio->nivel + 1;
                if ($nivel > $max_nivel) {
                    $nivel = 9;
                }
            } else {
                $nivel = $ultimoestagio->nivel;
            }
            $this->set('ultimoestagio', $ultimoestagio);
        } else {
            /** Aluno sem estágio: nível 1 */
            $nivel = 1;
            $estudante_semestagio = $alunotabela->find()
                ->contain([])
                ->where(['Alunos.id' => $aluno_id])
                ->select(['id', 'registro', 'nome', 'turno', 'ingresso'])
                ->first();
            $this->set('estudante_semestagio', $estudante_semestagio);
        }

        $this->set('aluno_id', $aluno_id);
        $this->set('nivel', $nivel);
        $this->set('periodo', $periodoatual);

        /** Seleciona os supervisores da instituição. Primeiro precisa do instituicao_id */
        if (!isset($instituicao_id)) {
            if (isset($ultimoestagio)) {
                $instituicao_id = $ultimoestagio->instituicao->id;
            }
        }
        if (isset($instituicao_id)) {
            $supervisoresinstituicao = $this->selecionasupervisores($instituicao_id);
            if (isset($supervisoresinstituicao)) {
                $this->set('supervisores', $supervisoresinstituicao);
            } else {
                $this->set('supervisores', 'Sem dados');
            }
        }

        $this->set('instituicao_id', $instituicao_id);

        $aluno = $this->fetchTable('Alunos')->find()->where(['Alunos.id' => $aluno_id])->first();
        $instituicoes = $this->fetchTable('Instituicoes')->find('list');
        $turmaestagios = $this->fetchTable('Turmaestagios')->find('list');
        $this->set(compact('instituicoes', 'turmaestagios', 'aluno'));
        if (isset($supervisoresinstituicao)):
            $this->set('supervisoresdainstituicao', $supervisoresinstituicao);
        endif;
    }

    private function selecionasupervisores($instituicao_id = null)
    {
        $supervisoresinstituicao = null;
        if ($instituicao_id) {

            $supervisoresDaInstituicao = $this->fetchTable('Instituicoes')->find()
                ->contain(['Supervisores'])
                ->where(['Instituicoes.id' => $instituicao_id])
                ->first();

            if ($supervisoresDaInstituicao) {

                foreach ($supervisoresDaInstituicao->supervisores as $supervisor) {
                    $supervisoresinstituicao[$supervisor['id']] = $supervisor['nome'];
                }
            } else {
                $supervisoresinstituicao[0] = "Sem supervisor(a)";
                $supervisoresinstituicao[0] = "Sem dados";
            }
        }
        return $supervisoresinstituicao;
    }

    private function nivelestagio($periodoatual, $ultimoestagio)
    {
        if ($periodoatual == $ultimoestagio->periodo) {
            $nivel = $ultimoestagio->nivel;
        } elseif ($periodoatual > $ultimoestagio->periodo) {
            $nivel = $ultimoestagio->nivel + 1;
            $ultimoestagio->ajuste2020 == 0 ? $ultimonivelestagio = 4 : $ultimonivelestagio = 3;
            if ($nivel > $ultimonivelestagio) {
                $nivel = 9;
            }
        } else {
            $this->Flash->error(__("Período de estágio atual não pode ser menor que o último período cursado."));
            return $this->redirect(['action' => 'termodecompromisso', $ultimoestagio->id]);
        }
        return $nivel;
    }

    private function alunoinsere($aluno_id, $estagiario_id)
    {
        $estagiario = $this->Estagiarios->find()->where(['id' => $estagiario_id])->first();
        $alunostabela = $this->fetchTable('Alunoestagiarios');
        $alunoestagiario = $alunostabela->find()->where(['registro' => $estagiario->registro])->first();
        if ($alunoestagiario) {
            $estagiario_entity = $this->Estagiarios->get($estagiario_id);
            $estagiario = $this->Estagiarios->find()->where(['id' => $estagiario_id])->first();
            $dadosinsere = $estagiario->toArray();
            $dadosinsere['aluno_id'] = $alunoestagiario->id;
            $estagiario_aluno_resultado = $this->Estagiarios->patchEntity($estagiario_entity, $dadosinsere);
            if ($this->Estagiarios->save($estagiario_aluno_resultado)) {
                $this->Flash->success(__("Estagiário atualizado"));
            } else {
            }
        } else {
            $alunotabela = $this->fetchTable('Alunos');
            $aluno = $alunotabela->find()
                ->where(['Alunos.id' => $aluno_id])
                ->first()
                ->toArray();
            $aluno_novo = $alunostabela->newEmptyEntity();
            $aluno_novo_resultado = $alunostabela->patchEntity($aluno_novo, $aluno);
            if ($alunostabela->save($aluno_novo_resultado)) {
                $this->Flash->success(__('Aluno inserido'));
                /** Atualizo o aluno_id na tabela estagiarios */
                $estagiario_entity = $this->Estagiarios->get($estagiario_id);
                $estagiario = $this->Estagiarios->find()->where(['id' => $estagiario_id])->first();
                $dadosinsere = $estagiario->toArray();
                $dadosinsere['aluno_id'] = $aluno_novo_resultado->id;
                $estagiario_aluno_resultado = $this->Estagiarios->patchEntity($estagiario_entity, $dadosinsere);
                if ($this->Estagiarios->save($estagiario_aluno_resultado)) {
                    $this->Flash->success(__("Estagiário atualizado"));
                } else {
                }
            } else {
                
            }
        }
        return;
    }

    /**
     * termodecompromissopdf method
     *
     * @param string|null $id Estagiario id. 
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function termodecompromissopdf($id = NULL)
    {

        $this->layout = false;
        if ($id == NULL) {
            $this->Flash->error(__('Nao ha registros de estagiarios para esse numero!'));
            return $this->redirect(['action' => 'index']);
        } else {
            $estagiario = $this->Estagiarios->find()
                ->contain(['Alunos', 'Supervisores', 'Instituicoes'])
                ->where(['Estagiarios.id' => $id])
                ->first();
        }
        $configuracaotabela = $this->fetchTable('Configuracoes');
        $configuracao = $configuracaotabela->get(1);

        $this->viewBuilder()->enableAutoLayout(false);
        $this->viewBuilder()->setClassName('CakePdf.Pdf');
        $this->viewBuilder()->setOption(
            'pdfConfig',
            [
                'orientation' => 'portrait',
                'download' => true,
                'filename' => 'termo_de_compromisso_' . $id . '.pdf'
            ]
        );
        $this->set('configuracao', $configuracao);
        $this->set('estagiario', $estagiario);
    }

    /** Seleciona a declaração de estágio */
    public function selecionadeclaracaodeestagio($id = NULL)
    {

        $id = $this->getRequest()->getSession()->read('estagiario_id');
        if (is_null($id)) {
            $this->Flash->error(__('Selecionar o aluno estagiário'));
            return $this->redirect('/alunos/index');
        } else {
            $estagiario = $this->Estagiarios->find()
                ->contain(['Alunos', 'Supervisores', 'Instituicoes'])
                ->where(['Estagiarios.registro' => $this->getRequest()->getSession()->read('registro')])
                ->first();
        }

        $this->set('estagiario', $estagiario);
    }

    /** Declaração de estágio para ser preenchida manualmente */
    public function declaracaodeestagiopdf($id = NULL)
    {

        $estagiarioquery = $this->Estagiarios->find()
            ->contain(['Alunos', 'Supervisores', 'Instituicoes'])
            ->where(['Estagiarios.id' => $id])
            ->first();

        if (!$estagiarioquery) {
            $this->Flash->error(__('Sem estagio cadastrado.'));
            return $this->redirect(['controller' => 'estagiarios', 'action' => 'view', $id]);
        }

        if (empty($estagiarioquery->aluno->identidade)) {
            $this->Flash->error(__("Aluno sem RG"));
            return $this->redirect('/alunos/view/' . $estagiarioquery->aluno->id);
        }

        if (empty($estagiarioquery->aluno->orgao)) {
            $this->Flash->error(__("Aluno não especifica o orgão emisor do documento"));
            return $this->redirect('/alunos/view/' . $estagiarioquery->aluno->id);
        }
        if (empty($estagiarioquery->aluno->cpf)) {
            $this->Flash->error(__("Aluno sem CPF"));
            return $this->redirect('/alunos/view/' . $estagiarioquery->aluno->id);
        }

        if (empty($estagiarioquery->supervisor->id)) {
            $this->Flash->error(__("Falta o supervisor de estágio"));
            return $this->redirect('/estagiarios/view/' . $estagiarioquery->id);
        }

        $this->viewBuilder()->enableAutoLayout(false);
        $this->viewBuilder()->setClassName('CakePdf.Pdf');
        $this->viewBuilder()->setOption(
            'pdfConfig',
            [
                'orientation' => 'portrait',
                'download' => true, // This can be omitted if "filename" is specified.
                'filename' => 'declaracao_de_estagio_' . $id . '.pdf' //// This can be omitted if you want file name based on URL.
            ]
        );
        $this->set('estagiario', $estagiarioquery);
    }

    /** Folha de atividades */
    public function selecionafolhadeatividades($id = NULL)
    {

        $id = $this->getRequest()->getSession()->read('estagiario_id');
        if (is_null($id)) {
            $this->Flash->error(__('Selecionar o aluno e o estágio'));
            return $this->redirect('/alunos/index');
        } else {
            $estagiario = $this->Estagiarios->find()
                ->contain(['Alunos', 'Supervisores', 'Instituicoes'])
                ->where(['Estagiarios.registro' => $this->getRequest()->getSession()->read('registro')])
                ->first();
        }

        $this->set('estagiario', $estagiario);
    }

    /** Folha de atividades para ser preenchida manualmente */
    public function folhadeatividadespdf($id = NULL)
    {
        $this->layout = false;
        $estagiario_id = $this->getRequest()->getQuery('estagiario_id');
        if ($id) {
            $estagiario = $this->Estagiarios->find()
                ->contain(['Alunos', 'Supervisores', 'Instituicoes', 'Professores'])
                ->where(['Estagiarios.id' => $id])
                ->first();
        } elseif ($estagiario_id) {
            $estagiario = $this->Estagiarios->find()
                ->contain(['Alunos', 'Supervisores', 'Instituicoes', 'Professores'])
                ->where(['Estagiarios.id' => $estagiario_id])
                ->first();
        } else {
            $this->Flash->error(__('Sem estagiários'));
            return $this->redirect(['controller' => 'alunos', 'action' => 'index']);
        }

        $this->viewBuilder()->enableAutoLayout(false);
        $this->viewBuilder()->setClassName('CakePdf.Pdf');
        $this->viewBuilder()->setOption(
            'pdfConfig',
            [
                'orientation' => 'portrait',
                'download' => true,
                'filename' => 'folha_de_atividades_' . $id . '.pdf'
            ]
        );
        $this->set('estagiario', $estagiario);
    }

    /** Seleciona a avaliação do discente */
    public function selecionaavaliacaodiscente($id = NULL)
    {

        /* No login foi capturado o id do estagiário */
        $id = $this->getRequest()->getSession()->read('estagiario_id');
        if (is_null($id)) {
            $this->Flash->error(__('Selecionar o aluno estagiário'));
            return $this->redirect('/alunos/index');
        } else {
            $estagiario = $this->Estagiarios->find()
                ->contain(['Alunos', 'Supervisores', 'Instituicoes'])
                ->where(['Estagiarios.registro' => $this->getRequest()->getSession()->read('registro')])
                ->first();
        }

        $this->set('estagiario', $estagiario);
    }

    /** Avaliação do discente para ser preenchida manualmente */
    public function avaliacaodiscentepdf($id = NULL)
    {

        $this->layout = false;
        $estagiario_id = $this->getRequest()->getQuery('estagiario_id');

        $estagiario = $this->Estagiarios->find()
            ->contain(['Alunos', 'Supervisores', 'Instituicoes', 'Professores'])
            ->where(['Estagiarios.id' => $estagiario_id])
            ->first();

        if (!$estagiario) {
            $this->Flash->error(__('Sem estagiarios cadastrados'));
            return $this->redirect(['estagiario' => $estagiario, 'action' => 'view', $estagiario_id]);
        }

        $this->viewBuilder()->enableAutoLayout(false);
        $this->viewBuilder()->setClassName('CakePdf.Pdf');
        $this->viewBuilder()->setOption(
            'pdfConfig',
            [
                'orientation' => 'portrait',
                'download' => true,
                'filename' => 'avaliacao_discente_' . $estagiario_id . '.pdf'
            ]
        );
        $this->set('estagiario', $estagiario);
    }

    /**
     * Edit method
     *
     * @param string|null $id Estagiario id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {

        if (is_null($id)) {
            $this->cakeError('error404');
        } else {
            $estagiario = $this->Estagiarios->get($id, [
                'contain' => [],
            ]);
        }
        if ($this->request->is(['patch', 'post', 'put'])) {
            $estagiarioresultado = $this->Estagiarios->patchEntity($estagiario, $this->request->getData());
            if ($this->Estagiarios->save($estagiarioresultado)) {
                $this->Flash->success(__('Estagiario atualizado.'));

                return $this->redirect(['action' => 'view', $id]);
            }
            $this->Flash->error(__('The estagiario could not be saved. Please, try again.'));
        }
        $alunos = $this->Estagiarios->Alunos->find('list');
        $instituicoes = $this->Estagiarios->Instituicoes->find('list');
        $supervisores = $this->Estagiarios->Supervisores->find('list');
        $professores = $this->Estagiarios->Professores->find('list');
        $turmaestagios = $this->Estagiarios->Turmaestagios->find('list');
        $this->set(compact('estagiario', 'alunos', 'instituicoes', 'supervisores', 'professores', 'turmaestagios'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Estagiario id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {

        $this->request->allowMethod(['post', 'delete']);
        $estagiario = $this->Estagiarios->get($id);
        if ($this->Estagiarios->delete($estagiario)) {
            $this->Flash->success(__('Estagiário excluído.'));
        } else {
            $this->Flash->error(__('Não foi possível excluir o estagiário'));
            return $this->redirect(['controller' => 'alunos', 'action' => 'view', $id]);
        }

        return $this->redirect(['controller' => 'alunos', 'action' => 'view', $estagiario->aluno_id]);
    }

    /**
     * lancanota method
     *
     * @param string|null $id Estagiario id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function lancanota($id = null)
    {

        $siape = $this->getRequest()->getQuery('siape');

        $estagiarios = $this->Estagiarios->Professores->find()
            ->contain([
                'Estagiarios' => [
                    'sort' => ['periodo' => 'desc'],
                    'Alunos' => ['fields' => ['id', 'nome'], 'sort' => ['nome']],
                    'Professores' => ['fields' => ['id', 'nome', 'siape']],
                    'Supervisores' => ['fields' => ['id', 'nome']],
                    'Instituicoes' => ['fields' => ['id', 'instituicao']],
                    'Avaliacoes' => ['fields' => ['id', 'estagiario_id']]
                ]
            ])
            ->where(['siape' => $siape])
            ->first();

        $i = 0;
        $estagiarioslancanota[] = null;
        foreach ($estagiarios as $estagiario):
            foreach ($estagiario->estagiarios as $estagio):
                $estagiarioslancanota[$i]['id'] = $estagio['id'];
                $estagiarioslancanota[$i]['registro'] = $estagio['registro'];
                $estagiarioslancanota[$i]['periodo'] = $estagio['periodo'];
                $estagiarioslancanota[$i]['nivel'] = $estagio['nivel'];
                $estagiarioslancanota[$i]['nota'] = $estagio['nota'];
                $estagiarioslancanota[$i]['ch'] = $estagio['ch'];
                $folhadeatividadestabela = $this->fetchTable('Folhadeatividades');
                $folha = $folhadeatividadestabela->find()
                    ->where(['Folhadeatividades.estagiario_id' => $estagio->id])
                    ->first();
                if ($folha):
                endif;
                $estagiarioslancanota[$i]['instituicao_id'] = $estagio->instituicao->id;
                $estagiarioslancanota[$i]['instituicao'] = $estagio->instituicao->instituicao;
                $estagiarioslancanota[$i]['supervisor_id'] = $estagio->supervisor->id;
                $estagiarioslancanota[$i]['supervisora'] = $estagio->supervisor->nome;
                $estagiarioslancanota[$i]['professor_id'] = $estagio->professor->id;
                $estagiarioslancanota[$i]['professor'] = $estagio->professor->nome;
                $estagiarioslancanota[$i]['aluno_id'] = $estagio->aluno->id;
                $estagiarioslancanota[$i]['aluno'] = $estagio->aluno->nome;
                if (isset($folha)):
                    $estagiarioslancanota[$i]['folha_id'] = $folha->id;
                else:
                    $estagiarioslancanota[$i]['folha_id'] = null;
                endif;
                if (isset($estagio->avaliacao->id)):
                    $estagiarioslancanota[$i]['avaliacao_id'] = $estagio->avaliacao->id;
                else:
                    $estagiarioslancanota[$i]['avaliacao_id'] = null;
                endif;
                $i++;
            endforeach;

        endforeach;
        $this->set('estagiarios', $estagiarioslancanota);
    }
}
