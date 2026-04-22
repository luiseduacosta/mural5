#!/bin/bash

# List of files that need user_data initialization
FILES=(
"templates/Avaliacoes/avaliacoes.php"
"templates/Complementos/edit.php"
"templates/Complementos/index.php"
"templates/Complementos/view.php"
"templates/Configuracoes/index.php"
"templates/Estagiarios/add.php"
"templates/Estagiarios/edit.php"
"templates/Estagiarios/index.php"
"templates/Estagiarios/lancanota.php"
"templates/Estagiarios/novotermocompromisso.php"
"templates/Folhadeatividades/atividade.php"
"templates/Folhadeatividades/edit.php"
"templates/Inscricoes/index.php"
"templates/Inscricoes/view.php"
"templates/Instituicoes/edit.php"
"templates/Instituicoes/index.php"
"templates/Muralestagios/index.php"
"templates/Professores/index.php"
"templates/Professores/view.php"
"templates/Questionarios/edit.php"
"templates/Questionarios/index.php"
"templates/Questionarios/view.php"
"templates/Questoes/index.php"
"templates/Questoes/view.php"
"templates/Respostas/edit.php"
"templates/Respostas/index.php"
"templates/Respostas/view.php"
"templates/Supervisores/edit.php"
"templates/Supervisores/index.php"
"templates/Supervisores/view.php"
"templates/Users/add.php"
"templates/Users/edit.php"
"templates/Users/index.php"
"templates/Users/view.php"
"templates/Visitas/edit.php"
"templates/Visitas/view.php"
)

for file in "${FILES[@]}"; do
    if [ -f "$file" ]; then
        # Check if file already has user_data initialization
        if ! grep -q "user_data.*=.*\[.*administrador_id" "$file"; then
            echo "Processing: $file"
            # Add code after the closing */ of docblock
            sed -i '/^ \*\/$/a\
declare(strict_types=1);\
\
$user_data = ['"'"'administrador_id'"'"' => 0, '"'"'aluno_id'"'"' => 0, '"'"'professor_id'"'"' => 0, '"'"'supervisor_id'"'"' => 0, '"'"'categoria'"'"' => '"'"'0'"'"'];\
$user_session = $this->request->getAttribute('"'"'identity'"'"');\
if ($user_session) {\
    $user_data = $user_session->getOriginalData();\
}' "$file"
        else
            echo "Skipping (already has user_data): $file"
        fi
    fi
done

echo "Done!"
