<?php

declare(strict_types=1);

namespace App\Controller;

/**
 * Muralestagios Controller
 *
 * @property \App\Model\Table\MuralestagiosTable $Muralestagios
 * @method \App\Model\Entity\Muralestagio[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class MuralestagiosController extends AppController
{

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
    public function index($id = NULL)
    {

        $periodo = $this->getRequest()->getQuery('periodo');
        // pr($periodo);

        if (empty($periodo)) {
            $configuracaotabela = $this->fetchTable('Configuracoes');
            $periodo_atual = $configuracaotabela->find()->select(['mural_periodo_atual'])->first();
            $periodo = $periodo_atual->mural_periodo_atual;
        }

        if ($periodo) {
            $muralestagios = $this->Muralestagios->find('all', [
                'conditions' => ['Muralestagios.periodo' => $periodo],
                'order' => ['id' => 'DESC']
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
    public function view($id = null)
    {

        $muralestagio = $this->Muralestagios->get($id, [
            'contain' => ['Instituicaoestagios' => ['Turmaestagios'], 'Professores', 'Muralinscricoes' => ['Estudantes']]
        ]);
        $this->set(compact('muralestagio'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {

        if (empty($periodo)) {
            $configuracaotabela = $this->fetchTable('Configuracoes');
            $periodoconfiguracao = $configuracaotabela->find()
                ->first();
            $periodo = $periodoconfiguracao->mural_periodo_atual;
        }
        $muralestagio = $this->Muralestagios->newEmptyEntity();
        if ($this->request->is('post')) {

            // pr($this->request->getData('instituicaoestagio_id'));
            $instituicao = $this->Muralestagios->Instituicaoestagios->find()
                ->where(['id' => $this->request->getData('instituicaoestagio_id')])
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
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('Registro de mural de estágio não foi feito. Tente novamente.'));
            }
        }
        /** Envio para fazer o formulário de cadastramento do mural */        
        $instituicaoestagios = $this->Muralestagios->Instituicaoestagios->find('list');
        $turmaestagios = $this->Muralestagios->Turmaestagios->find('list');
        $professores = $this->Muralestagios->Professores->find('list');
        $this->set(compact('muralestagio', 'instituicaoestagios', 'turmaestagios', 'professores', 'periodo'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Muralestagio id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {

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
            'contain' => ['Instituicaoestagios'],
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
        $instituicaoestagios = $this->Muralestagios->Instituicaoestagios->find('list');
        $turmaestagios = $this->Muralestagios->Turmaestagios->find('list');
        $professores = $this->Muralestagios->Professores->find('list');
        $this->set(compact('muralestagio', 'instituicaoestagios', 'turmaestagios', 'professores', 'periodostotal'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Muralestagio id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $muralestagio = $this->Muralestagios->get($id);
        if ($this->Muralestagios->delete($muralestagio)) {
            $this->Flash->success(__('Registro muralestagio excluído.'));
        } else {
            $this->Flash->error(__('Registro muralestagio não foi excluído. Tente novamente.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
