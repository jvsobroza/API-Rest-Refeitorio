<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>REFEITORIO :: Cardápio Semanal</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * {
            box-sizing: border-box;
        }
        body {
            background-color: #f8fafc;
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
            color: #334155;
        }

        /* NAVBAR */
        .custom-navbar {
            background-color: #ffffff;
            border-bottom: 1px solid #e2e8f0;
            height: 66px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 40px;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05);
        }
        .navbar-brand-box {
            background-color: #16a34a;
            color: white;
            padding: 8px 18px;
            border-radius: 6px;
            font-weight: 700;
            font-size: 14px;
            letter-spacing: 0.5px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* CONTAINER */
        .main-container {
            margin-top: 106px;
            padding: 0 40px 60px;
            max-width: 1200px;
            margin-left: auto;
            margin-right: auto;
        }

        /* HEADER */
        .header-title-box {
            margin-bottom: 28px;
        }
        .header-title-box h1 {
            font-size: 22px;
            font-weight: 700;
            color: #16a34a;
            margin: 0 0 4px 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .text-muted {
            color: #64748b;
            margin: 0;
            font-size: 14px;
        }

        /* ACCORDION */
        .accordion-wrapper {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            overflow: hidden;
        }

        .accordion-item {
            border-bottom: 1px solid #e2e8f0;
        }
        .accordion-item:last-child {
            border-bottom: none;
        }

        .accordion-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 18px 24px;
            cursor: pointer;
            user-select: none;
            background: #ffffff;
            transition: background 0.15s ease;
        }
        .accordion-header:hover {
            background: #f8fafc;
        }

        .accordion-header-title {
            font-size: 14px;
            font-weight: 500;
            color: #334155;
        }

        .accordion-icon {
            font-size: 18px;
            color: #94a3b8;
            line-height: 1;
            transition: transform 0.2s ease;
            font-weight: 300;
        }

        /* BODY DO ACCORDION */
        .accordion-body {
            display: none;
            padding: 20px 24px 28px;
            background: #ffffff;
        }
        .accordion-body.open {
            display: block;
        }

        /* GRID DE CARDS DE REFEIÇÃO */
        .meals-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        @media (max-width: 768px) {
            .meals-grid {
                grid-template-columns: 1fr;
            }
            .main-container {
                padding: 0 16px 60px;
            }
            .custom-navbar {
                padding: 0 16px;
            }
        }

        /* CARD DE REFEIÇÃO */
        .meal-card {
            border: 1px solid #4ade80;
            border-radius: 6px;
            padding: 16px 18px;
            min-height: 110px;
        }

        .meal-card-title {
            font-size: 15px;
            font-weight: 600;
            color: #1e293b;
            margin: 0 0 10px 0;
        }

        .meal-card-items {
            font-size: 13px;
            color: #64748b;
            margin: 0;
            line-height: 1.6;
        }

        /* VAZIO */
        .empty-state {
            text-align: center;
            padding: 48px 24px;
            color: #94a3b8;
            font-size: 14px;
        }
        .empty-state i {
            font-size: 28px;
            margin-bottom: 10px;
            display: block;
            color: #cbd5e1;
        }

        /* FOOTER */
        .custom-footer {
            text-align: center;
            padding: 24px;
            color: #64748b;
            font-size: 13px;
            border-top: 1px solid #e2e8f0;
            background: #ffffff;
            margin-top: 80px;
        }
        .custom-footer a {
            color: #16a34a;
            text-decoration: none;
            font-weight: 500;
        }
    </style>
</head>
<body>

    <div class="custom-navbar">
        <div class="navbar-brand-box">
            <i class="fas fa-graduation-cap"></i> REFEITORIO
        </div>
    </div>

    <div class="main-container">

        <div class="header-title-box">
            <h1>Cardápio Semanal</h1>
        </div>

        @php
            $diasSemana = [
                0 => 'Domingo', 1 => 'Segunda-feira', 2 => 'Terça-feira',
                3 => 'Quarta-feira', 4 => 'Quinta-feira', 5 => 'Sexta-feira', 6 => 'Sábado'
            ];

            $turnos = [
                1 => 'Café da manhã',
                2 => 'Almoço',
                3 => 'Jantar',
            ];

            $agrupado = [];
            foreach ($refeicoes as $refeicao) {
                $data = \Carbon\Carbon::parse($refeicao->data);
                $chave = $data->format('Y-m-d');
                if (!isset($agrupado[$chave])) {
                    $agrupado[$chave] = [
                        'data'       => $data,
                        'refeicoes'  => [],
                    ];
                }
                $agrupado[$chave]['refeicoes'][$refeicao->turno] = $refeicao->refeicao;
            }

            ksort($agrupado);

            $hoje = \Carbon\Carbon::today()->format('Y-m-d');
        @endphp

        @if(count($agrupado) > 0)
            <div class="accordion-wrapper">
                @foreach($agrupado as $chave => $dia)
                    @php
                        $isAberto = ($chave === $hoje);
                        $dataFormatada = $dia['data']->format('d/m/Y');
                        $nomeDia = $diasSemana[$dia['data']->dayOfWeek];
                    @endphp

                    <div class="accordion-item">
                        <div class="accordion-header" onclick="toggleAccordion(this)">
                            <span class="accordion-header-title">
                                Cardápio do dia {{ $dataFormatada }} - {{ $nomeDia }}
                            </span>
                            <span class="accordion-icon">{{ $isAberto ? '−' : '+' }}</span>
                        </div>

                        <div class="accordion-body {{ $isAberto ? 'open' : '' }}">
                            <div class="meals-grid">
                                @foreach($turnos as $turnoId => $turnoNome)
                                    <div class="meal-card">
                                        <p class="meal-card-title">{{ $turnoNome }}</p>
                                        @if(isset($dia['refeicoes'][$turnoId]))
                                            <p class="meal-card-items">{{ $dia['refeicoes'][$turnoId] }}</p>
                                        @else
                                            <p class="meal-card-items" style="font-style: italic;">Não informado</p>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <i class="fas fa-info-circle"></i>
                Nenhuma refeição cadastrada para esta semana.
            </div>
        @endif

    </div>

    <div class="custom-footer">
        &copy; {{ date('Y') }} Refeitório &mdash; Sistema de Cardápio
    </div>

    <script>
        function toggleAccordion(header) {
            const body = header.nextElementSibling;
            const icon = header.querySelector('.accordion-icon');
            const isOpen = body.classList.contains('open');

            body.classList.toggle('open', !isOpen);
            icon.textContent = isOpen ? '+' : '−';
        }
    </script>

</body>
</html>