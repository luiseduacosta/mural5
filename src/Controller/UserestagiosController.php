<?php

declare(strict_types=1);

namespace App\Controller;

/**
 * Userestagios Controller
 *
 * @property \App\Model\Table\UserestagiosTable $Userestagios
 * @method \App\Model\Entity\Userestagio[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UserestagiosController extends AppController {

    public function beforeFilter(\Cake\Event\EventInterface $event) {
        parent::beforeFilter($event);
        // Configure the login action to not require authentication, preventing
        // the infinite redirect loop issue
        $this->Authentication->addUnauthenticatedActions(['login', 'add']);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index() {
        $this->paginate = [
            'contain' => ['Estudantes', 'Supervisores', 'Docentes'],
        ];
        $userestagios = $this->paginate($this->Userestagios);
        $this->set(compact('userestagios'));
    }

    /**
     * View method
     *
     * @param string|null $id Userestagio id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null) {
        $userestagio = $this->Userestagios->get($id, [
            'contain' => ['Estudantes', 'Supervisores', 'Docentes'],
        ]);

        $this->set(compact('userestagio'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add() {

        $userestagio = $this->Userestagios->newEmptyEntity();
        // pr($this->request->getData());
        // die();
        if ($this->request->is('post')) {

            if ($this->request->getData('categoria') == 2):

                $dados = $this->request->getData();
                // pr($dados);
                // die();

                /* Verifico se já está cadastrado */
                $usercadastrado = $this->Userestagios->find()
                        ->where(['email' => $this->request->getData('email')])
                        ->first();
                // pr($usercadastrado);
                // die();
                /* Se está cadastrado excluo para refazer a senha */
                if ($usercadastrado):
                    $this->Userestagios->delete($usercadastrado);
                endif;

                /* Verifico se está cadatrado como estudante */
                $estudantetabela = $this->fetchTable('Estudantes');
                $estudantecadastrado = $estudantetabela->find()
                        ->where(['registro' => $this->request->getData('numero')])
                        ->first();
                // pr($estudantecadastrado);
                // die();
                /* Se está já cadastrado como estudante então capturo o id e aplico no usuer no campo estudante_id */
                if ($estudantecadastrado) {
                    $dados['estudante_id'] = $estudantecadastrado->id;
                    $userestagio = $this->Userestagios->patchEntity($userestagio, $dados);
                    if ($this->Userestagios->save($userestagio)) {
                        $this->Flash->success(__('Usuário estudante inserido.'));

                        $this->getRequest()->getSession()->write('categoria', $this->request->getData('categoria'));
                        $this->getRequest()->getSession()->write('registro', $this->request->getData('numero'));
                        $this->getRequest()->getSession()->write('usuario', $this->request->getData('email'));

                        /* Mostro o estudante */
                        return $this->redirect(['controller' => 'estudantes', 'action' => 'view', $estudantecadastrado->id]);
                    }
                } else {
                    $userestagio = $this->Userestagios->patchEntity($userestagio, $dados);
                    if ($this->Userestagios->save($userestagio)) {
                        $this->Flash->success(__('Usuário inserido.'));

                        $this->getRequest()->getSession()->write('categoria', $this->request->getData('categoria'));
                        $this->getRequest()->getSession()->write('registro', $this->request->getData('numero'));
                        $this->getRequest()->getSession()->write('usuario', $this->request->getData('email'));

                        /* Cadastro o estudante  */
                        return $this->redirect(['controller' => 'estudantes', 'action' => 'add', '?' => ['registro' => $this->request->getData('numero'), 'email' => $this->request->getData('email')]]);
                    }
                }
                $this->Flash->error(__('O usuário de estagio não foi cadastrado. Tente novamente.'));
                return $this->redirect(['action' => 'login']);
            endif;

            if ($this->request->getData('categoria') == 3):

                $dados = $this->request->getData();
                /* Verifico se já está cadastrado */
                $usercadastrado = $this->Userestagios->find()
                        ->where(['email' => $this->request->getData('email')])
                        ->first();
                // pr($usercadastrado);
                // die();
                /* Se está cadastrado excluo para refazer a senha */
                if ($usercadastrado):
                    $this->Userestagios->delete($usercadastrado);
                endif;

                /* Verifico se está cadatrado como docente */
                $docentetabela = $this->fetchTable('Docentes');
                $docentecadastrado = $docentetabela->find()
                        ->where(['siape' => $this->request->getData('numero')])
                        ->first();
                // pr($docentecadastrado);
                // die();
                if ($docentecadastrado) {
                    $dados['professor_id'] = $docentecadastrado->id;
                    // pr($dados);
                    // die();
                    $userestagio = $this->Userestagios->patchEntity($userestagio, $dados);
                    if ($this->Userestagios->save($userestagio)) {
                        $this->Flash->success(__('Docente cadastrado.'));

                        $this->getRequest()->getSession()->write('categoria', $this->request->getData('categoria'));
                        $this->getRequest()->getSession()->write('siape', $this->request->getData('numero'));
                        $this->getRequest()->getSession()->write('usuario', $this->request->getData('email'));

                        /* Precisa de autorização na ação add do controller Docentes */
                        return $this->redirect(['controller' => 'docentes', 'action' => 'view', 'siape' => $dados['professor_id']]);
                    }
                } else {
                    $userestagio = $this->Userestagios->patchEntity($userestagio, $dados);
                    if ($this->Userestagios->save($userestagio)) {
                        $this->Flash->success(__('Professora(o) cadastrada(o).'));

                        $this->getRequest()->getSession()->write('categoria', $this->request->getData('categoria'));
                        $this->getRequest()->getSession()->write('siape', $this->request->getData('numero'));
                        $this->getRequest()->getSession()->write('usuario', $this->request->getData('email'));

                        /* Precisa de autorização na ação add do controller Estudantes */
                        return $this->redirect(['controller' => 'docentes', 'action' => 'add', '?' => ['registro' => $this->request->getData('numero'), 'email' => $this->request->getData('email')]]);
                    }
                }
                $this->Flash->error(__('Docentes são cadastrados diretamente junto com a Coordenação de Estágio'));
                return $this->redirect('/muralestagios/index');
            endif;

            if ($this->request->getData('categoria') == 4):

                $dados = $this->request->getData();
                /* Verifico se já está cadastrado */
                $usercadastrado = $this->Userestagios->find()
                        ->where(['email' => $this->request->getData('email')])
                        ->first();
                // pr($usercadastrado);
                // die();
                /* Se está cadastrado excluo para refazer a senha */
                if ($usercadastrado):
                    $this->Userestagios->delete($usercadastrado);
                endif;

                /* Verifico se está cadatrado como supervisor */
                $supervisorestabela = $this->fetchTable('Supervisores');
                $supervisorcadastrado = $supervisorestabela->find()
                        ->where(['cress' => $this->request->getData('numero')])
                        ->first();
                // pr($supervisorcadastrado);
                // die();
                if ($supervisorcadastrado) {
                    $dados['supervisor_id'] = $supervisorcadastrado->id;
                    // pr($dados);
                    // die();
                    $userestagio = $this->Userestagios->patchEntity($userestagio, $dados);
                    if ($this->Userestagios->save($userestagio)) {
                        $this->Flash->success(__('Supervisor cadastrado.'));

                        $this->getRequest()->getSession()->write('categoria', $this->request->getData('categoria'));
                        $this->getRequest()->getSession()->write('cress', $this->request->getData('numero'));
                        $this->getRequest()->getSession()->write('usuario', $this->request->getData('email'));

                        /* Precisa de autorização na ação add do controller Docentes */
                        return $this->redirect(['controller' => 'supervisores', 'action' => 'view', $dados['supervisor_id']]);
                    }
                } else {
                    $userestagio = $this->Userestagios->patchEntity($userestagio, $dados);
                    if ($this->Userestagios->save($userestagio)) {
                        $this->Flash->success(__('Supervisora(o) cadastrada(o).'));

                        $this->getRequest()->getSession()->write('categoria', $this->request->getData('categoria'));
                        $this->getRequest()->getSession()->write('cress', $this->request->getData('numero'));
                        $this->getRequest()->getSession()->write('usuario', $this->request->getData('email'));

                        /* Precisa de autorização na ação add do controller Estudantes */
                        return $this->redirect(['controller' => 'supervisores', 'action' => 'add', '?' => ['registro' => $this->request->getData('numero'), 'email' => $this->request->getData('email')]]);
                    }
                }

                $this->Flash->error(__('Supervisores são cadastrados diretamente junto com a Coordenação de Estágio'));
                return $this->redirect('/muralestagios/index');
            endif;
        }
        $estudantes = $this->Userestagios->Estudantes->find('list');
        $supervisores = $this->Userestagios->Supervisores->find('list');
        $docentes = $this->Userestagios->Docentes->find('list');
        $this->set(compact('userestagio', 'estudantes', 'supervisores', 'docentes'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Userestagio id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null) {
        $userestagio = $this->Userestagios->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $userestagio = $this->Userestagios->patchEntity($userestagio, $this->request->getData());
            if ($this->Userestagios->save($userestagio)) {
                $this->Flash->success(__('The userestagio has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The userestagio could not be saved. Please, try again.'));
        }
        $estudantes = $this->Userestagios->Estudantes->find('list');
        $supervisores = $this->Userestagios->Supervisores->find('list');
        $docentes = $this->Userestagios->Docentes->find('list');
        $this->set(compact('userestagio', 'estudantes', 'supervisores', 'docentes'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Userestagio id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        $userestagio = $this->Userestagios->get($id);
        if ($this->Userestagios->delete($userestagio)) {
            $this->Flash->success(__('Usuário excluído.'));
            return $this->redirect(['action' => 'login']);
        } else {
            $this->Flash->error(__('Não foi possível excluir o usuário.'));
            return $this->redirect(['action' => 'login']);
        }
        // return $this->redirect(['action' => 'login']);
    }

    public function login() {
        $this->request->allowMethod(['get', 'post']);
        $result = $this->Authentication->getResult();
        // regardless of POST or GET, redirect if user is logged in
        if ($result->isValid()) {
            // pr($this->request->getAttribute('authentication'));
            // die();
            switch ($this->Authentication->getIdentityData('categoria')):
                case 1:
                    echo "Administrador";
                    $this->Flash->success(__('Bem-vindo administrador!'));
                    $this->getRequest()->getSession()->write('id_categoria', $this->Authentication->getIdentityData('categoria'));
                    return $this->redirect(['controller' => 'muralestagios', 'action' => 'index']);
                    break;
                case 2:
                    echo "Estudante";
                    $this->Flash->success(__('Bem-vindo estudante!'));
                    $this->getRequest()->getSession()->write('id_categoria', $this->Authentication->getIdentityData('categoria'));
                    $this->getRequest()->getSession()->write('registro', $this->Authentication->getIdentityData('numero'));
                    $this->getRequest()->getSession()->write('usuario', $this->Authentication->getIdentityData('email'));
                    if (empty($this->Authentication->getIdentityData('estudante_id'))):
                        // echo "Estudante sem o id cadastrado";
                        /** Capturo o entity do Userestagios */
                        $userestagios = $this->Userestagios->get($this->Authentication->getIdentityData('id'));
                        $estudantestabela = $this->fetchTable('Estudantes');
                        $estudantecadastrado = $estudantestabela->find()
                                ->where(['registro' => $this->Authentication->getIdentityData('numero')])
                                ->select(['id'])
                                ->first();
                        if ($estudantecadastrado) {
                            /** Atualizo o estudante_id */
                            $userestagiodata = $userestagios->toArray();
                            $userestagiodata['estudante_id'] = $estudantecadastrado->id;
                            $userestagios = $this->Userestagios->patchEntity($userestagios, $userestagiodata);
                            if ($this->Userestagios->save($userestagios)) {
                                // $this->Flash->success(__('Usuário atualizado!'));
                                return $this->redirect('/muralestagios/index');
                            }
                        } else {
                            return $this->redirect(['controller' => 'estudantes', 'action' => 'add', '?' => ['registro', $this->Authentication->getIdentityData('numero'), 'email' => $this->Authentication->getIdentityData('usuario')]]);
                        }
                    // die();
                    else:
                        $estudantestabela = $this->fetchTable('Estudantes');
                        $estudantequery = $estudantestabela->find()
                                ->where(['registro' => $this->Authentication->getIdentityData('numero')])
                                ->first();
                        // pr($estudantequery);
                        // die();
                        /** Se um usuário da categoria estudante e não está cadastrado como estudante então realiza cadastramento */
                        if (empty($estudantequery)) {
                            return $this->redirect(['controller' => '__(estudantes', 'action' => 'add', '?' => ['registro', $this->Authentication->getIdentityData('numero'), 'email' => $this->Authentication->getIdentityData('email')]]);
                        } else {
                            $this->Flash->success(__('Bem-vindo estudante!'));
                            /* Verifico se é estagiário capturo o id  e guardo numa varíavel de sessão */
                            $estagiariostabela = $this->fetchTable('Estagiarios');
                            $estagiarioultimo = $estagiariostabela->find()
                                    ->where(['Estagiarios.registro' => $this->Authentication->getIdentityData('numero')])
                                    ->select(['id'])
                                    ->orderDesc('nivel')
                                    ->first();
                            // pr($estagiarioultimo_id);
                            // die();
                            if ($estagiarioultimo) {
                                $this->getRequest()->getSession()->write('estagiario_id', $estagiarioultimo->id);
                            } else {
                                $this->getRequest()->getSession()->delete('estagiario_id');
                                // $this->Flash->success(__('Estudante sem estágio'));
                            }
                            /* Agora sim vou para o mural de estágios */
                            return $this->redirect(['controller' => 'muralestagios', 'action' => 'index']);
                        }
                    endif;
                    break;
                case 3:
                    echo "Professor";
                    /* Verifico se está cadastrado como docente */
                    $docentestabela = $this->fetchTable('Docentes');
                    $docente = $docentestabela->find()
                            ->contain(['Estagiarios'])
                            ->where(['siape' => $this->Authentication->getIdentityData('numero')])
                            ->first();
                    if (!$docente) {
                        // echo "Docente sem cadastrado";
                        return $this->redirect(__('/docentes/add?siape=' . $this->Authentication->getIdentityData('numero')));
                    }
                    if ($docente->has('estagiarios')) {
                        $this->getRequest()->getSession()->write('docente_com_estagiarios', 1);
                    } else {
                        $this->getRequest()->getSession()->delete('docente_com_estagiario');
                    }
                    // die('Professor');

                    /* Verifico ainda se o campo professor_id está preenchido */
                    if (empty($dados['professor_id'])):
                        // echo "Docente não cadastrado";
                        return $this->redirect('/docentes/add?siape=' . $this->Authentication->getIdentityData('numero'));
                    else:

                        $this->getRequest()->getSession()->write('categoria', $this->Authentication->getIdentityData('categoria'));
                        $this->getRequest()->getSession()->write('siape', $this->Authentication->getIdentityData('numero'));
                        $this->getRequest()->getSession()->write('usuario', $this->Authentication->getIdentityData('email'));

                        $this->Flash->success(__('Bem-vinda(o) professora(o)!'));
                        return $this->redirect('/muralestagios/index');
                    endif;
                    break;
                case 4:
                    echo "Supervisor";
                    // die();
                    if (empty($this->Authentication->getIdentityData('supervisor_id'))):
                        // echo "Supervisor não cadastrado";
                        return $this->redirect(['controller' => 'supervisores', 'action' => 'add', '?' => ['cress' => $this->Authentication->getIdentityData('numero')]]);
                    else:
                        $this->getRequest()->getSession()->write('categoria', $this->Authentication->getIdentityData('categoria'));
                        $this->getRequest()->getSession()->write('cress', $this->Authentication->getIdentityData('numero'));
                        $this->getRequest()->getSession()->write('usuario', $this->Authentication->getIdentityData('email'));

                        $this->Flash->success(__('Bem-vinda(o) supervisora(o)!'));
                        return $this->redirect('/muralestagios/index');
                    endif;
                    break;
                default:
                    echo "Sem categorizar";
                    $this->Flash->error(__('Usuário não categorizado em nenhum segmento'));
                    return $this->redirect('/userestagios/logout');
            endswitch;
            // return $this->redirect($redirect);
        }
        // display error if user submitted and authentication failed
        if ($this->request->is('post') && !$result->isValid()) {
            $this->Flash->error(__('Usuário e/ou senha errado'));
        }
    }

    public function logout() {
        $result = $this->Authentication->getResult();
        // regardless of POST or GET, redirect if user is logged in
        if ($result->isValid()) {
            $this->Authentication->logout();

            $this->getRequest()->getSession()->delete('id_categoria');
            $this->getRequest()->getSession()->delete('registro');
            $this->getRequest()->getSession()->delete('siape');
            $this->getRequest()->getSession()->delete('cress');
            $this->getRequest()->getSession()->delete('usuario');
            $this->getRequest()->getSession()->delete('estagiario_id');

            return $this->redirect(['controller' => 'userestagios', 'action' => 'login']);
        }
    }

    /*
     * Preenche os ids da tabela userestagios com os valores correspondentes
     *
     */

    public function preencher() {

        $user = $this->Userestagios->find('all');
        foreach ($user as $c_user) {
            // pr($c_user->categoria);
            if ($c_user->categoria == 2) {
                // pr($c_user->numero);
                $docentestabela = $this->fetchTable('Estudantes');
                $estudante = $docentestabela->find()
                        ->contain([])
                        ->where(['estudantes.registro' => $c_user->numero])
                        ->first();
                // pr($estudante);
                // pr($estudante->first()->registro);
                $c_user->estudante_id = $estudante->id;
                // pr($c_user->estudante_id);
                // pr($c_user->id);
                if ($this->Userestagios->save($c_user)) {
                    // echo "Atualizado!" . "</br>";
                    $this->Flash->success(__('Usuario de estagio atualizado.'));
                } else {
                    // echo "Erro!" . "<br>";
                    $this->Flash->error(__('Erro na atualizacao. Tente novamente.'));
                }
                ;
                // die();
            }
            // die('Estudantes');
            // Professores
            if ($c_user->categoria == 3) {
                // pr($c_user->numero);
                // die();
                $docentestabela = $this->fetchTable('Docentes');
                $docente = $docentestabela->find()
                        ->contain([])
                        ->where(['docentes.siape' => $c_user->numero])
                        ->first();
                // pr($docente);
                // pr($docente->first()->siape);
                $c_user->professor_id = $docente->id;
                // pr($c_user->professor_id);
                // pr($c_user->id);
                // die();
                if ($this->Userestagios->save($c_user)) {
                    echo "Atualizado!" . "</br>";
                    $this->Flash->success(__('The userestagio has been saved.'));
                } else {
                    echo "Erro!" . "<br>";
                    $this->Flash->error(__('The userestagio could not be saved. Please, try again.'));
                }
                ;
                // die('if docentes');
            }
            // die('Docentes');
            // Supervisores
            if ($c_user->categoria == 4) {
                // pr($c_user->numero);
                // die();
                $supervisorestabela = $this->fetchTable('Supervisores');
                $supervisor = $supervisorestabela->find()
                        ->contain([])
                        ->where(['supervisores.cress' => $c_user->numero])
                        ->first();
                // pr($docente);
                // pr($docente->first()->siape);
                $c_user->supervisor_id = $supervisor->id;
                // pr($c_user->professor_id);
                // pr($c_user->id);
                // die();
                if ($this->Userestagios->save($c_user)) {
                    echo "Atualizado!" . "</br>";
                    $this->Flash->success(__('The userestagio has been saved.'));
                } else {
                    echo "Erro!" . "<br>";
                    $this->Flash->error(__('The userestagio could not be saved. Please, try again.'));
                }
                ;
                // die('if docentes');
            }
            // die('Docentes');
        }
        // pr($user);
        die();
    }
}
