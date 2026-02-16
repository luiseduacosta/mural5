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

        /** Autorização */
        // Everybody can access this page

        $periodo = $this->getRequest()->getQuery('periodo');

        if (empty($periodo)) {
            $configuracaotabela = $this->fetchTable('Configuracoes');
            $configuracoes = $configuracaotabela->find()->select(['mural_periodo_atual'])->first();
            $periodo = $configuracoes->mural_periodo_atual;
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

        /** Autorização */
        // Everybody that is logged in can access this page
        if (!$this->user->isAdmin() || $this->user->isStudent() || $this->user->isProfessor() || $this->user->isSupervisor()) {
            $this->Flash->error(__('Usuario nao autorizado.'));
            return $this->redirect(['controller' => 'Muralestagios', 'action' => 'index']);
        }

        $muralestagio = $this->Muralestagios->get($id, [
            'contain' => ['Instituicoes', 'Professores', 'Inscricoes' => ['Alunos']]
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

        /** Autorização */
        // Only admin can access this page
        if (!$this->user->isAdmin()) {
            $this->Flash->error(__('Usuario nao autorizado.'));
            return $this->redirect(['controller' => 'Muralestagios', 'action' => 'index']);
        }

        $periodo = $this->getRequest()->getQuery('periodo');

        if (empty($periodo)) {
            $configuracaotabela = $this->fetchTable('Configuracoes');
            $configuracoes = $configuracaotabela->find()
                    ->first();
            $periodo = $configuracoes->mural_periodo_atual;
        }
        $muralestagio = $this->Muralestagios->newEmptyEntity();
        if ($this->request->is('post')) {

            $instituicao = $this->Muralestagios->Instituicoes->find()
                    ->where(['id' => $this->request->getData('instituicao_id')])
                    ->select(['instituicao'])
                    ->first();
            $dados = $this->request->getData();
            $dados['instituicao'] = $instituicao->instituicao;
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
        $professores = $this->Muralestagios->Professores->find('list');
        $this->set(compact('muralestagio', 'instituicoes', 'professores', 'periodo'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Muralestagio id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null) {

        /** Autorização */
        // Only admin can access this page
        if (!$this->user->isAdmin()) {
            $this->Flash->error(__('Usuario nao autorizado.'));
            return $this->redirect(['controller' => 'Muralestagios', 'action' => 'index']);
        }

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
            'contain' => ['Instituicoes']
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $muralestagio = $this->Muralestagios->patchEntity($muralestagio, $this->request->getData());
            if ($this->Muralestagios->save($muralestagio)) {
                $this->Flash->success(__('Registro muralestagio atualizado.'));
                return $this->redirect(['action' => 'view', $id]);
            }
            // debug($muralestagio);
            $this->Flash->error(__('No foi possível atualizar o registro. Tente novamente.'));
        }
        $instituicoes = $this->Muralestagios->Instituicoes->find('list');
        $professores = $this->Muralestagios->Professores->find('list');

        $this->set(compact('muralestagio', 'instituicoes', 'professores', 'periodostotal'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Muralestagio id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null) {

        /** Autorização */
        // Only admin can access this page
        if (!$this->user->isAdmin()) {
            $this->Flash->error(__('Usuario nao autorizado.'));
            return $this->redirect(['controller' => 'Muralestagios', 'action' => 'index']);
        }

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
