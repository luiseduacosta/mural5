<?php

declare(strict_types=1);

namespace App\Controller;

/**
 * Areas Controller
 *
 * @property \App\Model\Table\AreasTable $Areas
 *
 * @method \App\Model\Entity\Area[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AreasController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $user_data = ['categoria' => '0', 'entidade_id' => 0, 'aluno_id' => 0, 'professor_id' => 0, 'supervisor_id' => 0];
        $user_session = $this->request->getAttribute('identity');
        if ($user_session) {
            $user_data = $user_session->getOriginalData();
        }

        try {
            $this->Authorization->authorize($this->Areas);
        } catch (\Authorization\Exception\ForbiddenException $e) {
            $this->Flash->error(__("Acesso negado. Você não tem permissão para visualizar as áreas de instituição."));
            return $this->redirect(["controller" => "Instituicoes", "action" => "index"]);
        }
        $areas = $this->paginate($this->Areas);
        $this->set(compact('areas', 'user_data'));
    }

    /**
     * View method
     *
     * @param string|null $id Area id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user_data = ['categoria' => '0', 'entidade_id' => 0, 'aluno_id' => 0, 'professor_id' => 0, 'supervisor_id' => 0];
        $user_session = $this->request->getAttribute('identity');
        if ($user_session) {
            $user_data = $user_session->getOriginalData();
        }

        try {
            $area = $this->Areas->get($id);
        } catch (\Cake\Datasource\Exception\RecordNotFoundException $e) {
            $this->Flash->error(__('Área não encontrada.'));
            return $this->redirect(['action' => 'index']);
        }

        try {
            $this->Authorization->authorize($area);
        } catch (\Authorization\Exception\ForbiddenException $e) {
            $this->Flash->error(__("Acesso negado. Você não tem permissão para visualizar a área."));
            return $this->redirect(["controller" => "Muralestagios", "action" => "index"]);
        }
        $this->set(compact('area', 'user_data'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user_data = ['categoria' => '0', 'entidade_id' => 0, 'aluno_id' => 0, 'professor_id' => 0, 'supervisor_id' => 0];
        $user_session = $this->request->getAttribute('identity');
        if ($user_session) {
            $user_data = $user_session->getOriginalData();
        }

        $area = $this->Areas->newEmptyEntity();
        try {
            $this->Authorization->authorize($area);
        } catch (\Authorization\Exception\ForbiddenException $e) {
            $this->Flash->error(__("Acesso negado. Você não tem permissão para inserir áreas."));
            return $this->redirect(["controller" => "Muralestagios", "action" => "index"]);
        }

        if ($this->request->is('post')) {
            $area = $this->Areas->patchEntity($area, $this->request->getData());
            if ($this->Areas->save($area)) {
                $this->Flash->success(__('Área inserida.'));
                return $this->redirect(['action' => 'view', $area->id]);
            }
            $this->Flash->error(__('Área não inserida.'));
            return $this->redirect(['action' => 'index']);
        }
        $this->set(compact('area', 'user_data'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Area id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user_data = ['categoria' => '0', 'entidade_id' => 0, 'aluno_id' => 0, 'professor_id' => 0, 'supervisor_id' => 0];
        $user_session = $this->request->getAttribute('identity');
        if ($user_session) {
            $user_data = $user_session->getOriginalData();
        }

        try {
            $area = $this->Areas->get($id);
        } catch (\Cake\Datasource\Exception\RecordNotFoundException $e) {
            $this->Flash->error(__('Área não encontrada.'));
            return $this->redirect(['action' => 'index']);
        }

        try {
            $this->Authorization->authorize($area);
        } catch (\Authorization\Exception\ForbiddenException $e) {
            $this->Flash->error(__("Acesso negado. Você não tem permissão para editar a área."));
            return $this->redirect(["controller" => "Muralestagios", "action" => "index"]);
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            $area = $this->Areas->patchEntity($area, $this->request->getData());
            if ($this->Areas->save($area)) {
                $this->Flash->success(__('Área atualizada.'));
                return $this->redirect(['action' => 'view', $area->id]);
            }
            $this->Flash->error(__('Área não atualizada. Tente novamente'));
            return $this->redirect(['action' => 'view', $area->id]);
        }
        $this->set(compact('area', 'user_data'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Area id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        try {
            $area = $this->Areas->get($id);
        } catch (\Cake\Datasource\Exception\RecordNotFoundException $e) {
            $this->Flash->error(__('Área não encontrada.'));
            return $this->redirect(['action' => 'index']);
        }

        try {
            $this->Authorization->authorize($area);
        } catch (\Authorization\Exception\ForbiddenException $e) {
            $this->Flash->error(__("Acesso negado. Você não tem permissão para excluir a área."));
            return $this->redirect(["controller" => "Muralestagios", "action" => "index"]);
        }

        if ($this->Areas->delete($area)) {
            $this->Flash->success(__('Área excluída.'));
        } else {
            $this->Flash->error(__('Área não excluída. Tente novamente'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
