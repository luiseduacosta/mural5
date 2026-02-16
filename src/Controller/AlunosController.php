<?php

declare(strict_types=1);

namespace App\Controller;

// use CakePdf\View\PdfView

/**
 * Alunos Controller
 *
 * @property \App\Model\Table\AlunosTable $Alunos
 * @method \App\Model\Entity\Aluno[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AlunosController extends AppController {

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index($id = null) {

        /** Alunos não podem ver os dados dos outros alunos */
        if ($this->getRequest()->getAttribute('identity')['categoria_id'] != 2) {
            $alunos = $this->paginate($this->Alunos);
            $this->set(compact('alunos'));
        } else {
            $this->Flash->error(__('Não autorizado!'));
            return $this->redirect(['controller' => 'alunos', 'action' => 'view', $this->getRequest()->getAttribute('identity')['aluno_id']]);
        }
    }

    /**
     * View method
     *
     * @param string|null $id Aluno id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null) {

        $aluno = $this->Alunos->find()
            ->contain(['Estagiarios' => ['Instituicoes', 'Alunos', 'Supervisores', 'Professores', 'Turmaestagios'], 'Inscricoes' => ['Muralestagios']])
            ->where(['id' => $id])
            ->first();

        if (!isset($aluno)) {
            $this->Flash->error(__('Nao ha registros para esse id!'));
            return $this->redirect(['action' => 'index']);
        }

        $this->set(compact('aluno'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add($id = NULL) {

        /* Estes dados vêm da função add ou login do UsersController. Envio paro o formulário */
        $registro = $this->getRequest()->getQuery('registro');
        $email = $this->getRequest()->getQuery('email');

        /** Envio para o formulário */
        if ($registro) {
            $this->set('registro', $registro);
        }
        if ($email) {
            $this->set('email', $email);
        }

        /* Verifico se já está cadastrado */
        if ($registro) {
            $estudantecadastrado = $this->Alunos->find()
                    ->where(['registro' => $registro])
                    ->first();

            if ($estudantecadastrado):
                $this->Flash->error(__('Aluno já cadastrado'));
                return $this->redirect(['view' => $estudantecadastrado->id]);
            endif;
        }

        $aluno = $this->Alunos->newEmptyEntity();

        if ($this->request->is('post')) {

            /**
             * Verifico se já é um usuário cadastrado no users.
             * Isto pode acontecer por exemplo quando para recuperar a senha é excluido o usuário.
             */
            $registro = $this->request->getData('registro');
            $usercadastrado = $this->fetchTable('Users')->find()
                    ->where(['categoria_id' => 2, 'registro' => $registro])
                    ->first();
            if (empty($usercadastrado)):
                $this->Flash->error(__('Aluno naõ cadastrado como usuário'));
                return $this->redirect('/users/add');
            endif;

            $alunoresultado = $this->Alunos->patchEntity($aluno, $this->request->getData());

            if ($this->Alunos->save($alunoresultado)) {
                $this->Flash->success(__('Aluno cadastrado 1.'));

                /**
                 * Verifico se está preenchido o campo aluno_id na tabela Users.
                 * Primeiro busco o usuário.
                 */
                $userestagioestudante = $this->fetchTable('Users')->find()
                        ->where(['categoria_id' => 2, 'aluno_id' => $alunoresultado->id])
                        ->first();

                /**
                 * Se a busca retorna vazia então atualizo a tabela Users com o valor do aluno_id.
                 */
                if (empty($userestagioestudante)) {

                    $userestagio = $this->fetchTable('Users')->find()
                            ->where(['categoria_id' => 2, 'registro' => $alunoresultado->registro])
                            ->first();

                    $userdata = $userestagio->toArray();
                    $userdata['aluno_id'] = $alunoresultado->id;        
                    $user_entity = $this->fetchTable('Users')->get($userestagio->id);
                    /** Atualiza */
                    $userestagioresultado = $this->Alunos->Users->patchEntity($user_entity, $userdata);
                    if ($this->Alunos->Users->save($userestagioresultado)) {
                        $this->Flash->success(__('Usuário atualizado com o id do aluno'));
                        return $this->redirect(['action' => 'view', $alunoresultado->id]);
                    } else {
                        $this->Flash->erro(__('Não foi possível atualizar a tabela Users com o id do aluno'));
                        // debug($users->getErrors());
                        return $this->redirect(['controller' => 'Users', 'action' => 'logout']);
                    }
                }
                return $this->redirect(['controller' => 'Alunos', 'action' => 'view', $alunoresultado->id]);
            } else {
                // debug($aluno)->getErrors();
                $this->Flash->error(__('Não foi possível cadastrar o aluno. Tente novamente.'));
                return $this->redirect(['action' => 'add', '?' => ['registro' => $registro, 'email' => $email]]);
            }
        } // Finaliza post

        $this->set(compact('aluno'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Aluno id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null) {

        $aluno = $this->Alunos->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $alunoresultado = $this->Alunos->patchEntity($aluno, $this->request->getData());
            if ($this->Alunos->save($alunoresultado)) {
                $this->Flash->success(__('Registo de aluno atualizado.'));

                return $this->redirect(['action' => 'view', $id]);
            }
            $this->Flash->error(__('Registro de aluno não foi atualizado. Tente novamente.'));
        }
        $this->set(compact('aluno'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Aluno id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null) {

        $this->request->allowMethod(['post', 'delete']);
        $aluno = $this->Alunos->get($id, [
            'contain' => ['Estagiarios']
        ]);
        if (sizeof($aluno->estagiarios) > 0) {
            $this->Flash->error(__('Aluno tem estagiários associados.'));
            return $this->redirect(['controller' => 'alunos', 'action' => 'view', $id]);
        }
        if ($this->Alunos->delete($aluno)) {
            $this->Flash->success(__('Registro de aluno excluído.'));
        } else {
            $this->Flash->error(__('Registro de aluno não foi excluído. Tente novamente.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Planilha de CRESS
     *
     * @param string|null $id Aluno id, periodo, ordem.
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function planilhacress($id = NULL) {

        $periodo = $this->getRequest()->getQuery('periodo');

        $ordem = 'Alunos.nome';

        /* Todos os periódos */
        $periodototal = $this->Alunos->Estagiarios->find('list', [
            'keyField' => 'periodo',
            'valueField' => 'periodo',
            'order' => 'periodo'
        ]);
        $periodos = $periodototal->toArray();
        /* Se o periodo não veio anexo como parametro então o período é o último da lista dos períodos */
        if (empty($periodo)) {
            $periodo = end($periodos);
        }
        // pr($periodos);

        $cress = $this->Alunos->Estagiarios->find()
                ->contain(['Alunos', 'Instituicoes', 'Supervisores', 'Professores'])
                ->select(['Estagiarios.periodo', 'Alunos.id', 'Alunos.nome', 'Instituicoes.id', 'Instituicoes.instituicao', 'Instituicoes.cep', 'Instituicoes.endereco', 'Instituicoes.bairro', 'Supervisores.nome', 'Supervisores.cress', 'Professores.nome'])
                ->where(['Estagiarios.periodo' => $periodo])
                ->order(['Alunos.nome'])
                ->all();

        // pr($cress);
        // die();
        $this->set('cress', $cress);
        $this->set('periodos', $periodos);
        $this->set('periodoselecionado', $periodo);
        // die();
    }

    /**
     * Planilha para seguro de vida dos alunos estagiários
     *
     * @param string|null $id Aluno id.
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function planilhaseguro($id = NULL) {

        $periodo = $this->getRequest()->getQuery('periodo');

        $ordem = 'nome';

        $periodototal = $this->Alunos->Estagiarios->find('list', [
            'keyField' => 'periodo',
            'valueField' => 'periodo',
            'order' => 'periodo'
        ]);
        $periodos = $periodototal->toArray();

        if (empty($periodo)) {
            $periodo = end($periodos);
        }

        $seguro = $this->Alunos->Estagiarios->find()
                ->contain(['Alunos', 'Instituicoes'])
                ->where(['Estagiarios.periodo' => $periodo])
                ->select([
                    'Alunos.id',
                    'Alunos.nome',
                    'Alunos.cpf',
                    'Alunos.nascimento',
                    'Alunos.registro',
                    'Estagiarios.nivel',
                    'Estagiarios.periodo',
                    'Instituicoes.instituicao',
                    'Estagiarios.ajuste2020'
                ])
                ->order(['Estagiarios.nivel'])
                ->all();

        $i = 0;
        // Calcula o inicio e o final do estagio para 4 periodos de 6 meses a partir do periodo selecionado
        /*
        One strategy is to calculate the start and them the end dates of the internship for 4 periods of 6 months or 3 periods of 6 months from the selected period.
        If the semestre of the inicial period (nivel 1) is 1, then when ajuste 2020 is 0 then the end period is (ano + 1 e semestre = 2 or when ajuste2020 is 1 then the end period is ano + 1 e semestre = 1).
        If the semestre of the inicial period (nivel 1) is 2, then when ajuste2020 is 0 then the end period is (ano + 2 e semestre = 1 or when ajuste2020 is 1 then the end period is ano + 1 e semestre = 2).
        */
        $t_seguro = [];
        $inicio = null;
        $final = null;
        foreach ($seguro as $c_seguro) {
            $ajuste2020 = $c_seguro->ajuste2020;
            // Calula o inicio do estágio
            $semestre = explode('-', $c_seguro->periodo);
            $ano = $semestre[0];
            $semestre = $semestre[1];
            switch ($c_seguro->nivel) {
                case 1:
                    $inicio = $ano . "-" . $semestre;
                    break;
                case 2: // retrocede 1 semestre
                    // Ex. 2024-1 -> 2023-2
                    if ($semestre == 1) {
                        $ano = $ano - 1;
                        $semestre = 2;
                        // Ex. 2024-2 -> 2024-1
                    } elseif ($semestre == 2) {
                        $ano = $ano +0; // não altera
                        $semestre = 1;
                    }
                    break;
                case 3: // retrocede 2 semestres
                    // Ex. 2024-1 -> 2023-1
                    if ($semestre == 1) {
                        $ano = $ano - 1;
                        $semestre = 1;
                        // Ex. 2024-2 -> 2023-2
                    } elseif ($semestre == 2) {
                        $ano = $ano - 1;
                        $semestre = 2;
                    }
                    break;
                case 4: // retrocede 3 semestres
                    // Ex. 2010-1 -> 2008-2
                    if ($semestre == 1) {
                        $ano = $ano - 2;
                        $semestre = 2;
                        // Ex. 2010-2 -> 2009-1
                    } elseif ($semestre == 2) {
                        $ano = $ano - 1;
                        $semestre = 1;
                    }
                    break;
                case 9: // retrocede 4 ou 5 semestres em função do ajuste2020
                    if ($ajuste2020 == 1) { // retrocede 4 semestres
                        if ($semestre == 1) { // Ex. 2024-1 -> 2022-2
                            $ano = $ano - 2;
                            $semestre = 2;
                        } elseif ($semestre == 2) { // Ex. 2024-2 -> 2023-1
                            $ano = $ano - 1;
                            $semestre = 1;
                        } 
                    } elseif ($ajuste2020 == 0) { // retrocede 5 semestres
                        if ($semestre == 1) { // Ex. 2024-1 -> 2022-1
                            $ano = $ano - 2;
                            $semestre = 1;
                        } elseif ($semestre == 2) { // Ex. 2024-2 -> 2022-2
                            $ano = $ano - 2;
                            $semestre = 2;
                        }
                    }
                    break;
            }
            $inicio = $ano . "-" . $semestre;
            
            // Calcula o final do estágio: $inicio + 2 ou 3 semestres dependendo do ajuste2020
            // Números $ano e $semestre são os valores do inicio do estágio
            switch ($ajuste2020 ) {
                case 0: // 4 semestres
                    // Ex. 2024-1 -> 2025-2
                    if ($semestre == 1) {
                        $final = ($ano + 1) . "-" . 2;
                        // Ex. 2024-2 -> 2026-1
                    } elseif ($semestre == 2) {
                        $final = ($ano + 2) . "-" . 1;
                    }
                    break;
                case 1: // 3 semestres
                    // Ex. 2024-1 -> 2025-1
                    if ($semestre == 1) {
                        $final = ($ano + 1) . "-" . 1;
                        // Ex. 2024-2 -> 2025-2
                    } elseif ($semestre == 2) {
                        $final = ($ano + 1) . "-" . 2;
                    }
                    break;
            }

            // echo "Nível: " . $c_seguro['Estagiario']['nivel'] . " Período: " . $c_seguro['Estagiario']['periodo'] . " Início: " . $inicio . " Final: " . $final . '<br>';

            $t_seguro[$i]['id'] = $c_seguro->aluno->id;
            $t_seguro[$i]['nome'] = $c_seguro->aluno->nome;
            $t_seguro[$i]['cpf'] = $c_seguro->aluno->cpf;
            $t_seguro[$i]['nascimento'] = $c_seguro->aluno->nascimento;
            $t_seguro[$i]['sexo'] = "";
            $t_seguro[$i]['registro'] = $c_seguro->aluno->registro;
            $t_seguro[$i]['curso'] = "UFRJ/Serviço Social";
            if ($c_seguro->nivel == 9):
                $t_seguro[$i]['nivel'] = "Não obrigatório";
            else:
                $t_seguro[$i]['nivel'] = $c_seguro->nivel;
            endif;
            $t_seguro[$i]['periodo'] = $c_seguro->periodo;
            $t_seguro[$i]['inicio'] = $inicio;
            $t_seguro[$i]['final'] = $final;
            $t_seguro[$i]['instituicao'] = $c_seguro->instituicao->instituicao;
            $criterio[$i] = $t_seguro[$i][$ordem];

            $i++;
        }

        if (!empty($t_seguro)) {
            array_multisort($criterio, SORT_ASC, $t_seguro);
        }
        // pr($t_seguro);
        $this->set('t_seguro', $t_seguro);
        $this->set('periodos', $periodos);
        $this->set('periodoselecionado', $periodo);
        // die();
    }

    /**
     * Método para gerar o certificado de período do aluno.
     * 
     * @param int|null $id
     * @return void
     */
    public function certificadoperiodo($id = NULL) {
        /**
         * Autorização. Verifica se o aluno cadastrado no Users está acessando seu próprio registro.
         */
        if ($this->getRequest()->getAttribute('identity')['categoria_id'] == '2') {
            $aluno_id = $this->getRequest()->getAttribute('identity')['aluno_id'];
            if ($id != $aluno_id) {
                $this->Flash->error(__('Usuario nao autorizado.'));
                return $this->redirect(['controller' => 'Muralestagios', 'action' => 'index']);
                // echo "Aluno Id autorizado";
            }
        } elseif ($this->getRequest()->getAttribute('identity')['categoria_id'] == '1') {
            echo "Administrador autorizado";
        } else {
            $this->Flash->error(__('Usuario nao autorizado.'));
            return $this->redirect(['controller' => 'Muralestagios', 'action' => 'index']);
            // die('Professores e Supervisores não autorizados');
        }

        /**
         * Consulto a tabela alunos com o registro ou com o id
         */
        $aluno = $this->Alunos->find()
                ->where(['id' => $id])
                ->first();
        /**
         * Calculo a partir do ingresso em que periodo o aluno esté neste momento.
         */
        /* Capturo o periodo do calendario academico atual */
        $configuracaotabela = $this->fetchTable('Configuracoes');
        $configuracoes = $configuracaotabela->find()->select(['periodo_calendario_academico'])->first();
        /**
         * Separo o periodo em duas partes: o ano e o indicador de primeiro ou segundo semestre.
         */
        $periodo_atual = $configuracoes->periodo_calendario_academico;
        /** Capturo o periodo inicial para o cálculo dos semetres.
         *  Inicialmente coincide com o campo de ingresso.
         *  Mas pode ser alterada para fazer coincider os semestres no casos dos alunos que trancaram.
         */
        $novoperiodo = $this->getRequest()->getData('novoperiodo');
        if ($novoperiodo) {
            $periodo_inicial = $this->getRequest()->getData('novoperiodo');
        } else {
            $periodo_inicial = $aluno->ingresso;
        }

        $inicial = explode('-', $periodo_inicial);
        $atual = explode('-', $periodo_atual);
        // echo $atual[0] . ' ' . $inicial[0] . '<br>';

        /**
         * Calculo o total de semestres
         */
        $semestres = (($atual[0] - $inicial[0]) + 1) * 2;
        // pr($semestres);

        /** Se começa no semestre 1 e finaliza no 2 então são anos inteiros */
        if (($inicial[1] == 1) && ($atual[1] == 2)) {
            $totalperiodos = $semestres;
        }

        /** Se começa no semestre 1 e finaliza no 1 então perdeu um semestre (o segundo semestre atual) */
        if (($inicial[1] == 1) && ($atual[1] == 1)) {
            $totalperiodos = $semestres - 1;
        }

        /** Se começa no semestre 2 e finaliza no 2 então perdeu um semestre (o primeiro semestre inicial) */
        if (($inicial[1] == 2) && ($atual[1] == 2)) {
            $totalperiodos = $semestres - 1;
        }

        /** Se começa no semestre 2 e finaliza no semestre 1 então perdeu dois semestres (o primeiro do ano inicial e o segundo do ano atual) */
        if (($inicial[1] == 2) && ($atual[1] == 1)) {
            $totalperiodos = $semestres - 2;
        }

        /** Se o período inicial é maior que o período atual então informar que há um erro */
        if ($totalperiodos <= 0) {
            $this->Flash->error(__('Error: período inicial é maior que período atual'));
            return $this->redirect(['controller' => 'Alunos', 'action' => 'certificadoperiodo', $id]);
        }

        $this->set('aluno', $aluno);
        $this->set('totalperiodos', $totalperiodos);
    }

    /**
     * Método para gerar o PDF do certificado de período do aluno.
     * 
     * @param int|null $id
     * @return void
     */    
    public function certificadoperiodopdf($id = NULL) {

        $this->layout = false;
        $id = $this->getRequest()->getQuery('id');
        $totalperiodos = $this->getRequest()->getQuery('totalperiodos');

        if ($id === null) {
            $this->Flash->error(__('Error: ID do aluno não informado'));
            return $this->redirect(['controller' => 'Alunos', 'action' => 'certificadoperiodo', $id]);
        } else {
            $aluno = $this->Alunos->find()
                    ->contain([])
                    ->where(['Alunos.id' => $id])
                    ->first();
        }

        $this->viewBuilder()->enableAutoLayout(false);
        $this->viewBuilder()->setClassName('CakePdf.Pdf');
        $this->viewBuilder()->setOption(
                'pdfConfig',
                [
                    'orientation' => 'portrait',
                    'download' => true, // This can be omitted if "filename" is specified.
                    'filename' => 'declaracao_de_periodo_' . $id . '.pdf' //// This can be omitted if you want file name based on URL.
                ]
        );

        $this->set('aluno', $aluno);
        $this->set('totalperiodos', $totalperiodos);
    }

    /**
     * Método para calcular a carga horária total dos alunos.
     * 
     * @param string|null $ordem
     * @return void
     */
    public function cargahoraria($ordem = null) {
        /** Aumenta a memória */
        ini_set('memory_limit', '2048M');
        $ordem = $this->getRequest()->getQuery('ordem');

        if (empty($ordem)):
            $ordem = 'q_semestres';
        endif;

        // pr($ordem);
        // die();

        $alunos = $this->Alunos->find()->contain(['Estagiarios'])->toArray();

        $i = 0;
        foreach ($alunos as $aluno):
            // pr($aluno->estagiarios);
            $cargahorariatotal[$i]['id'] = $aluno['Aluno']['id'] ?? null;
            $cargahorariatotal[$i]['registro'] = $aluno['Aluno']['registro'] ?? null;
            $cargahorariatotal[$i]['q_semestres'] = sizeof($aluno['estagiarios']) > 0 ? sizeof($aluno['estagiarios']) : null;
            $carga_estagio['ch'] = null;
            $y = 0;
            foreach ($aluno['estagiarios'] as $estagiario):
                // pr($estagiario);
                // die();
                if ($estagiario['nivel'] == 1):
                    $cargahorariatotal[$i][$y]['ch'] = $estagiario['ch'] != 0 ? $estagiario['ch'] : null;
                    $cargahorariatotal[$i][$y]['nivel'] = $estagiario['nivel'];
                    $cargahorariatotal[$i][$y]['periodo'] = $estagiario['periodo'];
                    $carga_estagio['ch'] = $carga_estagio['ch'] + $estagiario['ch'];
                // $criterio[$i][$ordem] = $c_estagio['periodo'];
                else:
                    $cargahorariatotal[$i][$y]['ch'] = $estagiario['ch'];
                    $cargahorariatotal[$i][$y]['nivel'] = $estagiario['nivel'];
                    $cargahorariatotal[$i][$y]['periodo'] = $estagiario['periodo'];
                    $carga_estagio['ch'] = $carga_estagio['ch'] + $estagiario['ch'];
                // $criterio[$i][$ordem] = NULL;
                endif;
                $y++;
            endforeach;
            $cargahorariatotal[$i]['ch_total'] = $carga_estagio['ch'];
            $criterio[$i] = $cargahorariatotal[$i][$ordem];
            $i++;
            // endif;
        endforeach;

        array_multisort($criterio, SORT_ASC, $cargahorariatotal);
        // pr($cargahorariatotal);
        // die();
        $this->set('cargahorariatotal', $cargahorariatotal);
        // die();
    }
}
