<?php

declare(strict_types=1);

namespace App\Controller;
use App\Model\Entity\Folhadeatividade;

/**
 * Folhadeatividades Controller
 *
 * @property \App\Model\Table\FolhadeatividadesTable $Folhadeatividades
 * @method \App\Model\Entity\Folhadeatividade[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class FolhadeatividadesController extends AppController
{

    /**
     * Index method
     * @param string|null $id Estagiario.id
     * $id = estagiario_id
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index($id = NULL)
    {

        if (is_null($id)) {
            $this->Flash->error(__('Selecione o estagiário e o período da folha de atividades'));
            return $this->redirect('/estagiarios/index');
        }

        $estagiario = $this->Folhadeatividades->Estagiarios->find()
            ->contain(['Estudantes', 'Supervisores', 'Instituicaoestagios', 'Professores'])
            ->where(['Estagiarios.id' => $id])->first();
        $folhadeatividades = $this->Folhadeatividades->find('all')->where(['estagiario_id' => $id]);

        $folhadeatividades = $this->paginate($folhadeatividades);

        $this->set(compact('id', 'estagiario', 'folhadeatividades'));
    }

    /**
     * View method
     *
     * @param string|null $id Folhadeatividade id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {

        $estagiario_id = $this->getRequest()->getQuery('estagiario_id');
        if ($estagiario_id) {
            $folhadeatividades = $this->Folhadeatividades->find()
                ->where(['estagiario_id' => $estagiario_id])
                ->first();
        } else {
            $folhadeatividade = $this->Folhadeatividades->get($id, [
                'contain' => ['Estagiarios'],
            ]);
        }
        // pr($folhadeatividade);
        // die();
        if (!isset($folhadeatividade) && $estagiario_id) {
            return $this->redirect(['controller' => 'folhadeatividades', 'action' => 'add', '?' => ['estagiario_id' => $estagiario_id]]);
        }
        $this->set(compact('folhadeatividade'));
    }

    /**
     * Imprimefolhadeatividades method
     *
     * @param string|null $id Folhadeatividade id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function imprimefolhadeatividades($id = null)
    {

        $registro = $this->getRequest()->getQuery('registro');
        if ($registro) {
            $estagiariotable = $this->fetchTable('Estagiarios');
            $estagiario = $estagiariotable->find()
                ->where(['registro' => $registro])
                ->first();
            if ($estagiario) {

                $this->viewBuilder()->enableAutoLayout(false);
                $this->viewBuilder()->setClassName('CakePdf.Pdf');
                $this->viewBuilder()->setOption(
                    'pdfConfig',
                    [
                        'orientation' => 'portrait',
                        'download' => true, // This can be omitted if "filename" is specified.
                        'filename' => 'atividades_de_estagio_' . $id . '.pdf' //// This can be omitted if you want file name based on URL.
                    ]
                );
                $this->set('estagiario', $estagiario);
            } else {
                $this->Flash->error(__('Estudante ainda sem estágio. Tente novamente'));
                return $this->redirect(['controller' => 'estudantes', 'action' => 'view', '?' => ['registro' => $registro]]);
            }
        } else {
            $this->Flash->error(__('Sem número de registro. Tente novamente'));
            return $this->redirect(['controller' => 'estudantes', 'action' => 'index']);
        }
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add($id = NULL)
    {

        $estagiario_id = $this->getRequest()->getQuery('estagiario_id');
        $estagiariostabela = $this->fetchTable('Estagiarios');
        $estagiario = $estagiariostabela->find()
            ->contain(['Estudantes', 'Instituicaoestagios', 'Supervisores'])
            ->where(['Estagiarios.id' => $estagiario_id])
            ->first();

        if (!$estagiario) {
            $this->Flash->error(__('Estudante sem estágio cadastrado'));
            return redirect(['controller' => 'Estagiarios', 'action' => 'view', $estagiario_id]);
        }

        $folhadeatividade = $this->Folhadeatividades->newEmptyEntity();
        if ($this->request->is('post')) {
            $folhadeatividade = $this->Folhadeatividades->patchEntity($folhadeatividade, $this->request->getData());
            // pr($this->request->getData());
            // die();
            if ($this->Folhadeatividades->save($folhadeatividade)) {
                $this->Flash->success(__('Atividades cadastrada!'));

                return $this->redirect(['action' => 'index', $id]);
            }
            $this->Flash->error(__('Atividade não foi cadastrada. Tente mais uma vez.'));
        }

        $this->set(compact('folhadeatividade', 'estagiario'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Folhadeatividade id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $folhadeatividade = $this->Folhadeatividades->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $folhadeatividade = $this->Folhadeatividades->patchEntity($folhadeatividade, $this->request->getData());
            if ($this->Folhadeatividades->save($folhadeatividade)) {
                $this->Flash->success(__('Atividade atualizada.'));

                return $this->redirect(['action' => 'view', $id]);
            }
            $this->Flash->error(__('Não foi possível atualizar. Tente outra vez.'));
        }
        $estagiarioquery = $this->Folhadeatividades->find()
            ->where(['Folhadeatividades.id' => $id])
            ->contain(['Estagiarios' => ['Estudantes']])
            ->select(['Estagiarios.id', 'Estudantes.nome']);
        // pr($estagiarioquery->first());
        $estagiario = $estagiarioquery->first();
        // pr($estagiario);
        // die();
        $this->set(compact('folhadeatividade', 'estagiario'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Folhadeatividade id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {

        $this->request->allowMethod(['post', 'delete']);
        $folhadeatividade = $this->Folhadeatividades->get($id);
        if ($this->Folhadeatividades->delete($folhadeatividade)) {
            $this->Flash->success(__('Registro de atividade excluido.'));
        } else {
            $this->Flash->error(__('Registro de atividade nao foi excluido. Tente novamente.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function selecionafolhadeatividades($id = NULL)
    {

        /* No login foi capturado o id do estagiário */
        $id = $this->getRequest()->getSession()->read('estagiario_id');
        $this->layout = false;
        if (is_null($id)) {
            $this->Flash->error(__('Selecione o estagiário e o período da folha de atividades'));
            return $this->redirect('/estagiarios/index');
        } else {
            $estagiariostabela = $this->fetchTable('Estagiarios');
            $estagiario = $estagiariostabela->find()
                ->contain(['Estudantes', 'Supervisores', 'Instituicaoestagios'])
                ->where(['Estagiarios.registro' => $this->getRequest()->getSession()->read('registro')])
                ->orderByDesc('nivel')
                ->all()
                ->last();
            $this->set('estagiario', $estagiario);
            return $this->redirect(['controller' => 'estudantes', 'action' => 'view', $estagiario->estudante_id]);
        }
        // pr($estagiarios);
        // die();
    }

    public function folhadeatividadespdf($id = NULL)
    {

        $estagiario_id = $this->getRequest()->getQuery('estagiario_id');
        // pr($estagiario_id);
        $this->layout = false;
        $atividades = $this->Folhadeatividades->find()
            ->contain(['Estagiarios' => ['Estudantes', 'Professores', 'Instituicaoestagios', 'Supervisores']])
            ->where(['Folhadeatividades.estagiario_id' => $estagiario_id])
            ->all();
        // debug($atividades);
// pr($atividades);

        $estagiario = $this->Folhadeatividades->Estagiarios->find()
            ->contain(['Estudantes', 'Professores', 'Instituicaoestagios', 'Supervisores'])
            ->where(['Estagiarios.id' => $estagiario_id])
            ->first();
        // debug($estagiario);
// pr($estagiario);
// die();
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
        $this->set('atividades', $atividades);
        $this->set('estagiario', $estagiario);
    }
}
