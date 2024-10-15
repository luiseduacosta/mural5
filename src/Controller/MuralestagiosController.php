<?php

declare(strict_types=1);

namespace App\Controller;

/**
 * Muralestagios Controller
 *
 * @property \App\Model\Table\MuralestagiosTable $Muralestagios
 * @method \App\Model\Entity\Muralestagio[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class MuralestagiosController extends AppController {

    public function beforeFilter(\Cake\Event\EventInterface $event) {
        parent::beforeFilter($event);
        // Configure the login action to not require authentication, preventing
        // the infinite redirect loop issue
        $this->Authentication->addUnauthenticatedActions(['index', 'view']);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index($id = NULL) {

        $periodo = $this->getRequest()->getQuery('periodo');

        if (empty($periodo)) {
            $configuracaotabela = $this->fetchTable('Configuracoes');
            $periodo_atual = $configuracaotabela->find()->select(['mural_periodo_atual'])->first();
            $periodo = $periodo_atual->mural_periodo_atual;
        }

        if ($periodo) {
            $muralestagios = $this->Muralestagios->find('all', [
                'conditions' => ['Muralestagios.periodo' => $periodo],
                'order' => ['dataInscricao' => 'DESC']
            ]);
        } else {
            $muralestagios = $this->Muralestagios->find('all');
        }
        $this->set('muralestagios', $this->paginate($muralestagios));

        /** Obtenho todos os periódos em forma de lista */
        $periodototal = $this->Muralestagios->find('list', [
            'keyField' => 'periodo',
            'valueField' => 'periodo'
        ]);
        $periodos = $periodototal->toArray();

        $this->set('periodos', $periodos);
        $this->set('periodo', $periodo);
    }

    /**
     * View method
     *
     * @param string|null $id Muralestagio id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null) {

        $muralestagio = $this->Muralestagios->get($id, [
            'contain' => ['Instituicoes' => ['Turmaestagios'], 'Professores', 'Inscricoes' => ['Alunos']]
        ]);

        if (!isset($muralestagio)) {
            $this->Flash->error(__('Nao ha registros de mural de estagio para esse numero!'));
            return $this->redirect(['action' => 'index']);
        }

        $this->set(compact('muralestagio'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add() {

        if (empty($periodo)) {
            $configuracaotabela = $this->fetchTable('Configuracoes');
            $periodoconfiguracao = $configuracaotabela->find()
                    ->first();
            $periodo = $periodoconfiguracao->mural_periodo_atual;
        }
        $muralestagio = $this->Muralestagios->newEmptyEntity();
        if ($this->request->is('post')) {

            // pr($this->request->getData('instituicao_id'));
            $instituicao = $this->Muralestagios->Instituicoes->find()
                    ->where(['id' => $this->request->getData('instituicao_id')])
                    ->select(['instituicao'])
                    ->first();
            // pr($instituicao);
            $dados = $this->request->getData();
            $dados['instituicao'] = $instituicao->instituicao;
            // pr($dados);
            // die();
            $muralestagio = $this->Muralestagios->patchEntity($muralestagio, $dados);
            if ($this->Muralestagios->save($muralestagio)) {
                $this->Flash->success(__('Registo de novo mural de estágio feito.'));
                return $this->redirect(['action' => 'view', $muralestagio->id]);
            } else {
                $this->Flash->error(__('Registro de mural de estágio não foi feito. Tente novamente.'));
            }
        }
        /** Envio para fazer o formulário de cadastramento do mural */
        $instituicoes = $this->Muralestagios->Instituicoes->find('list');
        $turmaestagios = $this->Muralestagios->Turmaestagios->find('list');
        $professores = $this->Muralestagios->Professores->find('list');
        $this->set(compact('muralestagio', 'instituicoes', 'turmaestagios', 'professores', 'periodo'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Muralestagio id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null) {

        $query = $this->Muralestagios->find('all', [
            'fields' => ['periodo'],
            'group' => ['periodo'],
            'order' => ['periodo']
        ]);
        $periodos = $query->all()->toArray();
        foreach ($query as $c_periodo) {
            $periodostotal[$c_periodo->periodo] = $c_periodo->periodo;
        }

        $muralestagio = $this->Muralestagios->get($id, [
            'contain' => ['Instituicoes'],
        ]);
        // pr($this->request->getData());
        // die();
        if ($this->request->is(['patch', 'post', 'put'])) {
            // pr($this->request->getData());
            $muralestagio = $this->Muralestagios->patchEntity($muralestagio, $this->request->getData());
            // pr($muralestagio);
            // die();
            if ($this->Muralestagios->save($muralestagio)) {
                $this->Flash->success(__('Registro muralestagio atualizado.'));
                return $this->redirect(['action' => 'view', $id]);
            }
            $this->Flash->error(__('No foi possível atualizar o registro. Tente novamente.'));
        }
        $instituicoes = $this->Muralestagios->Instituicoes->find('list');
        $turmaestagios = $this->Muralestagios->Turmaestagios->find('list');
        $professores = $this->Muralestagios->Professores->find('list');
        $this->set(compact('muralestagio', 'instituicoes', 'turmaestagios', 'professores', 'periodostotal'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Muralestagio id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        $muralestagio = $this->Muralestagios->get($id, [
            'contain' => ['Inscricoes']
        ]);
        if (sizeof($muralestagio->inscricoes) > 0) {
            $this->Flash->error(__('Mural de estágio com inscrições'));
            return $this->redirect(['action' => 'view', $id]);
        }
        if ($this->Muralestagios->delete($muralestagio)) {
            $this->Flash->success(__('Registro muralestagio excluído.'));
        } else {
            $this->Flash->error(__('Registro muralestagio não foi excluído. Tente novamente.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
