<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <style>
        @page {
            margin: 1.5cm;
        }

        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #2d3748;
            line-height: 1.5;
        }

        .header {
            border-bottom: 3px solid #0464ac;
            padding-bottom: 15px;
            margin-bottom: 20px;
            text-align: center;
        }

        .logo-gdf {
            height: 60px;
            /* Ajuste o tamanho aqui */
            margin-bottom: 10px;
        }

        .gov-brand {
            color: #0464ac;
            font-size: 22px;
            font-weight: bold;
            text-transform: uppercase;
            margin: 0;
            letter-spacing: 1px;
        }

        .sub-title {
            color: #4a5568;
            font-size: 11px;
            margin-top: 5px;
            font-weight: bold;
            text-transform: uppercase;
        }

        /* Grid de Informações Rápidas */
        .info-grid {
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
        }

        .info-card {
            background: #f7fafc;
            border: 1px solid #e2e8f0;
            padding: 12px;
            width: 30%;
        }

        .label {
            font-size: 9px;
            color: #718096;
            text-transform: uppercase;
            font-weight: bold;
            display: block;
            margin-bottom: 3px;
        }

        .value {
            font-size: 12px;
            color: #1a202c;
            font-weight: bold;
        }

        .risk-high {
            color: #e53e3e;
        }

        .risk-low {
            color: #38a169;
        }

        /* Seções */
        .section-title {
            background: #0464ac
            color: white;
            padding: 6px 12px;
            font-size: 12px;
            font-weight: bold;
            margin-top: 20px;
            border-radius: 4px;
        }

        .badge-container {
            padding: 10px 0;
        }

        .badge {
            background: #ebf4ff;
            color: #0464ac;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: bold;
            border: 1px solid #bee3f8;
            margin-right: 5px;
            margin-bottom: 5px;
            display: inline-block;
        }

        .content-box {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            padding: 15px;
            font-size: 10px;
            color: #4a5568;
            text-align: justify;
            margin-top: 10px;
            font-family: 'Courier', monospace;
            border-left: 4px solid #0464ac;
        }

        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
            font-size: 8px;
            color: #a0aec0;
            border-top: 1px solid #e2e8f0;
            padding-top: 5px;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1 class="gov-brand">Guardião DF</h1>
        <div class="sub-title">Relatório de Conformidade LGPD - Sistema de Auditoria de Dados</div>
    </div>

    <table class="info-grid">
        <tr>
            <td class="info-card">
                <span class="label">Documento Analisado</span>
                <span class="value">{{ $analise->nome_arquivo }}</span>
            </td>
            <td style="width: 5%"></td>
            <td class="info-card">
                <span class="label">Data de Emissão</span>
                <span class="value">{{ $analise->created_at->format('d/m/Y H:i') }}</span>
            </td>
            <td style="width: 5%"></td>
            <td class="info-card">
                <span class="label">Nível de Risco</span>
                <span class="value {{ $analise->score_risco > 50 ? 'risk-high' : 'risk-low' }}">
                    {{ $analise->score_risco }}%
                </span>
            </td>
        </tr>
    </table>

    <div class="section-title">Dados Sensíveis Identificados</div>
    <div class="badge-container">
        @php
        $dados = is_array($analise->dados_identificados)
        ? $analise->dados_identificados
        : json_decode($analise->dados_identificados, true);
        @endphp

        @if(!empty($dados) && is_array($dados))
        @foreach($dados as $item)
        <span class="badge">
            {{ is_array($item) ? implode(', ', $item) : $item }}
        </span>
        @endforeach
        @else
        <span style="color: #a0aec0; font-style: italic; font-size: 11px;">Nenhum dado sensível detectado pelo algoritmo de varredura.</span>
        @endif
    </div>

    <div class="section-title">Visualização do Conteúdo Mascarado</div>
    <div class="content-box">
        {!! nl2br(e($analise->conteudo_mascarado)) !!}
    </div>

    <div class="footer">
        Este relatório é um documento técnico gerado automaticamente pelo sistema Guardião DF. <br>
        Controladoria-Geral do Distrito Federal (CGDF) | Participa DF - 2026
    </div>
</body>

</html>