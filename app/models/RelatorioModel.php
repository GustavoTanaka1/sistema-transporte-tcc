<?php

class RelatorioModel {
    private $pdo;

    public function __construct() {
        $this->pdo = Conexao::getConexao();
    }

    public function getProdutividadePorFuncionario($dataInicio, $dataFim, $funcionarioId = null) {
        $sql = "SELECT 
                    f.nome as funcionario_nome,
                    COUNT(ap.id) as total_apontamentos,
                    SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(ap.hora_fim, ap.hora_inicio)))) as total_horas
                FROM apontamentos ap
                JOIN funcionarios f ON ap.funcionario_id = f.id
                WHERE ap.data BETWEEN :dataInicio AND :dataFim";

        if ($funcionarioId) {
            $sql .= " AND ap.funcionario_id = :funcionarioId";
        }

        $sql .= " GROUP BY f.id, f.nome ORDER BY f.nome";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':dataInicio', $dataInicio);
        $stmt->bindValue(':dataFim', $dataFim);

        if ($funcionarioId) {
            $stmt->bindValue(':funcionarioId', $funcionarioId);
        }

        $stmt->execute();
        return $stmt->fetchAll();
    }
}