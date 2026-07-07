{{-- resources/views/emails/leads/new.blade.php --}}
    <!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Новая заявка</title>
    <style>
        body {
            font-family: 'Inter', Arial, sans-serif;
            background: #f8fafc;
            margin: 0;
            padding: 0;
            color: #1A1A1A;
            -webkit-font-smoothing: antialiased;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background: #ffffff;
            overflow: hidden;
        }

        /* ===== HEADER ===== */
        .header {
            padding: 40px 40px 24px;
            border-bottom: 1px solid rgba(26,26,26,0.04);
            background: #FAFAFA;
            position: relative;
            overflow: hidden;
        }

        .header-decor {
            position: absolute;
            right: 20px;
            top: -10px;
            font-family: 'Noto Serif SC', 'SimSun', serif;
            font-size: 120px;
            font-weight: 900;
            color: rgba(26, 26, 26, 0.06);
            pointer-events: none;
            user-select: none;
            line-height: 1;
        }

        .header .badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 9px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 2.5px;
            color: rgba(26, 26, 26, 0.4);
            margin-bottom: 8px;
        }

        .header .badge .dot {
            width: 5px;
            height: 5px;
            border-radius: 50%;
            background: #1A1A1A;
            display: inline-block;
            animation: pulse-dot 2s infinite;
        }

        @keyframes pulse-dot {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.3; transform: scale(1.8); }
        }

        .header h1 {
            font-size: 26px;
            font-weight: 900;
            letter-spacing: -1px;
            text-transform: uppercase;
            color: #1A1A1A;
            margin: 0 0 2px;
            line-height: 1.1;
        }

        .header .sub {
            font-size: 13px;
            color: rgba(26, 26, 26, 0.4);
            font-weight: 400;
            margin: 0;
        }

        /* ===== BODY ===== */
        .body {
            padding: 32px 40px;
        }

        .body .greeting {
            font-size: 13px;
            color: rgba(26, 26, 26, 0.5);
            margin-bottom: 20px;
            line-height: 1.6;
        }

        .body .greeting strong {
            color: #1A1A1A;
            font-weight: 600;
        }

        /* Поля */
        .field {
            padding: 12px 0;
            border-bottom: 1px solid rgba(26, 26, 26, 0.04);
            display: flex;
            align-items: flex-start;
            gap: 16px;
        }

        .field:last-child {
            border-bottom: none;
        }

        .field .label {
            font-size: 9px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: rgba(26, 26, 26, 0.3);
            min-width: 90px;
            flex-shrink: 0;
            padding-top: 2px;
        }

        .field .value {
            font-size: 14px;
            font-weight: 500;
            color: #1A1A1A;
            word-break: break-word;
            line-height: 1.5;
        }

        .field .value .status-badge {
            display: inline-block;
            font-size: 9px;
            font-weight: 600;
            padding: 3px 12px;
            border-radius: 100px;
            background: #1A1A1A;
            color: #FFFFFF;
            letter-spacing: 0.5px;
        }

        /* Сообщение */
        .message-block {
            margin-top: 16px;
            padding: 16px 20px;
            background: #FAFAFA;
            border: 1px solid rgba(26, 26, 26, 0.04);
        }

        .message-block .message-label {
            font-size: 8px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: rgba(26, 26, 26, 0.3);
            margin-bottom: 6px;
            display: block;
        }

        .message-block .message-text {
            font-size: 13px;
            color: #1A1A1A;
            line-height: 1.6;
            margin: 0;
            font-weight: 400;
        }

        /* ===== ИЕРОГЛИФЫ-ДЕКОР ===== */
        .hanzi-decor {
            font-family: 'Noto Serif SC', 'SimSun', serif;
            font-weight: 900;
            color: rgba(26, 26, 26, 0.02);
            line-height: 1;
            user-select: none;
            pointer-events: none;
        }

        /* ===== КНОПКА ===== */
        .btn-wrap {
            margin-top: 24px;
            padding-top: 24px;
            border-top: 1px solid rgba(26, 26, 26, 0.06);
            text-align: center;
        }

        .btn {
            display: inline-block;
            padding: 14px 40px;
            background: #000000;
            color: #FFFFFF !important;
            text-decoration: none;
            font-size: 10px;
            font-weight: 600;
            letter-spacing: 2.5px;
            text-transform: uppercase;
            transition: background 0.3s ease;
            border-radius: 0;
        }

        .btn:hover {
            background: #000000;
            color: #FFFFFF !important;
        }

        /* ===== FOOTER ===== */
        .footer {
            padding: 24px 40px;
            background: #FAFAFA;
            border-top: 1px solid rgba(26, 26, 26, 0.04);
            text-align: center;
        }

        .footer .brand {
            font-weight: 800;
            font-size: 16px;
            color: #1A1A1A;
            letter-spacing: -0.5px;
            display: block;
            margin-bottom: 4px;
        }

        .footer .brand .yin-yang {
            font-family: 'Noto Serif SC', 'SimSun', serif;
            font-weight: 900;
            color: rgba(26, 26, 26, 0.15);
            font-size: 14px;
        }

        .footer .meta {
            font-size: 11px;
            color: rgba(26, 26, 26, 0.3);
            margin: 0;
            line-height: 1.6;
        }

        .footer .meta a {
            color: #1A1A1A;
            text-decoration: underline;
            text-underline-offset: 2px;
        }

        .footer .meta .separator {
            color: rgba(26, 26, 26, 0.1);
            margin: 0 6px;
        }

        /* ===== АДАПТИВ ===== */
        @media (max-width: 480px) {
            .header { padding: 28px 20px 16px; }
            .body { padding: 20px; }
            .footer { padding: 20px; }

            .header h1 { font-size: 20px; }
            .header .header-decor { font-size: 80px; right: 10px; top: 0; }

            .field { flex-direction: column; gap: 4px; padding: 10px 0; }
            .field .label { min-width: auto; font-size: 8px; }
            .field .value { font-size: 13px; }

            .btn { padding: 12px 24px; font-size: 9px; letter-spacing: 2px; width: 100%; text-align: center; }

            .footer .brand { font-size: 14px; }
            .footer .meta { font-size: 10px; }
        }

        @media (max-width: 380px) {
            .header h1 { font-size: 17px; }
            .field .value { font-size: 12px; }
            .message-block .message-text { font-size: 12px; }
        }

        /* ===== REDUCED MOTION ===== */
        @media (prefers-reduced-motion: reduce) {
            .header .badge .dot {
                animation: none !important;
            }
        }
    </style>
</head>
<body>
<div class="container">

    {{-- ===== HEADER ===== --}}
    <div class="header">
        <span class="header-decor">信</span>

        <h1>Заявка #{{ $lead->id }}</h1>
        <p class="sub">{{ $lead->created_at->format('d.m.Y H:i') }}</p>
    </div>

    {{-- ===== BODY ===== --}}
    <div class="body">
        <p class="greeting">
            Здравствуйте! Поступила новая заявка от <strong>{{ $lead->name }}</strong>.
        </p>

        {{-- Поля --}}
        <div class="field">
            <span class="label">Имя</span>
            <span class="value">{{ $lead->name }}</span>
        </div>

        <div class="field">
            <span class="label">Телефон</span>
            <span class="value">{{ $lead->phone ?? '—' }}</span>
        </div>

        <div class="field">
            <span class="label">Email</span>
            <span class="value">{{ $lead->email ?? '—' }}</span>
        </div>

        <div class="field">
            <span class="label">Город</span>
            <span class="value">{{ $lead->delivery_city ?? '—' }}</span>
        </div>

        <div class="field">
            <span class="label">Бюджет</span>
            <span class="value">{{ $lead->estimated_budget ? number_format((float) $lead->estimated_budget, 0, '.', ' ') . ' ₽' : '—' }}</span>
        </div>

        <div class="field">
            <span class="label">Товар</span>
            <span class="value">{{ $lead->product?->name ?? 'Не указан' }}</span>
        </div>

        <div class="field">
            <span class="label">Статус</span>
            <span class="value">
                <span class="status-badge">{{ \App\Models\Lead::getStatuses()[$lead->status] ?? $lead->status }}</span>
            </span>
        </div>

        {{-- Сообщение --}}
        @if($lead->message)
            <div class="message-block">
                <span class="message-label">Сообщение</span>
                <p class="message-text">{{ $lead->message }}</p>
            </div>
        @endif

        {{-- Кнопка --}}
        <div class="btn-wrap">
            <a href="{{ route('admin.leads.show', $lead) }}" class="btn">Перейти к заявке</a>
        </div>
    </div>
</div>
</body>
</html>
