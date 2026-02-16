<?php

declare(strict_types=1);

namespace App\Controller;

/**
 * Inscricoes Controller
 *
 * @property \App\Model\Table\InscricoesTable $Inscricoes
 * @method \App\Model\Entity\Inscricao[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class InscricoesController extends AppController {

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index() {

        /** Autorização: Apenas administradores e estudantes podem ver inscrições */
        if (!$this->user->isAdmin() && !$this->user->isStudent()) {
            $this->Flash->error(__('Usuario nao autorizado.'));
            return $this->redirect(['controller' => 'Muralestagios', 'action' => 'index']);
        }
        
        $periodo = $this->getRequest()->getQuery('periodo');
        
        if (empty($periodo)) {
            $configuracao = $this->fetchTable('Configuracoes');
            $configuracoes = $configuracao->find()->select(['mural_periodo_atual'])->first();
            $periodo = $configuracoes->mural_periodo_atual;
        }
        
        /* Todos os periódos */
        $estagiariotabela = $this->fetchTable('Estagiarios');
        $periodototal = $estagiariotabela->find('list', [
            'keyField' => 'periodo',
            'valueField' => 'periodo',
            'order' => 'periodo'
        ]);
        $periodos = $periodototal->toArray();
        
        $query = $this->Inscricoes->find()
                ->contain(['Alunos', 'Muralestagios'])
                ->where(['Inscricoes.periodo' => $periodo]);

        $inscricoes = $this->paginate($query);

        $this->set(compact('inscricoes', 'periodos', 'periodo'));
    }

    /**
     * View method
     *
     * @param string|null $id Inscricao id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null) {

        /** Autorização */
        // Only admin or student can view
        if (!$this->user->isAdmin() && !$this->user->isStudent()) {
            $this->Flash->error(__('Usuario nao autorizado.'));
            return $this->redirect(['controller' => 'Muralestagios', 'action' => 'index']);
        }

        try {
            $inscricao = $this->Inscricoes->get($id, [
                'contain' => ['Alunos', 'Muralestagios'],
            ]);
        } catch (RecordNotFoundException $e) {
            $this->Flash->error(__('Nao ha registros de inscricao para esse(a) aluno(a)!'));
            return $this->redirect(['controller' => 'Muralestagios', 'action' => 'index']);
        }

        $this->set(compact('inscricao'));
    }

    /**
     * Add method
     * @param string|null $muralestagio_id, $periodo.
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add() {

        /** Autorização */
        // Only admin or student can add
        if (!$this->user->isAdmin() && !$this->user->isStudent()) {
            $this->Flash->error(__('Usuario nao autorizado.'));
            return $this->redirect(['controller' => 'Muralestagios', 'action' => 'index']);
        }

        $muralestagio_id = $this->getRequest()->getQuery('muralestagio_id');
        $periodo = $this->getRequest()->getQuery('periodo');

        if (empty($periodo)) {
            $configuracaotabela = $this->fetchTable('Configuracoes');
            $configuracoes = $configuracaotabela->find()
                    ->first();
            $periodo = $configuracoes->mural_periodo_atual;
        }

        /** Capturo o id do aluno se estiver cadastrado. */
        $aluno_id = $this->Authentication->getIdentityData('aluno_id');

        $inscricaoentity = $this->Inscricoes->newEmptyEntity();

        if ($this->request->is('post')) {

            $alunostabela = $this->fetchTable('Alunos');
            if (isset($aluno_id)) {
                $aluno = $alunostabela->find()
                        ->where(['id' => $aluno_id])
                        ->first();
            } elseif ($this->getRequest()->getData('aluno_id')) {
                $aluno = $alunostabela->find()
                        ->where(['id' => $this->getRequest()->getData('aluno_id')])
                        ->first();
            } else {
                $this->Flash->error(__('Selecione aluno'));
                return $this->redirect(['controller' => 'Alunos', 'action' => 'index']);
            }

            $alunostabela = $this->fetchTable('Alunos');
            $aluno = $alunostabela->find()
                    ->where(['id' => $aluno->id])
                    ->first();

            /** Verifico o periodo do mural e comparo com o periodo da inscricao */
            $muralestagiotabela = $this->fetchTable('Muralestagios');
            $muralestagio = $muralestagiotabela->find()
                    ->where(['id' => $this->getRequest()->getData('muralestagio_id')])
                    ->first();

            if ($muralestagio->periodo <> $this->getRequest()->getData('periodo')) {
                $this->Flash->error(__('O periodo de inscricao nao coincide com o periodo do Mural.'));
                return $this->redirect(['controller' => 'Muralestagios', 'action' => 'view', $this->getRequest()->getData('muralestagio_id')]);
            }

            /** Verifico se já fez inscrição para não duplicar */
            $inscricao = $this->Inscricoes->find()
                    ->where(['Inscricoes.aluno_id' => $aluno->id, 'Inscricoes.muralestagio_id' => $muralestagio->id])
                    ->first();

            if ($inscricao) {
                $this->Flash->error(__("Inscrição já realizada"));
                return $this->redirect(['controller' => 'Inscricoes', 'action' => 'view', $inscricao->id]);
            }

            /** Verifico se esté com o id do aluno */
            if (empty($aluno_id)) {
                $this->Flash->error(__('Selecione aluno'));
                return $this->redirect(['controller' => 'Alunos', 'action' => 'index']);
            }

            /** Preparo os dados para inseir na tabela */
            $dados['registro'] = $aluno->registro;
            if ($aluno) {
                $dados['aluno_id'] = $aluno->id;
            } else {
                $this->Flash->error(__('Aluno nao encontrado'));
                return $this->redirect(['controller' => 'Alunos', 'action' => 'index']);
            }
            $dados['muralestagio_id'] = $this->getRequest()->getData('muralestagio_id');
            $dados['data'] = date('Y-m-d');
            $dados['periodo'] = $this->getRequest()->getData('periodo');

            $inscricaoresposta = $this->Inscricoes->patchEntity($inscricaoentity, $dados);
            if ($this->Inscricoes->save($inscricaoresposta)) {
                $this->Flash->success(__('Registro de inscricao inserido.'));
                return $this->redirect(['action' => 'view', $inscricaoresposta->id]);
            }
            $this->Flash->error(__('Registro de inscricao nao foi inserido. Tente novamente.'));
        }
        $alunotabela = $this->fetchTable('Alunos');
        $alunos = $alunotabela->find('list');

        /** Mostra a lista da ofertas de instituicoes de estagio organizadas por periodo */
        $muralestagiostabela = $this->fetchTable('Muralestagios');
        $options = [
            'keyField' => 'id',
            'valueField' => ['instituicao'],
            'groupField' => ['periodo']
        ];
        $muralestagios = $muralestagiostabela->find('list', $options)->all();

        if (isset($aluno_id)) {
            $this->set('aluno_id', $aluno_id);
        }
        $this->set(compact('muralestagio_id', 'inscricaoentity', 'alunos', 'muralestagios', 'periodo'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Inscricao id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null) {

        /** Autorização */
        if (!$this->user->isAdmin()) {
            $this->Flash->error(__('Usuario nao autorizado.'));
            return $this->redirect(['controller' => 'Muralestagios', 'action' => 'index']);
        }

        $inscricao = $this->Inscricoes->get($id, [
            'contain' => ['Alunos'],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $inscricaoresultado = $this->Inscricoes->patchEntity($inscricao, $this->request->getData());
            if ($this->Inscricoes->save($inscricaoresultado)) {
                $this->Flash->success(__('Registro de inscricao atualizado.'));

                return $this->redirect(['action' => 'view', $inscricaoresultado->id]);
            }
            $this->Flash->error(__('Registro de inscricao nao foi atualizado. Tente novamente.'));
        }
        $alunos = $this->Inscricoes->Alunos->find('list', ['limit' => 200]);
        $muralestagios = $this->Inscricoes->Muralestagios->find('list', ['limit' => 200]);
        $this->set(compact('inscricao', 'alunos', 'alunos', 'muralestagios'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Inscricao id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null) {

        /** Autorização */
        if (!$this->user->isAdmin() && !$this->user->isStudent()) {
            if ($this->user->isStudent()) {
                $inscricao = $this->Inscricoes->find()
                    ->where(['id' => $id, 'aluno_id' => $this->user->aluno_id])
                    ->first();
                if (!$inscricao) {
                    $this->Flash->error(__('Usuario nao autorizado.'));
                    return $this->redirect(['controller' => 'Muralestagios', 'action' => 'index']);
                }
            }
            $this->Flash->error(__('Usuario nao autorizado.'));
            return $this->redirect(['controller' => 'Muralestagios', 'action' => 'index']);
        }

        /** Para retornar para o registro do aluno */
        $aluno = $this->Inscricoes->find()->where(['id' => $id])->select(['aluno_id'])->first();
        $this->request->allowMethod(['post', 'delete']);
        $inscricao = $this->Inscricoes->get($id);
        if ($this->Inscricoes->delete($inscricao)) {
            $this->Flash->success(__('Registro de inscricao excluido.'));
            return $this->redirect(['controller' => 'muralestagios', 'action' => 'index']);
        } else {
            $this->Flash->error(__('Registro de inscricao nao foi excluido. Tente novamente.'));
            return $this->redirect(['controller' => 'alunos', 'action' => 'view', $aluno->id]);
        }
    }
}
