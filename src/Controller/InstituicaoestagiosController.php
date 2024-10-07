<?php

declare(strict_types=1);

namespace App\Controller;

/**
 * Instituicaoestagios Controller
 *
 * @property \App\Model\Table\InstituicaoestagiosTable $Instituicaoestagios
 * @method \App\Model\Entity\Instituicaoestagio[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class InstituicaoestagiosController extends AppController {

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index() {
        $instituicaoestagios = $this->paginate($this->Instituicaoestagios);

        $this->set(compact('instituicaoestagios'));
    }

    /**
     * View method
     *
     * @param string|null $id Instituicaoestagio id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null) {
        $instituicaoestagio = $this->Instituicaoestagios->get($id, [
            'contain' => ['Areainstituicoes', 'Supervisores', 'Estagiarios' => ['Estudantes', 'Instituicaoestagios', 'Professores', 'Supervisores', 'Turmaestagios'], 'Muralestagios', 'Visitas'],
        ]);

        if (!isset($instituicaoestagio)) {
            $this->Flash->error(__('Nao ha registros de instituicao de estagio para esse numero!'));
            return $this->redirect(['action' => 'index']);
        }

        $this->set(compact('instituicaoestagio'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add() {
        $instituicaoestagio = $this->Instituicaoestagios->newEmptyEntity();
        if ($this->request->is('post')) {
            $instituicaoestagio = $this->Instituicaoestagios->patchEntity($instituicaoestagio, $this->request->getData());
            if ($this->Instituicaoestagios->save($instituicaoestagio)) {
                $this->Flash->success(__('Registro instituicaoestagio inserido.'));
                return $this->redirect(['action' => 'view', $instituicaoestagio->id]);
            }
            $this->Flash->error(__('Não foi possível inserir o registro instituicaoestagio. Tente novamente.'));
        }
        $areainstituicoes = $this->Instituicaoestagios->Areainstituicoes->find('list');
        $turmaestagios = $this->Instituicaoestagios->Turmaestagios->find('list');
        $supervisores = $this->Instituicaoestagios->Supervisores->find('list');
        $this->set(compact('instituicaoestagio', 'areainstituicoes', 'turmaestagios', 'supervisores'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Instituicaoestagio id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null) {
        $instituicaoestagio = $this->Instituicaoestagios->get($id, [
            'contain' => ['Supervisores'],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $instituicaoestagio = $this->Instituicaoestagios->patchEntity($instituicaoestagio, $this->request->getData());
            if ($this->Instituicaoestagios->save($instituicaoestagio)) {
                $this->Flash->success(__('Registro instituicaoestagio inserido.'));
                return $this->redirect(['action' => 'view', $this->Instituicaoestagios->Id]);
            }
            $this->Flash->error(__('Registro instituicaoestagio não foi inserido. Tente novamente.'));
        }
        $areainstituicoes = $this->Instituicaoestagios->Areainstituicoes->find('list');
        $turmaestagios = $this->Instituicaoestagios->Turmaestagios->find('list');
        $supervisores = $this->Instituicaoestagios->Supervisores->find('list');
        $this->set(compact('instituicaoestagio', 'areainstituicoes', 'supervisores', 'turmaestagios'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Instituicaoestagio id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        $instituicaoestagio = $this->Instituicaoestagios->get($id);
        if ($this->Instituicaoestagios->delete($instituicaoestagio)) {
            $this->Flash->success(__('Registro instituicaoestagio excluído.'));
        } else {
            $this->Flash->error(__('Registro instituicaoestagio não foi excluído. Tente novamente.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
