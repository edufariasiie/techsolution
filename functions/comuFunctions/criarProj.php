<?php

function criarProjeto($nome, $descricao, $data_limite, $tipo_incentivo, $valor_financeiro = null, $descricao_permuta = null, $user_id = null) {
    global $link;
    $erros = [];

    // Validação básica
    if (empty(trim($nome))) {
        $erros['nome'] = 'O nome do projeto é obrigatório.';
    }
    if (empty(trim($descricao))) {
        $erros['descricao'] = 'A descrição é obrigatória.';
    }
    if (empty($data_limite)) {
        $erros['data_limite'] = 'A data limite é obrigatória.';
    }
    if (empty($tipo_incentivo)) {
        $erros['tipo_incentivo'] = 'O tipo de incentivo é obrigatório.';
    } elseif ($tipo_incentivo === 'financeiro') {
        if (empty($valor_financeiro) || !is_numeric($valor_financeiro) || $valor_financeiro <= 0) {
            $erros['valor_financeiro'] = 'Informe um valor financeiro válido.';
        }
    } elseif ($tipo_incentivo === 'permuta') {
        if (empty(trim($descricao_permuta))) {
            $erros['descricao_permuta'] = 'Descreva a permuta.';
        }
    } else {
        $erros['tipo_incentivo'] = 'Tipo de incentivo inválido.';
    }

    if (!empty($erros)) {
        return $erros;
    }

    // Monta query
    $sql = "INSERT INTO projetos (nome, descricao, data_limite, tipo_incentivo, valor_financeiro, descricao_permuta, user_id) VALUES (?, ?, ?, ?, ?, ?, ?)";
    if ($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "ssssdsi", $nome, $descricao, $data_limite, $tipo_incentivo, $valor_financeiro, $descricao_permuta, $user_id);
        if (mysqli_stmt_execute($stmt)) {
            return true;
        } else {
            return ['db' => 'Erro ao cadastrar projeto.'];
        }
    } else {
        return ['db' => 'Erro ao preparar query.'];
    }
}
