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
                    ->contain(['Alunos', 'Estudantes', 'Docentes', 'Supervisores', 'Instituicaoestagios', 'Turmaestagios']);
        } else {
            $query = $this->Estagiarios->find('all')
                    ->contain(['Alunos', 'Estudantes', 'Docentes', 'Supervisores', 'Instituicaoestagios', 'Turmaestagios']);
        }
        $config = $this->paginate = ['sortableFields' => ['id', 'Alunos.nome', 'Estudantes.nome', 'registro', 'turno', 'nivel', 'Instituicaoestagios.instituicao', 'Supervisores.nome', 'Docentes.nome']];
        $estagiarios = $this->paginate($query, $config);

        /* Todos os periódos */
        $periodototal = $this->Estagiarios->find('list', [
            'keyField' => 'periodo',
            'valueField' => 'periodo',
            'order' => 'periodo'
        ]);
        $periodos = $periodototal->toArray();

        $this->set('periodo', $periodo);
        $this->set('periodos', $periodos);

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
            'contain' => ['Estudantes', 'Instituicaoestagios', 'Supervisores', 'Docentes']
        ]);

        $this->set(compact('estagiario'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add() {
        $estagiario = $this->Estagiarios->newEmptyEntity();
        if ($this->request->is('post')) {
            $estagiario = $this->Estagiarios->patchEntity($estagiario, $this->request->getData());
            if ($this->Estagiarios->save($estagiario)) {
                $this->Flash->success(__('The estagiario has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The estagiario could not be saved. Please, try again.'));
        }
        $alunos = $this->Estagiarios->Alunos->find('list', ['limit' => 200]);
        $estudantes = $this->Estagiarios->Estudantes->find('list', ['limit' => 200]);
        $instituicaoestagios = $this->Estagiarios->Instituicaoestagios->find('list', ['limit' => 200]);
        $supervisores = $this->Estagiarios->Supervisores->find('list', ['limit' => 200]);
        $docentes = $this->Estagiarios->Docentes->find('list', ['limit' => 200]);
        $turmaestagios = $this->Estagiarios->Turmaestagios->find('list', ['limit' => 200]);
        $this->set(compact('estagiario', 'alunos', 'estudantes', 'instituicaoestagios', 'supervisores', 'docentes', 'turmaestagios'));
    }

    /**
     * termodecompromisso method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     * Ainda está com um problema: não grava o TC e a data do TC!!!!
     */
    public function termodecompromisso($id = NULL) {
        // pr($id);
        // die();
        /** O administrador pode fazer Termo de Compromisso. Precisa do DRE ou ID do estudante */
        if ($this->getRequest()->getSession()->read('categoria') == 1):
            if (empty($id)) {
                $this->Flash->error(__('Administrador: selecionar o registro do estudante'));
                return $this->redirect('/estudantes/index');
                // $estagiario_id = $this->getRequest()->getQuery('estagiario_id');
            } else {
                $registro = $this->getRequest()->getQuery('registro');
                $estudante = $this->Estagiarios->Estudantes->find()
                        ->where(['Estudantes.registro' => $registro])
                        ->first();
                $estudante_id = $estudante->id;
            }
        endif;

        if (is_null($id)) {
            $registro = $this->getRequest()->getQuery('registro');
            if (!empty($registro)) {
                $estudante = $this->Estagiarios->Estudantes->find()
                        ->where(['Estudantes.registro' => $registro])
                        ->first();
            }
        }

        /** Apenas para efeitos de depuração do código.
         * Captura os dados enviados pelo formulário.
         */
        if ($this->getRequest()->getData()) {
            // pr($this->getRequest()->getData());
            // die();
        }

        if ($this->getRequest()->is('post')) {
            // pr($this->getRequest()->getData());
            // die();

            /**
             * Prepara a variavel $dadosinsere para inserir os dados do formulário.
             * Discrimina se é uma atualização ou uma inserção.
             * Se tem o id então é uma atualização
             */
            if ($this->getRequest()->getData('id')) {
                // die('Atualiza');
                $estagiario = $this->Estagiarios->get($this->getRequest()->getData()['id'], [
                    'contain' => [],
                ]);
                $dadosinsere = $this->getRequest()->getData();
                // pr($dadosinsere);
                // die();
            } else {
                // die('Insere registro novo');
                $estagiario = $this->Estagiarios->newEmptyEntity();

                $estudantestabela = $this->fetchTable('Estudantes');
                /** Capturo o id do estudante para passar para o estagiario */
                $estudante = $estudantestabela->find()
                        ->contain([])
                        ->where(['Estudantes.registro' => $this->getRequest()->getSession()->read('registro')])
                        ->first();
                // pr($estudante);
                // die();
                $dadosinsere = $this->request->getData();
                $dadosinsere['alunonovo_id'] = $estudante->id;
                // pr($dadosinsere);
                // die();
            }

            // pr($dadosinsere);
            // die();

            /** Tem que ter uma instituição */
            if (empty($dadosinsere['id_instituicao'])) {
                if ($this->getRequest()->getQuery('instituicao')) {
                    $dadosinsere['id_instituicao'] = $this->getRequest()->getQuery('instituicao');
                } else {
                    $this->Flash->error(__('Selecione uma instituição de estágio.'));
                    return $this->redirect(['action' => 'termodecompromisso']);
                }
            }

            // pr($dadosinsere);
            // pr($estagiario);
            // die();

            /** Atualiza ou insere o registro em Estagiarios. */
            $estagiario = $this->Estagiarios->patchEntity($estagiario, $dadosinsere);
            // $estagiario->clean(); // Para eliminar o dirty dos entity nos campos que mudam de valor
            if ($this->Estagiarios->save($estagiario)) {

                $this->Flash->success(__('Estágio criado ou atualizado.'));
                /** Gravo o cookie estagiario_id para que o menu superior fique com o submenu_aluno */
                $this->getRequest()->getSession()->write('estagiario_id', '1');

                // Se foi uma atualização retorna para o id
                if ($this->getRequest()->getData('id')) {
                    // die('atualização');
                    $ultimo_id = $this->getRequest()->getData('id');
                } else {
                    // die('criação');
                    $id = $this->Estagiarios->find()->orderDesc('id')->first();
                    $ultimo_id = $id->id;
                    // pr($ultimo_id);
                    // die();

                    /**
                     * Inserir dados de estudante em aluno.
                     * Antes, precisa verificar se o aluno já está cadastrado.
                     */
                    $alunostabela = $this->fetchTable('Alunos');
                    $aluno = $alunostabela->find()->where(['registro' => $dadosinsere['registro']])->first();
                    if ($aluno) {
                        // echo "Aluno já está cadastrado" . "<br>";
                    } else {
                        $estudantestabela = $this->fetchTable('Estudantes');
                        $queryestudantesemestagio = $estudantestabela->find()
                                ->where(['Estudantes.registro' => $this->getRequest()->getSession()->read('registro')])
                                ->first();
                        $estudantesemestagio = $queryestudantesemestagio->toArray();
                        // pr($estudantesemestagio);
                        // die();
                        $aluno_novo = $this->Alunos->newEmptyEntity();
                        $aluno_novo = $this->Alunos->patchEntity($aluno_novo, $estudantesemestagio);
                        if ($this->Alunos->save($aluno_novo, $estudantesemestagio)) {
                            $this->Flash->success(__('Aluno atualizado'));
                        }
                    }
                    /** Finaliza a insercao dos dados do estudante no aluno. */
                    /** Atualizo o estagiario novo com o id do aluno */
                    $aluno = $this->Alunos->find()
                            ->where(['registro' => $dadosinsere['registro']])
                            ->first();
                    $aluno_id = $aluno->toArray()['id'];
                    // pr($aluno_id);
                    // die('aluno_id');

                    $estagiario = $this->Estagiarios->newEmptyEntity();
                    // pr($estagiario);
                    // die('estagiario');
                    $dadosinsere['id_aluno'] = $aluno_id;
                    // pr($dadosinsere);
                    // die();
                    $estagiario = $this->Estagiarios->patchEntity($estagiario, $dadosinsere);
                    if ($this->Estagiarios->save($estagiario)):
                        $this->Flash->success(__("Estagiário atualizado"));
                    endif;
                    /** Finaliza a atualizaçao do estagiario com o id do aluno. */
                }
                // pr($ultimo_id);
                // die();
                return $this->redirect(['action' => 'termodecompromisso', $ultimo_id]);
                // return $this->redirect(['action' => 'termodecompromissopdf', $ultimo_id]);
            }
            // debug($estagiario);
            $this->Flash->error(__('Não foi possível finalizar. Tente mais uma vez.'));
        } // Finaliza post

        /** Calculo o periodo atual para estimar o nivel de estágio do Termo de Compromisso. */
        if (!isset($periodoatual) || empty($periodoatual)) {
            $configuracaotabela = $this->fetchTable('Configuracoes');
            $periodo = $configuracaotabela->find()->first();
            $periodoatual = $periodo->mural_periodo_atual;
        }

        $this->set('periodo', $periodoatual);

        /** Coleto dados para enviar para o formulário */
        $ultimoestagio = $this->Estagiarios->find()
                ->contain(['Alunos', 'Estudantes', 'Supervisores', 'Docentes', 'Instituicaoestagios'])
                ->where(['Estagiarios.registro' => $this->getRequest()->getSession()->read('registro')])
                ->order(['Estagiarios.nivel'])
                ->all()
                ->last();
        // pr($ultimoestagio);
        // die();

        /** Se for um estudante estagiario calculo o ultimo estágio para inserir ou atualizar. */
        if ($ultimoestagio) {
            $teste = $ultimoestagio->periodo == $periodoatual;
            /* Se o periodo atual é o mesmo do periodo cadastrado deixa o nivel como está */
            if ($ultimoestagio->periodo == $periodoatual) {
                // pr("Atualização de dados do estagiario");
                // echo "Atualiza o termo de compromisso";
                $this->set('atualizar', 1);
                // Se o periodo atual é maior que o cadastrado então passa para o próximo nivel e insere um novo registro
            } elseif ($ultimoestagio->periodo < $periodoatual) {
                $ultimoestagio->periodo = $periodoatual;
                // pr($ultimoestagio->nivel);
                /* Calculo o ultimo estagio a partir do ajuste curricular. */
                ($ultimoestagio->ajustecurricular) == 0 ? $ultimonivelestagio = 4 : $ultimonivelestagio = 3;
                // pr($ultimonivelestagio);
                // die();
                /** Se ja esta no ultimo nivel curricular entao esta realizando estagio extracurricular e o nivel e 9. */
                if ($ultimoestagio->nivel >= $ultimonivelestagio) {
                    // Estágio não curricular
                    $ultimoestagio->nivel = 9;
                } else {
                    $ultimoestagio->nivel = $ultimoestagio->nivel + 1;
                }
                // pr($ultimoestagio->nivel);
            } else {
                $this->Flash->error(__("Periodo de estagio atual nao pode ser menor que o ultimo periodo cursado."));
                return $this->redirect(['action' => 'termodecompromisso']);
            }
            // die($ultimoestagio);
            $this->set('estudanteestagiario', $ultimoestagio->Estudantes);
            $this->set('ultimoestagio', $ultimoestagio);
        } else {
            // Se não é estagiário então capturo a informação do estudante e envio para o formulario
            $estudantestabela = $this->fetchTable('Estudantes');
            $estudante_semestagio = $estudantestabela->find()
                    ->contain([])
                    ->where(['registro' => $this->getRequest()->getSession()->read('registro')])
                    ->select(['id', 'registro', 'nome', 'turno', 'ingresso'])
                    ->first();
            $this->set('estudante_semestagio', $estudante_semestagio);
        }

        /** Para fazer as caixas de seleção */
        /* Supervisores da instituição */
        if ($ultimoestagio) {
            /**
             * Capturo a instituição enviado como parámetro pela view.
             */
            $instituicao_id = $this->getRequest()->getQuery('instituicao');
            if ($instituicao_id) {
                $supervisores_instituicao = $this->Estagiarios->Instituicaoestagios->find()
                        ->contain(['Supervisores'])
                        ->where(['Instituicaoestagios.id' => $instituicao_id])
                        ->first();
                $this->set('instituicao_id', $instituicao_id);
                if ($supervisores_instituicao) {
                    $this->set('instituicao', $supervisores_instituicao);
                    foreach ($supervisores_instituicao->supervisores as $c_supervisor) {
                        $supervisoresdainstituicao[$c_supervisor['id']] = $c_supervisor['nome'];
                    }
                } else {
                    $supervisoresdainstituicao[0] = "Sem supervisor(a)";
                }
                // pr($supervisoresdainstituicao);
                // die();
                /** Se o id da institucao nao veio como parametro entao o id e o id do $ultimoestagio. */
            } else {
                // pr($ultimoestagio->instituicaoestagio->id);
                $supervisores_instituicao = $this->Estagiarios->Instituicaoestagios->find()
                        ->contain(['Supervisores'])
                        ->where(['Instituicaoestagios.id' => $ultimoestagio->instituicaoestagio->id])
                        ->first();
                $this->set('instituicao_id', $ultimoestagio->instituicaoestagio->id);
                if ($supervisores_instituicao) {
                    $this->set('instituicao', $supervisores_instituicao);
                    foreach ($supervisores_instituicao->supervisores as $c_supervisor) {
                        $supervisoresdainstituicao[$c_supervisor['id']] = $c_supervisor['nome'];
                    }
                } else {
                    $supervisoresdainstituicao[0] = "Sem supervisor(a)";
                }
                // pr($supervisoresdainstituicao);
            }
            $this->set('supervisores', $supervisores_instituicao->supervisores);
        }

        $instituicaoestagios = $this->Estagiarios->Instituicaoestagios->find('list');
        $supervisores = $this->Estagiarios->Supervisores->find('list');
        $turmaestagios = $this->Estagiarios->Turmaestagios->find('list');
        $this->set(compact('instituicaoestagios', 'supervisores', 'turmaestagios'));
        if (isset($supervisoresdainstituicao)):
            $this->set('supervisoresdainstituicao', $supervisoresdainstituicao);
        endif;
    }

    public function termodecompromissopdf($id = NULL) {

        $this->layout = false;
        if (is_null($id)) {
            $this->cakeError('error404');
        } else {
            $estagiario = $this->Estagiarios->find()
                    ->contain(['Alunos', 'Estudantes', 'Supervisores', 'Instituicaoestagios'])
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
            $this->cakeError('error404');
        } else {
            $estagiarioquery = $this->Estagiarios->find()
                    ->contain(['Estudantes', 'Supervisores', 'Instituicaoestagios'])
                    ->where(['Estagiarios.registro' => $this->getRequest()->getSession()->read('registro')]);
            $estagiario = $estagiarioquery->all();
            //pr($estagiario);
            // die();
        }

        $this->set('estagiario', $estagiario);
    }

    public function declaracaodeestagiopdf($id = NULL) {

        $this->layout = false;
        if (is_null($id)) {
            $this->cakeError('error404');
        } else {
            $estagiarioquery = $this->Estagiarios->find()
                    ->contain(['Estudantes', 'Supervisores', 'Instituicaoestagios'])
                    ->where(['Estagiarios.id' => $id])
                    ->first();
        }
        // pr($estagioquery);
        // die('estagioquery');

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
            $this->cakeError('error404');
        } else {
            $estagiarioquery = $this->Estagiarios->find()
                    ->contain(['Estudantes', 'Supervisores', 'Instituicaoestagios'])
                    ->where(['Estagiarios.registro' => $this->getRequest()->getSession()->read('registro')]);
            $estagiario = $estagiarioquery->all();
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
            $estagiarioquery = $this->Estagiarios->find()
                    ->contain(['Estudantes', 'Supervisores', 'Instituicaoestagios', 'Docentes'])
                    ->where(['Estagiarios.id' => $id]);
        }

        $estagiario = $estagiarioquery->first();
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
            $this->cakeError('error404');
        } else {
            $estagiarioquery = $this->Estagiarios->find()
                    ->contain(['Estudantes', 'Supervisores', 'Instituicaoestagios'])
                    ->where(['Estagiarios.registro' => $this->getRequest()->getSession()->read('registro')]);
            $estagiario = $estagiarioquery->all();
            //pr($estagiario);
            // die();
        }

        $this->set('estagiario', $estagiario);
    }

    public function avaliacaodiscentepdf($id) {

        $this->layout = false;
        if (is_null($id)) {
            $this->cakeError('error404');
        } else {
            $estagiarioquery = $this->Estagiarios->find()
                    ->contain(['Estudantes', 'Supervisores', 'Instituicaoestagios', 'Docentes'])
                    ->where(['Estagiarios.id' => $id]);
        }

        $estagiario = $estagiarioquery->first();
        // pr($estagiario);
        // die('estagioario');

        $this->viewBuilder()->enableAutoLayout(false);
        $this->viewBuilder()->setClassName('CakePdf.Pdf');
        $this->viewBuilder()->setOption(
                'pdfConfig',
                [
                    'orientation' => 'portrait',
                    'download' => true, // This can be omitted if "filename" is specified.
                    'filename' => 'avaliacao_discente_' . $id . '.pdf' //// This can be omitted if you want file name based on URL.
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
            $estagiario = $this->Estagiarios->patchEntity($estagiario, $this->request->getData());
            if ($this->Estagiarios->save($estagiario)) {
                $this->Flash->success(__('Estagiario atualizado.'));

                return $this->redirect(['action' => 'view', $id]);
            }
            $this->Flash->error(__('The estagiario could not be saved. Please, try again.'));
        }
        $alunos = $this->Estagiarios->Alunos->find('list');
        $estudantes = $this->Estagiarios->Estudantes->find('list');
        $instituicaoestagios = $this->Estagiarios->Instituicaoestagios->find('list');
        $supervisores = $this->Estagiarios->Supervisores->find('list');
        $docentes = $this->Estagiarios->Docentes->find('list', ['limit' => 500]);
        $turmaestagios = $this->Estagiarios->Turmaestagios->find('list', ['limit' => 200]);
        $this->set(compact('estagiario', 'alunos', 'estudantes', 'instituicaoestagios', 'supervisores', 'docentes', 'turmaestagios'));
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

        return $this->redirect(['controller' => 'estudantes', 'action' => 'view?registro=' . $estagiario->registro]);
    }

    public function lancanota($id = null) {

        $siape = $this->getRequest()->getQuery('siape');

        $idquery = $this->Estagiarios->Docentes->find()
                ->contain([
                    'Estagiarios' => [
                        'sort' => ['periodo' => 'desc'],
                        'Estudantes' => ['fields' => ['id', 'nome'], 'sort' => ['nome']],
                        'Docentes' => ['fields' => ['id', 'nome', 'siape']],
                        'Supervisores' => ['fields' => ['id', 'nome']],
                        'Instituicaoestagios' => ['fields' => ['id', 'instituicao']],
                        'Avaliacoes' => ['fields' => ['id', 'estagiario_id']]
                    ]
                ])
                ->where(['siape' => $siape]);

        // die();
        // $estagiariosfolha = $idquery->distinct(['estagiario_id']);
        $estagiarios = $idquery->first();
        // pr($estagiarios);
        $i = 0;
        $estagiarioslancanota[] = null;
        foreach ($idquery as $estagiario):
            // pr($estagiario);
            // $estagiarioslancanota[$i]['periodo'] = $estagiario;
            foreach ($estagiario->estagiarios as $c_estagio):
                // pr($c_estagio);
                $estagiarioslancanota[$i]['id'] = $c_estagio['id'];
                $estagiarioslancanota[$i]['registro'] = $c_estagio['registro'];
                $estagiarioslancanota[$i]['periodo'] = $c_estagio['periodo'];
                $estagiarioslancanota[$i]['nivel'] = $c_estagio['nivel'];
                $estagiarioslancanota[$i]['nota'] = $c_estagio['nota'];
                $estagiarioslancanota[$i]['ch'] = $c_estagio['ch'];
                // pr($c_estagio->instituicaoestagio);
                // pr($c_estagio->supervisor);
                // pr($c_estagio->docente);
                // pr($c_estagio->estudante);
                $folhadeatividadestabela = $this->fetchTable('Folhadeatividades');
                $folhaquery = $folhadeatividadestabela->find()
                        ->where(['Folhadeatividades.estagiario_id' => $c_estagio->id]);
                $folha = $folhaquery->first();
                if ($folha):
                // pr($folha);
                endif;
                $estagiarioslancanota[$i]['instituicao_id'] = $c_estagio->instituicaoestagio->id;
                $estagiarioslancanota[$i]['instituicao'] = $c_estagio->instituicaoestagio->instituicao;
                $estagiarioslancanota[$i]['supervisor_id'] = $c_estagio->supervisor->id;
                $estagiarioslancanota[$i]['supervisora'] = $c_estagio->supervisor->nome;
                $estagiarioslancanota[$i]['docente_id'] = $c_estagio->docente->id;
                $estagiarioslancanota[$i]['docente'] = $c_estagio->docente->nome;
                $estagiarioslancanota[$i]['estudante_id'] = $c_estagio->estudante->id;
                $estagiarioslancanota[$i]['estudante'] = $c_estagio->estudante->nome;
                if (isset($folha)):
                    $estagiarioslancanota[$i]['folha_id'] = $folha->id;
                else:
                    $estagiarioslancanota[$i]['folha_id'] = null;
                endif;
                if (isset($c_estagio->avaliacao->id)):
                    $estagiarioslancanota[$i]['avaliacao_id'] = $c_estagio->avaliacao->id;
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
