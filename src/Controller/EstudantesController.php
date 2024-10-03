<?php

declare(strict_types=1);

namespace App\Controller;

// use CakePdf\View\PdfView

/**
 * Estudantes Controller
 *
 * @property \App\Model\Table\EstudantesTable $Estudantes
 * @method \App\Model\Entity\Estudante[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class EstudantesController extends AppController {

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index($id = null) {

        /** Estudantes nao podem ver os dados dos outros estudantes */
        if ($this->getRequest()->getAttribute('identity')['categoria_id'] <> 2) {
            $estudantes = $this->paginate($this->Estudantes);
            $this->set(compact('estudantes'));
        } else {
            $this->Flash->error(__('Nao autorizado!'));
            return $this->redirect(['controller' => 'estudantes', 'action' => 'view', $id]);
        }
    }

    /**
     * View method
     *
     * @param string|null $id Estudante id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null) {

        if (!$id) {
            $id = $this->getRequest()->getAttribute('identity')['estudante_id'];
            if (empty($id)) {
                $this->Flash->error(__('Registro não localizado'));
                return $this->redirect('/Estudantes/index');
            }
        }
        $estudante = $this->Estudantes->get($id, [
            'contain' => ['Estagiarios' => ['Instituicaoestagios', 'Estudantes', 'Supervisores', 'Docentes', 'Turmaestagios'], 'Muralinscricoes' => 'Muralestagios'],
        ]);
        // pr($estudante);
        // die();
        $this->set(compact('estudante'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add($id = NULL) {

        /* Estes dados vêm da funcao add do UsersController. Envio paro o formulário */
        $registro = $this->getRequest()->getQuery('registro');
        $email = $this->getRequest()->getQuery('email');
        // pr($email);
        // die();

        /* Verifico se já está cadastrado */
        $estudantecadastrado = $this->Estudantes->find()
                ->where(['registro' => $registro])
                ->first();
        // pr($estudantecadastrado);
        // die();
        if ($estudantecadastrado):
            return $this->redirect(['view' => $estudantecadastrado->id]);
        endif;

        if ($this->request->is('post')) {

            $estudante = $this->Estudantes->newEmptyEntity();

            /**
             * Verifico se já é um usuário cadastrado.
             * Isto pode acontecer por exemplo quando para recuperar a senha é excluido o usuário.
             */
            $registroestudante = $this->request->getData('registro');
            $usercadastrado = $this->Estudantes->Userestagios->find()
                    ->where(['registro' => $registroestudante])
                    ->first();
            if (empty($usercadastrado)):
                $this->Flash->error(__('Estudante naõ cadastrado como usuário'));
                return $this->redirect('/userestagios/add');
            endif;
            // pr($estudante);
            // pr($this->request->getData()).
            // die();
            $estudante = $this->Estudantes->patchEntity($estudante, $this->request->getData());
            // debug($estudante);
            if ($this->Estudantes->save($estudante)) {
                $this->Flash->success(__('Estudante cadastrado 1.'));
                $estudanteultimo = $this->Estudantes->find()->orderDesc('id')->select(['id', 'registro'])->first();
                // pr($estudanteultimo->id);
                // die('estudanteultimo');

                /**
                 * Verifico se está preenchido o campo estudante_id na tabela Users.
                 * Primeiro busco o usuário.
                 */
                $userestagios = $this->Estudantes->Userestagios->find()
                        ->where(['registro' => $estudanteultimo->registro])
                        ->first();
                $userdata = $userestagios->toArray();
                // pr($userdata);
                // die();
                /**
                 * Se o estudante_id é diferente do id do estudante cadastrado na tabela Users, então atualizo a tabela Users com o valor do estudante_id.
                 */
                if ($userestagios->estudante_id <> $estudanteultimo->id) {
                    $userdata['estudante_id'] = $estudanteultimo->id;
                    $userestagiostabela = $this->fetchTable('Userestagios');
                    $userestagios = $this->Userestagios->patchEntity($userestagiostabela, $userdata);
                    // pr($userestagios);
                    // die('userestagios');
                    if ($this->Userestagios->save($userestagios)) {
                        $this->Flash->success(__('Usuário atualizado com o id do estudante'));
                        return $this->redirect(['action' => 'view', $estudanteultimo->id]);
                    } else {
                        $this->Flash->erro(__('Não foi possível atualizar a tabela Users com o id do estudante'));
                        debug($userestagios->getErrors());
                        die();
                    }
                }
            } else {
                debug($estudante)->getErrors();
                $this->Flash->error(__('Não foi possível cadastrar o estudante. Tente novamente.'));
                return $this->redirect(['action' => 'add?registro=' . $registro . '&' . 'email=' . $email]);
                // die('Error');
            }
        }

        $this->set(compact('estudantecadastrado', 'registro', 'email'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Estudante id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null) {

        $estudante = $this->Estudantes->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $estudante = $this->Estudantes->patchEntity($estudante, $this->request->getData());
            if ($this->Estudantes->save($estudante)) {
                $this->Flash->success(__('Registo de estudante atualizado.'));

                return $this->redirect(['action' => 'view', $id]);
            }
            $this->Flash->error(__('Registro de estudante no foi atualizado. Tente novamente.'));
        }
        $this->set(compact('estudante'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Estudante id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        $estudante = $this->Estudantes->get($id, [
            'contain' => ['Estagiarios']
        ]);
        if (sizeof($estudante->estagiarios) > 0) {
            $this->Flash->error(__('Estudante tem estagiarios associados.'));
            return $this->redirect(['controller' => 'estudantes', 'action' => 'view', $id]);
        }
        if ($this->Estudantes->delete($estudante)) {
            $this->Flash->success(__('Registro de estudante excluído.'));
        } else {
            $this->Flash->error(__('Registro de estudante não foi excluído. Tente novamente.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function planilhacress($id = NULL) {

        $periodo = !is_null($this->getRequest()->getQuery('periodo')) ? $this->getRequest()->getQuery('periodo') : NULL;
        // pr($periodo);
        // die();
        $ordem = 'Estudantes.nome';

        /* Todos os periódos */
        $periodototal = $this->Estudantes->Estagiarios->find('list', [
            'keyField' => 'periodo',
            'valueField' => 'periodo',
            'order' => 'periodo'
        ]);
        $periodos = $periodototal->toArray();
        /* Se o periodo não veio então o período é o último período */
        if (empty($periodo)) {
            $periodo = end($periodos);
        }
        // pr($periodos);

        $cressquery = $this->Estudantes->Estagiarios->find()
                ->contain(['Estudantes', 'Instituicaoestagios', 'Supervisores', 'Docentes'])
                ->select(['Estagiarios.periodo', 'Estudantes.id', 'Estudantes.nome', 'Instituicaoestagios.id', 'Instituicaoestagios.instituicao', 'Instituicaoestagios.cep', 'Instituicaoestagios.endereco', 'Instituicaoestagios.bairro', 'Supervisores.nome', 'Supervisores.cress', 'Docentes.nome'])
                ->where(['Estagiarios.periodo' => $periodo])
                ->order(['Estudantes.nome']);

        $cress = $cressquery->all();
        // pr($cress);
        // die();
        $this->set('cress', $cress);
        $this->set('periodos', $periodos);
        $this->set('periodoselecionado', $periodo);
        // die();
    }

    public function planilhaseguro($id = NULL) {

        $periodo = $this->getRequest()->getQuery('periodo');

        $ordem = 'nome';

        $periodototal = $this->Estudantes->Estagiarios->find('list', [
            'keyField' => 'periodo',
            'valueField' => 'periodo',
            'order' => 'periodo'
        ]);
        $periodos = $periodototal->toArray();

        if (empty($periodo)) {
            $periodo = end($periodos);
        }

        $seguroquery = $this->Estudantes->Estagiarios->find()
                ->contain(['Estudantes', 'Instituicaoestagios'])
                ->where(['Estagiarios.periodo' => $periodo])
                ->select([
                    'Estudantes.id',
                    'Estudantes.nome',
                    'Estudantes.cpf',
                    'Estudantes.nascimento',
                    'Estudantes.registro',
                    'Estagiarios.nivel',
                    'Estagiarios.periodo',
                    'Instituicaoestagios.instituicao'
                ])
                ->order(['Estagiarios.nivel']);

        $seguro = $seguroquery->all();

        $i = 0;
        foreach ($seguro as $c_seguro) {
            // pr($c_seguro);
            // die();
            if ($c_seguro->nivel == 1) {

                // Início
                $inicio = $c_seguro->periodo;

                // Final
                $semestre = explode('-', $c_seguro->periodo);
                $ano = $semestre[0];
                $indicasemestre = $semestre[1];

                if ($indicasemestre == 1) {
                    $novoano = $ano + 1;
                    $novoindicasemestre = $indicasemestre + 1;
                    $final = $novoano . "-" . $novoindicasemestre;
                } elseif ($indicasemestre == 2) {
                    $novoano = $ano + 2;
                    $final = $novoano . "-" . 1;
                }
            } elseif ($c_seguro->nivel == 2) {

                $semestre = explode('-', $c_seguro->periodo);
                $ano = $semestre[0];
                $indicasemestre = $semestre[1];

                // Início
                if ($indicasemestre == 1) {
                    $novoano = $ano - 1;
                    $inicio = $novoano . "-" . 2;
                } elseif ($indicasemestre == 2) {
                    $inicio = $ano . "-" . "1";
                }

                // Final
                if ($indicasemestre == 1) {
                    $novoano = $ano + 1;
                    $final = $novoano . "-" . 1;
                } elseif ($indicasemestre == 2) {
                    $novoano = $ano + 1;
                    $final = $novoano . "-" . "2";
                }
            } elseif ($c_seguro->nivel == 3) {

                $semestre = explode('-', $c_seguro->periodo);
                $ano = $semestre[0];
                $indicasemestre = $semestre[1];

                // Início
                $novoano = $ano - 1;
                $inicio = $novoano . "-" . $indicasemestre;

                // Final
                if ($indicasemestre == 1) {
                    // $ano = $ano + 1;
                    $final = $ano . "-" . 2;
                } elseif ($indicasemestre == 2) {
                    $novoano = $ano + 1;
                    $final = $novoano . "-" . 1;
                }
            } elseif ($c_seguro->nivel == 4) {

                $semestre = explode('-', $c_seguro->periodo);
                $ano = $semestre[0];
                $indicasemestre = $semestre[1];

                // Início
                if ($indicasemestre == 1) {
                    $ano = $ano - 2;
                    $inicio = $ano . "-" . 2;
                } elseif ($indicasemestre == 2) {
                    $ano = $ano - 1;
                    $inicio = $ano . "-" . 1;
                }

                // Final
                $final = $c_seguro->periodo;

                // Estagio não obrigatório. Conto como estágio 5
            } elseif ($c_seguro->nivel == 9) {

                $semestre = explode('-', $c_seguro->periodo);
                $ano = $semestre[0];
                $indicasemestre = $semestre[1];

                // Início
                if ($indicasemestre == 1) {
                    $ano = $ano - 2;
                    $inicio = $ano . "-" . 1;
                } elseif ($indicasemestre == 2) {
                    $ano = $ano - 2;
                    $inicio = $ano . "-" . 2;
                }

                // Final
                $final = $c_seguro->periodo;

                // echo "Nível: " . $c_seguro['Estagiario']['nivel'] . " Período: " . $c_seguro['Estagiario']['periodo'] . " Início: " . $inicio . " Final: " . $final . '<br>';
            }

            $t_seguro[$i]['id'] = $c_seguro->estudante->id;
            $t_seguro[$i]['nome'] = $c_seguro->estudante->nome;
            $t_seguro[$i]['cpf'] = $c_seguro->estudante->cpf;
            $t_seguro[$i]['nascimento'] = $c_seguro->estudante->nascimento;
            $t_seguro[$i]['sexo'] = "";
            $t_seguro[$i]['registro'] = $c_seguro->estudante->registro;
            $t_seguro[$i]['curso'] = "UFRJ/Serviço Social";
            if ($c_seguro->nivel == 9):
                // pr("Não");
                $t_seguro[$i]['nivel'] = "Não obrigatório";
            else:
                // pr($c_seguro['Estagiario']['nivel']);
                $t_seguro[$i]['nivel'] = $c_seguro->nivel;
            endif;
            $t_seguro[$i]['periodo'] = $c_seguro->periodo;
            $t_seguro[$i]['inicio'] = $inicio;
            $t_seguro[$i]['final'] = $final;
            $t_seguro[$i]['instituicao'] = $c_seguro->instituicaoestagio->instituicao;
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

    public function certificadoperiodo($id = NULL) {
        /**
         * Autorização. Verifica se o estudante cadastrado no Users está acessando seu próprio registro.
         */
        if ($this->getRequest()->getAttribute('identity')['categoria_id'] == '2') {
            $estudante_id = $this->getRequest()->getAttribute('identity')['estudante_id'];
            if ($id == $estudante_id) {
                /**
                 * @var $option
                 * Para consultar a tabela estudantes com o id.
                 */
                $option = "id = $estudante_id";
                // echo "Estudante Id autorizado";
            } else {
                $estudante_registro = $this->getRequest()->getAttribute('identity')['registro'];
                if ($estudante_registro == $this->getRequest()->getQuery('registro')) {
                    /**
                     * @var $option
                     * Para consultar a tabela estudantes com o registro
                     */
                    $option = "Estudantes.registro  =  $estudante_registro";
                    // echo "Estudante registro autorizado";
                } else {
                    // echo "Registros não coincidem" . "<br>";
                    $this->Flash->error(__('1. Operação não autorizada.'));
                    return $this->redirect(['controller' => 'Estudantes', 'action' => 'certificadoperiodo?registro=' . $this->getRequest()->getAttribute('identity')['registro']]);
                    die('Estudante não autorizado.');
                }
            }
        } elseif ($this->getRequest()->getAttribute('identity')['categoria_id'] == '1') {
            echo "Administrador autorizado";
        } else {
            $this->Flash->error(__('2. Operação não autorizada.'));
            return $this->redirect(['controller' => 'Muralestagios', 'action' => 'index']);
            die('Professores e Supervisores não autorizados');
        }

        /**
         * Consulto a tabela estudantes com o registro ou o id
         */
        $estudante = $this->Estudantes->find()
                ->where([$option])
                ->first();
        /**
         * Calculo a partir do ingresso em que periodo o estudante esté neste momento.
         */
        /* Capturo o periodo do calendario academico atual */
        $configuracaotabela = $this->fetchTable('Configuracoes');
        $periodoacademicoatual = $configuracaotabela->find()->select(['periodo_calendario_academico'])->first();
        // pr($periodoacademicoatual);
        // die();
        /**
         * Separo o periodo em duas partes: o ano e o indicador de primeiro ou segundo semestre.
         */
        $periodo_atual = $periodoacademicoatual->periodo_calendario_academico;
        /** Capturo o periodo inicial para o cálculo dos semetres.
         *  Inicialmente coincide com o campo de ingresso.
         *  Mas pode ser alterada para fazer coincider os semestres no casos dos alunos que trancaram.
         */
        $novoperiodo = $this->getRequest()->getData('novoperiodo');
        if ($novoperiodo) {
            $periodo_inicial = $this->getRequest()->getData('novoperiodo');
        } else {
            $periodo_inicial = $estudante->ingresso;
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
            return $this->redirect(['controller' => 'Estudantes', 'action' => 'certificadoperiodo', '?' => ['registro' => $this->getRequest()->getAttribute('identity')['registro']]]);
        }

        // pr($totalperiodos);
        if (isset($this->getRequest()->getData()['novoperiodo'])) {
            $estudante->periodonovo = $this->getRequest()->getData()['novoperiodo'];
        } else {
            $estudante->periodonovo = $estudante->ingresso;
        }

        // pr($estudante);
        // die();
        $this->set('estudante', $estudante);
        $this->set('totalperiodos', $totalperiodos);
    }

    public function certificadoperiodopdf($id = NULL) {

        $this->layout = false;
        $id = $this->getRequest()->getQuery('id');
        $totalperiodos = $this->getRequest()->getQuery('totalperiodos');

        if (is_null($id)) {
            $this->cakeError('error404');
        } else {
            $estudante = $this->Estudantes->find()
                    ->contain([])
                    ->where(['Estudantes.id' => $id])
                    ->first();
        }
        // pr($id);
        // pr($totalperiodos);
        // pr($estudante);
        // die('estudante');

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

        $this->set('estudante', $estudante);
        $this->set('totalperiodos', $totalperiodos);
    }
}
