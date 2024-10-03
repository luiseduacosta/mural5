<?php

declare(strict_types=1);

namespace App\Controller;

/**
 * Muralinscricoes Controller
 *
 * @property \App\Model\Table\MuralinscricoesTable $Muralinscricoes
 * @method \App\Model\Entity\Muralinscricao[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class MuralinscricoesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {

        $periodo = $this->getRequest()->getQuery('periodo');

        if (empty($periodo)) {
            $configuracao = $this->fetchTable('Configuracoes');
            $periodo_atual = $configuracao->find()->select(['mural_periodo_atual'])->first();
            $periodo = $periodo_atual->mural_periodo_atual;
        }

        /* Todos os periódos */
        $estagiariotabela = $this->fetchTable('Estagiarios');
        $periodototal = $estagiariotabela->find('list', [
            'keyField' => 'periodo',
            'valueField' => 'periodo',
            'order' => 'periodo'
        ]);
        $periodos = $periodototal->toArray();

        $query = $this->Muralinscricoes->find()
            ->contain(['Estudantes', 'Muralestagios'])
            ->where(['Muralinscricoes.periodo' => $periodo]);

        $muralinscricoes = $this->paginate($query);

        $this->set(compact('muralinscricoes', 'periodos', 'periodo'));
    }

    /**
     * View method
     *
     * @param string|null $id Muralinscricao id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $muralinscricao = $this->Muralinscricoes->get($id, [
            'contain' => ['Alunos', 'Estudantes', 'Muralestagios'],
        ]);

        $this->set(compact('muralinscricao'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {

        $muralestagio_id = $this->getRequest()->getQuery('muralestagio_id');
        $periodo = $this->getRequest()->getQuery('periodo');

        if (empty($periodo)) {
            $configuracaotabela = $this->fetchTable('Configuracoes');
            $periodoconfiguracao = $configuracaotabela->find()
                ->first();
            $periodo = $periodoconfiguracao->mural_periodo_atual;
        }

        /** Capturo o id do aluno se estiver cadastrado. */
        $estudante_id = $this->Authentication->getIdentityData('estudante_id');

        $muralinscricao = $this->Muralinscricoes->newEmptyEntity();

        if ($this->request->is('post')) {

            $estudantestabela = $this->fetchTable('Estudantes');
            if (isset($estudante_id)) {
                $estudante = $estudantestabela->find()
                    ->where(['id' => $estudante_id])
                    ->first();
            } elseif ($this->getRequest()->getData('estudante_id')) {
                $estudante = $estudantestabela->find()
                    ->where(['id' => $this->getRequest()->getData('estudante_id')])
                    ->first();
            } else {
                $this->Flash->error(__('Selecione estudante'));
                return $this->redirect(['controller' => 'Muralinscricoes', 'action' => 'add', '?' => ['muralestagio_id' => $muralestagio_id]]);
            }

            $alunostabela = $this->fetchTable('Alunos');
            $aluno = $alunostabela->find()
                ->where(['registro' => $estudante->registro])
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
            $inscricao = $this->Muralinscricoes->find()
                ->where(['Muralinscricoes.estudante_id' => $estudante->id, 'Muralinscricoes.muralestagio_id' => $muralestagio->id])
                ->first();
            // pr($inscricao->id);
            // die();
            if ($inscricao) {
                $this->Flash->error(__("Inscrição já realizada"));
                return $this->redirect(['controller' => 'Muralinscricoes', 'action' => 'view', $inscricao->id]);
            }

            /** Verifico se esté com o id do estudante */
            if (empty($estudante_id)) {
            }
    
            /** Preparo os dados para inseir na tabela */
            $dados['registro'] = $estudante->registro;
            if ($aluno) {
                $dados['aluno_id'] = $aluno->id;
            } else {
                $dados['aluno_id'] = null;
            }
            $dados['estudante_id'] = $estudante->id;
            $dados['muralestagio_id'] = $this->getRequest()->getData('muralestagio_id');
            $dados['data'] = date('Y-m-d');
            $dados['periodo'] = $this->getRequest()->getData('periodo');

            $muralinscricao = $this->Muralinscricoes->patchEntity($muralinscricao, $dados);
            if ($this->Muralinscricoes->save($muralinscricao)) {
                $this->Flash->success(__('Registro de inscricao inserido.'));
                return $this->redirect(['action' => 'view', $muralinscricao->id]);
            }
            // debug($muralinscricao);
            $this->Flash->error(__('Registro de inscricao nao foi inserido. Tente novamente.'));
        }

        $estudantestabela = $this->fetchTable('Estudantes');
        $estudantes = $estudantestabela->find('list');

        /** Mostra a lista da ofertas de instituicoes de estagio organizadas por periodo */
        $muralestagiostabela = $this->fetchTable('Muralestagios');
        $options = [
            'keyField' => 'id',
            'valueField' => ['instituicao'],
            'groupField' => ['periodo']
        ];
        $muralestagios = $muralestagiostabela->find('list', $options)->all();

        if (isset($estudante_id)) {
            $this->set('estudante_id', $estudante_id);
        }
        $this->set(compact('muralestagio_id', 'muralinscricao', 'estudantes', 'muralestagios', 'periodo'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Muralinscricao id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $muralinscricao = $this->Muralinscricoes->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $muralinscricao = $this->Muralinscricoes->patchEntity($muralinscricao, $this->request->getData());
            if ($this->Muralinscricoes->save($muralinscricao)) {
                $this->Flash->success(__('Registro de inscricao atualizado.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Registro de inscricao nao foi atualizado. Tente novamente.'));
        }
        $alunos = $this->Muralinscricoes->Alunos->find('list', ['limit' => 200]);
        $estudantes = $this->Muralinscricoes->Estudantes->find('list', ['limit' => 200]);
        $muralestagios = $this->Muralinscricoes->Muralestagios->find('list', ['limit' => 200]);
        $this->set(compact('muralinscricao', 'alunos', 'estudantes', 'muralestagios'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Muralinscricao id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        /** Para retornar para o registro do estudante */
        $estudante = $this->Muralinscricoes->find()->where(['id' => $id])->select(['estudante_id'])->first();
        $this->request->allowMethod(['post', 'delete']);
        $muralinscricao = $this->Muralinscricoes->get($id);
        if ($this->Muralinscricoes->delete($muralinscricao)) {
            $this->Flash->success(__('Registro de inscricao excluido.'));
        } else {
            $this->Flash->error(__('Registro de inscricao nao foi excluido. Tente novamente.'));
        }
        return $this->redirect(['controller' => 'estudantes', 'action' => 'view', $estudante->id]);
    }
}
