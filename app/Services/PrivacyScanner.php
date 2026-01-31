<?php

namespace App\Services;

class PrivacyScanner
{
    public function analisarTexto($text)
    {
        $patterns = [
            'CPF' => '/\d{3}\.?\d{3}\.?\d{3}-?\d{1,2}/',
            'EMAIL' => '/[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}/i',
            'RG' => '/\b\d{1,2}\.?\d{3}\.?\d{3}-?[\dX]\b/i',
            'TELEFONE'     => '/(?:\(?\d{2}\)?\s?)?9?\d{4}-?\d{4}/',
            'PROCESSO'     => '/\b\d{5}\.\d{6}\/\d{4}-\d{2}\b/',
            'ENDERECO'     => '/\b(CRN|SHN|SCS|CLN|SCLN|EQN|BLOCO|LOJA)\b[^,.\n]*/i',
            'DATA_ANO'     => '/\b(19|20)\d{2}\b/',
            'NOME_PROPRIO' => '/\b[A-ZÀ-Ú][a-zà-ú]{1,15}(?:\s+[A-ZÀ-Ú][a-zà-ú]{1,15}){2,5}\b/',
            'CNPJ' => '/\d{2}\.?\d{3}\.?\d{3}\/?\d{4}-?\d{2}/',
            'RAZAO_SOCIAL' => '/\b[A-ZÀ-Ú\s]{5,}\b\s(LTDA|MEI|ME|S\/A|EPP)\b/i',
            'PROCESSO' => '/\b\d{5,7}\.\d{6}\/\d{4}-\d{2}\b/',
            'MATRICULA' => '/\b[A-Z]{2,5}\s\d{2}-\d{4}-\d{4}\b|(?<!\d)\d{5,8}-[\dX]\b/i',
            'NFE_CHAVE' => '/\b\d{44}\b/',
        ];

        $achados = [];
        $maskedText = $text;

        foreach ($patterns as $tipo => $regex) {
            if (preg_match_all($regex, $text, $matches)) {
                $achados[$tipo] = $matches[0];
                $maskedText = preg_replace($regex, "[REDAZIDO ($tipo)]", $maskedText);
            }
        }

        $totalAchados = 0;
        foreach ($achados as $lista) {
            $totalAchados += count($lista);
        }

        $score = $totalAchados > 0 ? min(100, $totalAchados * 20) : 0;

        return [
            'mascarado' => $maskedText,
            'achados' => $achados,
            'score' => $score
        ];
    }

    private function identificarNomes($text)
    {
        $keywords = ['servidor', 'interessado', 'cidadão', 'usuário', 'Sr\.', 'Sra\.'];
        $nomesEncontrados = [];

        foreach ($keywords as $word) {
            $pattern = '/(?<=' . $word . '\s)([A-Z][a-z]+(?:\s[A-Z][a-z]+)+)/';
            if (preg_match_all($pattern, $text, $matches)) {
                $nomesEncontrados = array_merge($nomesEncontrados, $matches[0]);
            }
        }
        return array_unique($nomesEncontrados);
    }
}
