<?php

namespace App\Services;

class PrivacyScanner
{
    public function analisarTexto($text)
    {
        $patterns = [
            'CPF'   => '/\d{3}\.\d{3}\.\d{3}-\d{2}/',
            'EMAIL' => '/[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}/i',
            'RG'    => '/\d{1,2}\.\d{3}\.\d{3}-[\dX]/i', // Padrão simplificado
        ];

        $achados = [];
        $maskedText = $text;

        foreach ($patterns as $tipo => $regex) {
            if (preg_match_all($regex, $text, $matches)) {
                $achados[$tipo] = $matches[0];
                // Substitui o dado real por uma tag [REDAZIDO]
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
