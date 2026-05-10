<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; background: #0f172a; color: #e2e8f0; margin: 0; padding: 20px; }
        .card { background: #1e293b; border: 1px solid #334155; border-radius: 16px; padding: 32px; max-width: 560px; margin: 0 auto; }
        .header { border-bottom: 1px solid #334155; padding-bottom: 20px; margin-bottom: 24px; }
        .badge { display: inline-block; background: rgba(6,182,212,.15); color: #06b6d4; border: 1px solid rgba(6,182,212,.3); border-radius: 99px; padding: 4px 12px; font-size: 11px; font-weight: 600; letter-spacing: .05em; text-transform: uppercase; }
        h2 { color: #f8fafc; font-size: 20px; margin: 12px 0 4px; }
        .label { font-size: 11px; color: #64748b; text-transform: uppercase; letter-spacing: .08em; margin-bottom: 4px; }
        .value { font-size: 14px; color: #cbd5e1; margin-bottom: 20px; }
        .message-box { background: #0f172a; border: 1px solid #334155; border-radius: 12px; padding: 20px; font-size: 14px; color: #94a3b8; line-height: 1.7; white-space: pre-wrap; }
        .footer { margin-top: 28px; padding-top: 20px; border-top: 1px solid #1e293b; font-size: 12px; color: #475569; text-align: center; }
        a { color: #06b6d4; }
    </style>
</head>
<body>
<div class="card">
    <div class="header">
        <span class="badge">HubFolio</span>
        <h2>Nouveau message reçu</h2>
        <p style="color:#64748b;font-size:13px;margin:0">{{ now()->format('d/m/Y à H:i') }}</p>
    </div>

    <div class="label">De</div>
    <div class="value">{{ $contactMessage->name }} &lt;<a href="mailto:{{ $contactMessage->email }}">{{ $contactMessage->email }}</a>&gt;</div>

    <div class="label">Sujet</div>
    <div class="value" style="font-weight:600;color:#f1f5f9">{{ $contactMessage->subject }}</div>

    <div class="label">Message</div>
    <div class="message-box">{{ $contactMessage->message }}</div>

    <div class="footer">
        Répondre directement à <a href="mailto:{{ $contactMessage->email }}">{{ $contactMessage->email }}</a><br>
        <a href="{{ url('/admin/dashboard') }}">Voir dans le dashboard admin</a>
    </div>
</div>
</body>
</html>
