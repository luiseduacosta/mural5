<?php

declare(strict_types=1);

namespace App\Controller;

/**
 * Estagiarios Controller
 *
 * @property \App\Model\Table\EstagiariosTable $Estagiarios
 * @method \App\Model\Entity\Estagiario[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class EstagiariosController extends AppController {

    public function initialize(): void {
        parent::initialize();
        // $this->loadComponent('RequestHandler');
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index($id = NULL) {

        $periodo = $this->getRequest()->getQuery('periodo');

        if (empty($periodo)) {
            $configuracao = $this->fetchTable('Configuracoes');
            $periodo_atual = $configuracao->find()->select(['mural_periodo_atual'])->first();
            $periodo = $periodo_atual->mural_periodo_atual;
        }

        // echo "Período " . $periodo;
        if ($periodo) {
            $query = $this->Estagiarios->find('all')
                    ->where(['Estagiarios.periodo' => $periodo])
                    ->contain(['Estudantes', 'Professores', 'Supervisores', 'Instituicoes', 'Turmaestagios']);
        } else {
            $query = $this->Estagiarios->find('all')
                    ->contain(['Estudantes', 'Professores', 'Supervisores', 'Instituicoes', 'Turmaestagios']);
        }
        $config = $this->paginate = ['sortableFields' => ['id', 'Estudantes.nome', 'registro', 'turno', 'nivel', 'Instituicoes.instituicao', 'Supervisores.nome', 'Professores.nome']];
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
    public function view($id = null) {
        // pr($id);
        if (is_null($id)) {
            $this->cakeError('error404');
        }

        $estagiario = $this->Estagiarios->get($id, [
            'contain' => ['Estudantes', 'Instituicoes', 'Supervisores', 'Professores', 'Turmaestagios']
        ]);

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
    public function add() {

        /** Capturo o id do aluno se estiver cadastrado e envio para o formulario. */
        $estudante_id = $this->Authentication->getIdentityData('estudante_id');
        if ($estudante_id) {
            $estudantetabela = $this->fetchTable('Estudantes');
            $estudanteestagiarios = $estudantetabela->find()
                    ->contain(['Estagiarios' => ['sort' => ['nivel' => 'desc']]])
                    ->where(['id' => $estudante_id])
                    ->first();
            // pr($estudanteestagiarios->estagiarios);
            foreach ($estudanteestagiarios->estagiarios as $estudanteestagiario) {
                $estudanteDeEstagio[] = $estudanteestagiario;
            }

            $this->set('estudante_id', $estudante_id);
            $this->set('estudanteestagiarios', $estudanteestagiarios);
            $this->set('estudantedeestagio', $estudanteDeEstagio[0]);
        }

        $estagiario = $this->Estagiarios->newEmptyEntity();

        $configuracao = $this->fetchTable('Configuracoes');
        $periodo_atual = $configuracao->find()->select(['mural_periodo_atual'])->first();
        $periodo = $periodo_atual->mural_periodo_atual;

        if ($this->request->is('post')) {
            $estagiario = $this->Estagiarios->patchEntity($estagiario, $this->request->getData());
            if ($this->Estagiarios->save($estagiario)) {
                $this->Flash->success(__('Registro de estagiario inserido.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Registro de estagiário não foi inserido. Tente novamente.'));
        }
        $estudantes = $this->Estagiarios->Estudantes->find('list');
        $instituicoes = $this->Estagiarios->Instituicoes->find('list');
        $supervisores = $this->Estagiarios->Supervisores->find('list');
        $professores = $this->Estagiarios->Professores->find('list');
        $turmaestagios = $this->Estagiarios->Turmaestagios->find('list');
        $this->set(compact('periodo', 'estagiario', 'estudantes', 'instituicoes', 'supervisores', 'professores', 'turmaestagios'));
    }

    /**
     * termodecompromisso method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     *
     */
    public function termodecompromisso($id = NULL) {
        $estudante_id = $this->getRequest()->getQuery('estudante_id');
        $instituicao_id = $this->getRequest()->getQuery('instituicao_id');

        /** Vou utilizar a tabela estudantes */
        $estudantestabela = $this->fetchTable('Estudantes');

        if ($this->getRequest()->is('post')) {

            /** Guardo a informação do formulário para atualizar ou inserir um novo registro */
            $dadosinsere = $this->getRequest()->getData();

            /** Tem que ter uma instituição */
            if (empty($dadosinsere['instituicao_id'])) {
                if ($this->getRequest()->getQuery('instituicao_id')) {
                    $dadosinsere['instituicao_id'] = $this->getRequest()->getQuery('instituicao_id');
                } else {
                    $this->Flash->error(__('Selecione uma instituição de estágio.'));
                    return $this->redirect(['action' => 'termodecompromisso']);
                }
            }

            /** Verifica que se não tem supervisor selecionado o valor seja nulo */
            if (empty($dadosinsere['supervisor_id'])) {
                $dadosinsere['supervisor_id'] = null;
            }

            /** Se tem o id é uma atualização, senão é uma inserção de um novo registro de estágio */
            if ($this->getRequest()->getData('id')) {
                $estagiario = $this->Estagiarios->get($this->getRequest()->getData('id'), [
                    'contain' => [],
                ]);
            } else {
                $estagiario = $this->Estagiarios->newEmptyEntity();
                /** Capturo o id do estudante para passar para o estagiario */
                $estudante = $estudantestabela->find()
                        ->contain([])
                        ->where(['Estudantes.id' => $estudante_id])
                        ->first();
                // pr($estudante);
                // die();
                $dadosinsere['estudante_id'] = $estudante->id;
            }

            /** Atualiza ou insere o registro em Estagiarios. */
            $estagiarioresultado = $this->Estagiarios->patchEntity($estagiario, $dadosinsere);
            if ($this->Estagiarios->save($estagiarioresultado)) {

                $this->Flash->success(__('Estágio criado ou atualizado.'));
                /** Gravo o cookie estagiario_id para que o menu superior fique com o submenu_aluno */
                $this->getRequest()->getSession()->write('estagiario_id', $estagiarioresultado->id);

                /** Insere os dados do estudante na tabela alunos */
                $this->alunoinsere($estudante_id, $estagiarioresultado->id);

                return $this->redirect(['action' => 'termodecompromisso', '?' => ['estudante_id' => $estagiarioresultado->estudante_id, 'instituicao_id' => $estagiarioresultado->instituicao_id]]);
            } else {
                // debug($estagiarioresultado);
                $this->Flash->error(__('Não foi possível inserir ou atualizar o estagiario. Tente mais uma vez.'));
            }
        } // Finaliza post

        /** Calculo o periodo atual para estimar o nivel de estágio do Termo de Compromisso. */
        if (!isset($periodoatual) || empty($periodoatual)) {
            $configuracaotabela = $this->fetchTable('Configuracoes');
            $periodo = $configuracaotabela->find()->first();
            $periodoatual = $periodo->mural_periodo_atual;
        }

        /** Obtenho o último nivel de estágio do aluno estagiário e calculo o próximo nível */
        if ($estudante_id) {

            /** Capturo o último estágio do estagiário */
            $ultimoestagio = $this->Estagiarios->find()
                    ->contain(['Estudantes', 'Instituicoes', 'Supervisores'])
                    ->where(['Estagiarios.estudante_id' => $estudante_id])
                    ->order(['Estagiarios.nivel' => 'desc'])
                    ->first();

            /** Último estágio do estagiario */
            if ($ultimoestagio) {

                /** Vai para a funcao nivelsestagio() para calcular o nivel de estágio */
                $nivel = $this->nivelestagio($periodoatual, $ultimoestagio);

                /** Verifico se e uma atualizacao ou uma nova insercao */
                if ($periodoatual == $ultimoestagio->periodo) {
                    $this->set('atualiza', 1); // o estagiario sera atualizado
                } elseif ($periodoatual > $ultimoestagio->periodo) {
                    $this->set('atualiza', 0); // nova inserção de estagiario
                } else {
                    $this->Flash->error(__('Periodo atual menor que ultimo periodo de estagio cadastrado.'));
                    return $this->redirect(['controller' => 'Estagiarios', 'action' => 'view', $ultimoestagio->id]);
                }
                $this->set('ultimoestagio', $ultimoestagio);
                /** Nao estagiario */
            } else {
                /** Estudante sem estágio: nível 1 */
                $nivel = 1;
                $estudante_semestagio = $estudantestabela->find()
                        ->contain([])
                        ->where(['Estudantes.id' => $estudante_id])
                        ->select(['id', 'registro', 'nome', 'turno', 'ingresso'])
                        ->first();
                $this->set('estudante_semestagio', $estudante_semestagio);
                $this->set('atualiza', 0); // nova inserção de estagiario
            }
            $this->set('nivel', $nivel);
            $this->set('periodo', $periodoatual);

            /** Seleciona os supervisores da instituição */
            if ($instituicao_id) {

                $supervisoresinstituicao = $this->selecionasupervisores($instituicao_id);
                if (isset($supervisoresinstituicao)) {
                    $this->set('supervisores', $supervisoresinstituicao);
                } else {
                    $this->set('supervisores', 'Sem dados');
                }
            }

            $this->set('estudante_id', $estudante_id);
            $this->set('instituicao_id', $instituicao_id);

            $estudante = $estudantestabela->find()->where(['Estudantes.id' => $estudante_id])->first();
            $instituicoes = $this->Estagiarios->Instituicoes->find('list');
            $turmaestagios = $this->Estagiarios->Turmaestagios->find('list');
            $this->set(compact('instituicoes', 'turmaestagios', 'estudante'));
            if (isset($supervisoresinstituicao)):
                $this->set('supervisoresdainstituicao', $supervisoresinstituicao);
            endif;
        }
    }

    /** Seleciona os supervisores da instituicao */
    private function selecionasupervisores($instituicao_id = null) {
        $supervisoresinstituicao = null;
        if ($instituicao_id) {

            $supervisoresDaInstituicao = $this->Estagiarios->Instituicoes->find()
                    ->contain(['Supervisores'])
                    ->where(['Instituicoes.id' => $instituicao_id])
                    ->first();

            // pr($supervisoresDaInstituicao);
            // die();

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

    /** Compara o periodoautal com o periodo de estagio do estagiario para definiar o nivel de estagio */
    private function nivelestagio($periodoatual, $ultimoestagio) {
        /* Se o periodo atual é o mesmo do periodo cadastrado no estagiário deixa o nivel como está */
        if ($periodoatual == $ultimoestagio->periodo) {
            $nivel = $ultimoestagio->nivel;
            /** Se o periodo atual é maior que o cadastrado então passa para o próximo nivel e insere um novo registro */
        } elseif ($periodoatual > $ultimoestagio->periodo) {
            $nivel = $ultimoestagio->nivel + 1;
            /** Calculo o ultimo nível de estágio possível a partir do ajuste curricular. */
            $ultimoestagio->ajuste2020 == 0 ? $ultimonivelestagio = 4 : $ultimonivelestagio = 3;
            /** Se nivel é maior que o ultimo nivel curricular então está realizando estagio extracurricular e o nivel é 9. */
            if ($nivel > $ultimonivelestagio) {
                // Estágio não curricular
                $nivel = 9;
            }
        } else {
            $this->Flash->error(__("Período de estágio atual não pode ser menor que o último período cursado."));
            return $this->redirect(['action' => 'termodecompromisso', $ultimoestagio->id]);
        }
        return $nivel;
    }

    /**
     * Inserir dados de estudante na tabela aluno.
     */
    private function alunoinsere($estudante_id, $estagiario_id) {
        /**
         * Verificar se o aluno está cadastrado em estagiarios.
         */
        $estagiario = $this->Estagiarios->find()->where(['id' => $estagiario_id])->first();
        $alunostabela = $this->fetchTable('Alunos');
        $aluno = $alunostabela->find()->where(['registro' => $estagiario->registro])->first();
        if ($aluno) {
            echo 'Aluno cadastrado: atualizar apenas o aluno_id em estagiarios' . '<br>';
            $estagiario_entity = $this->Estagiarios->get($estagiario_id);
            $estagiario = $this->Estagiarios->find()->where(['id' => $estagiario_id])->first();
            // pr($estagiario);
            $dadosinsere = $estagiario->toArray();
            // pr($dadosinsere);
            // die('estagiario');
            $dadosinsere['aluno_id'] = $aluno->id;
            // pr($dadosinsere);
            // die();
            $estagiario_aluno_resultado = $this->Estagiarios->patchEntity($estagiario_entity, $dadosinsere);
            if ($this->Estagiarios->save($estagiario_aluno_resultado)) {
                $this->Flash->success(__("Estagiário atualizado"));
            } else {
                // debug($estagiario_aluno_resultado);
                // die();
            }
        } else {
            echo 'Aluno não cadastrado: fazer uma inserção nova na tabela alunos e atualizar aluno_id na tabela estagiarios' . '<br>';
            $estudantestabela = $this->fetchTable('Estudantes');
            $estudante = $estudantestabela->find()
                    ->where(['Estudantes.id' => $estudante_id])
                    ->first()
                    ->toArray();
            // pr($estudante);
            // die();
            $alunostabela = $this->fetchTable('Alunos');
            $aluno_novo = $alunostabela->newEmptyEntity();
            $aluno_novo_resultado = $alunostabela->patchEntity($aluno_novo, $estudante);
            // pr($aluno_novo_resultado);
            // die();
            if ($alunostabela->save($aluno_novo_resultado)) {
                $this->Flash->success(__('Aluno inserido'));
                /** Atualizo o aluno_id na tabela estagiarios */
                $estagiario_entity = $this->Estagiarios->get($estagiario_id);
                $estagiario = $this->Estagiarios->find()->where(['id' => $estagiario_id])->first();
                // pr($estagiario);
                $dadosinsere = $estagiario->toArray();
                // pr($dadosinsere);
                // die('estagiario');
                $dadosinsere['aluno_id'] = $aluno_novo_resultado->id;
                // pr($dadosinsere);
                // die();
                $estagiario_aluno_resultado = $this->Estagiarios->patchEntity($estagiario_entity, $dadosinsere);
                if ($this->Estagiarios->save($estagiario_aluno_resultado)) {
                    $this->Flash->success(__("Estagiário atualizado"));
                } else {
                    // debug($estagiario_aluno_resultado);
                    // die();
                }
            } else {
                // debug($aluno_novo_resultado);
                // die('Error');
            }
        }
        return;
    }

    public function termodecompromissopdf($id = NULL) {

        $this->layout = false;
        if (is_null($id)) {
            $this->cakeError('error404');
        } else {
            $estagiario = $this->Estagiarios->find()
                    ->contain(['Estudantes', 'Supervisores', 'Instituicoes'])
                    ->where(['Estagiarios.id' => $id]);
        }
        // pr($estagiario->first());
        // die();
        $configuracaotabela = $this->fetchTable('Configuracoes');
        $configuracao = $configuracaotabela->get(1);
        // pr($configuracao);
        // die();

        $this->viewBuilder()->enableAutoLayout(false);
        $this->viewBuilder()->setClassName('CakePdf.Pdf');
        $this->viewBuilder()->setOption(
                'pdfConfig',
                [
                    'orientation' => 'portrait',
                    'download' => true, // This can be omitted if "filename" is specified.
                    'filename' => 'termo_de_compromisso_' . $id . '.pdf' //// This can be omitted if you want file name based on URL.
                ]
        );
        $this->set('configuracao', $configuracao);
        $this->set('estagiario', $estagiario->first());
    }

    public function selecionadeclaracaodeestagio($id = NULL) {

        /* No login foi capturado o id do estagiário */
        $id = $this->getRequest()->getSession()->read('estagiario_id');
        if (is_null($id)) {
            $this->Flash->error(__('Selecionar o estudante estagiário'));
            return $this->redirect('/estudantes/index');
        } else {
            $estagiario = $this->Estagiarios->find()
                    ->contain(['Estudantes', 'Supervisores', 'Instituicoes'])
                    ->where(['Estagiarios.registro' => $this->getRequest()->getSession()->read('registro')])
                    ->all();
            //pr($estagiario);
            // die();
        }

        $this->set('estagiario', $estagiario);
    }

    public function declaracaodeestagiopdf($id = NULL) {

        $estagiarioquery = $this->Estagiarios->find()
                ->contain(['Estudantes', 'Supervisores', 'Instituicoes'])
                ->where(['Estagiarios.id' => $id])
                ->first();
        // pr($estagioquery);
        // die('estagioquery');

        if (!$estagiarioquery) {
            $this->Flash->error(__('Sem estagio cadastrado.'));
            return $this->redirect(['controller' => 'estagiarios', 'action' => 'view', $id]);
        }

        if (empty($estagiarioquery->estudante->identidade)) {
            $this->Flash->error(__("Estudante sem RG"));
            return $this->redirect('/estudantes/view/' . $estagiarioquery->estudante->id);
        }

        if (empty($estagiarioquery->estudante->orgao)) {
            $this->Flash->error(__("Estudante não especifica o orgão emisor do documento"));
            return $this->redirect('/estudantes/view/' . $estagiarioquery->estudante->id);
        }
        if (empty($estagiarioquery->estudante->cpf)) {
            $this->Flash->error(__("Estudante sem CPF"));
            return $this->redirect('/estudantes/view/' . $estagiarioquery->estudante->id);
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

    public function selecionafolhadeatividades($id = NULL) {

        /* No login foi capturado o id do estagiário */
        $id = $this->getRequest()->getSession()->read('estagiario_id');
        if (is_null($id)) {
            $this->Flash->error(__('Selecionar o estudante e o estágio'));
            return $this->redirect('/estudantes/index');
        } else {
            $estagiario = $this->Estagiarios->find()
                    ->contain(['Estudantes', 'Supervisores', 'Instituicoes'])
                    ->where(['Estagiarios.registro' => $this->getRequest()->getSession()->read('registro')])
                    ->all();
            //pr($estagiario);
            // die();
        }

        $this->set('estagiario', $estagiario);
    }

    public function folhadeatividadespdf($id = NULL) {

        $this->layout = false;
        if (is_null($id)) {
            $this->Flash->error(__('Por favor selecionar o estágio do estudante'));
            return $this->redirect('/estudantes/view?registro=' . $this->getRequest()->getSession()->read('registro'));
        } else {
            $estagiario = $this->Estagiarios->find()
                    ->contain(['Estudantes', 'Supervisores', 'Instituicoes', 'Professores'])
                    ->where(['Estagiarios.id' => $id])
                    ->first();
        }
        // pr($estagiario);
        // die('estagioario');

        $this->viewBuilder()->enableAutoLayout(false);
        $this->viewBuilder()->setClassName('CakePdf.Pdf');
        $this->viewBuilder()->setOption(
                'pdfConfig',
                [
                    'orientation' => 'portrait',
                    'download' => true, // This can be omitted if "filename" is specified.
                    'filename' => 'folha_de_atividades_' . $id . '.pdf' //// This can be omitted if you want file name based on URL.
                ]
        );
        $this->set('estagiario', $estagiario);
    }

    public function selecionaavaliacaodiscente($id = NULL) {

        /* No login foi capturado o id do estagiário */
        $id = $this->getRequest()->getSession()->read('estagiario_id');
        if (is_null($id)) {
            $this->Flash->error(__('Selecionar o estudante estagiário'));
            return $this->redirect('/estudantes/index');
        } else {
            $estagiario = $this->Estagiarios->find()
                    ->contain(['Estudantes', 'Supervisores', 'Instituicoes'])
                    ->where(['Estagiarios.registro' => $this->getRequest()->getSession()->read('registro')])
                    ->all();
            //pr($estagiario);
            // die();
        }

        $this->set('estagiario', $estagiario);
    }

    public function avaliacaodiscentepdf($id = NULL) {

        $this->layout = false;
        $estagiario_id = $this->getRequest()->getQuery('estagiario_id');

        $estagiario = $this->Estagiarios->find()
                ->contain(['Estudantes', 'Supervisores', 'Instituicoes', 'Professores'])
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
                    'download' => true, // This can be omitted if "filename" is specified.
                    'filename' => 'avaliacao_discente_' . $estagiario_id . '.pdf' //// This can be omitted if you want file name based on URL.
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
    public function edit($id = null) {

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
        // $alunos = $this->Estagiarios->Alunos->find('list');
        $estudantes = $this->Estagiarios->Estudantes->find('list');
        $instituicoes = $this->Estagiarios->Instituicoes->find('list');
        $supervisores = $this->Estagiarios->Supervisores->find('list');
        $professores = $this->Estagiarios->Professores->find('list');
        $turmaestagios = $this->Estagiarios->Turmaestagios->find('list');
        $this->set(compact('estagiario', 'estudantes', 'instituicoes', 'supervisores', 'professores', 'turmaestagios'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Estagiario id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null) {

        $this->request->allowMethod(['post', 'delete']);
        $estagiario = $this->Estagiarios->get($id);
        if ($this->Estagiarios->delete($estagiario)) {
            $this->Flash->success(__('Estagiário excluído.'));
        } else {
            $this->Flash->error(__('Não foi possível excluir o estagiário'));
        }

        return $this->redirect(['controller' => 'estudantes', 'action' => 'view', '?' => ['registro' => $estagiario->registro]]);
    }

    public function lancanota($id = null) {

        $siape = $this->getRequest()->getQuery('siape');

        $estagiarios = $this->Estagiarios->Professores->find()
                ->contain([
                    'Estagiarios' => [
                        'sort' => ['periodo' => 'desc'],
                        'Estudantes' => ['fields' => ['id', 'nome'], 'sort' => ['nome']],
                        'Professores' => ['fields' => ['id', 'nome', 'siape']],
                        'Supervisores' => ['fields' => ['id', 'nome']],
                        'Instituicoes' => ['fields' => ['id', 'instituicao']],
                        'Avaliacoes' => ['fields' => ['id', 'estagiario_id']]
                    ]
                ])
                ->where(['siape' => $siape])
                ->first();

        // pr($estagiarios);
        $i = 0;
        $estagiarioslancanota[] = null;
        foreach ($estagiarios as $estagiario):
            // pr($estagiario);
            // $estagiarioslancanota[$i]['periodo'] = $estagiario;
            foreach ($estagiario->estagiarios as $estagio):
                // pr($c_estagio);
                $estagiarioslancanota[$i]['id'] = $estagio['id'];
                $estagiarioslancanota[$i]['registro'] = $estagio['registro'];
                $estagiarioslancanota[$i]['periodo'] = $estagio['periodo'];
                $estagiarioslancanota[$i]['nivel'] = $estagio['nivel'];
                $estagiarioslancanota[$i]['nota'] = $estagio['nota'];
                $estagiarioslancanota[$i]['ch'] = $estagio['ch'];
                // pr($c_estagio->instituicao);
                // pr($c_estagio->supervisor);
                // pr($c_estagio->professor);
                // pr($c_estagio->estudante);
                $folhadeatividadestabela = $this->fetchTable('Folhadeatividades');
                $folha = $folhadeatividadestabela->find()
                        ->where(['Folhadeatividades.estagiario_id' => $estagio->id])
                        ->first();
                if ($folha):
                // pr($folha);
                endif;
                $estagiarioslancanota[$i]['instituicao_id'] = $estagio->instituicao->id;
                $estagiarioslancanota[$i]['instituicao'] = $estagio->instituicao->instituicao;
                $estagiarioslancanota[$i]['supervisor_id'] = $estagio->supervisor->id;
                $estagiarioslancanota[$i]['supervisora'] = $estagio->supervisor->nome;
                $estagiarioslancanota[$i]['professor_id'] = $estagio->professor->id;
                $estagiarioslancanota[$i]['professor'] = $estagio->professor->nome;
                $estagiarioslancanota[$i]['estudante_id'] = $estagio->estudante->id;
                $estagiarioslancanota[$i]['estudante'] = $estagio->estudante->nome;
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
        // pr($estagiarioslancanota);
        // die();
        $this->set('estagiarios', $estagiarioslancanota);
    }
}
