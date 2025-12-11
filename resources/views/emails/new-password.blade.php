<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Nouveau mot de passe</title>
  <style>
    /* Basic email-safe resets */
    body, table, td, a { -webkit-text-size-adjust:100%; -ms-text-size-adjust:100%; }
    table, td { mso-table-lspace:0pt; mso-table-rspace:0pt; }
    img { -ms-interpolation-mode:bicubic; border:0; height:auto; line-height:100%; outline:none; text-decoration:none; }
    body { margin:0; padding:0; width:100% !important; -webkit-font-smoothing:antialiased; background-color:#f4f6f8; }
    a { color: inherit; text-decoration: none; }

    /* Container */
    .email-wrapper { width:100%; background-color:#f4f6f8; padding: 24px 0; }
    .email-content { max-width:600px; margin:0 auto; }

    /* Card */
    .card { background:#ffffff; border-radius:12px; overflow:hidden; box-shadow:0 6px 18px rgba(0,0,0,0.06); }

    /* Header */
    .brand {
      display:flex;
      align-items:center;
      gap:12px;
      padding:20px 24px;
      background: linear-gradient(90deg,#2ecc71 0%, #27ae60 100%); /* grane gradient */
      color:#ffffff;
    }
    .brand .logo {
      width:48px;
      height:48px;
      border-radius:8px;
      background: rgba(255,255,255,0.15);
      display:flex;
      align-items:center;
      justify-content:center;
      font-weight:700;
      font-family: Arial, sans-serif;
    }
    .brand h1 {
      font-size:18px;
      margin:0;
      font-family: Arial, sans-serif;
    }

    /* Body */
    .body {
      padding:28px 24px;
      font-family: "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
      color:#333333;
      line-height:1.5;
      font-size:15px;
    }
    .greeting { margin:0 0 12px 0; font-weight:600; }
    .note { margin:12px 0 18px 0; color:#555555; font-size:14px; }
    .password-box {
      display:inline-block;
      background:#f1fbf5;
      border:1px dashed #cbeed2;
      color:#0a6b2f;
      padding:10px 16px;
      border-radius:8px;
      font-weight:700;
      font-family: monospace;
      font-size:16px;
      margin:8px 0 18px 0;
    }

    /* Button */
    .btn {
      display:inline-block;
      padding:12px 18px;
      border-radius:8px;
      background:#2ecc71;
      color:#ffffff !important;
      font-weight:600;
      text-decoration:none;
      font-size:15px;
    }

    /* Footer */
    .footer {
      padding:18px 24px;
      font-size:12px;
      color:#8892a0;
      background:#fbfdfe;
      border-top:1px solid #eef3f6;
    }

    /* Responsiveness */
    @media screen and (max-width: 420px) {
      .brand h1 { font-size:16px; }
      .body { padding:18px 16px; }
      .password-box { font-size:15px; padding:8px 12px; }
    }
  </style>
</head>
<body>
  <table role="presentation" class="email-wrapper" width="100%" cellspacing="0" cellpadding="0">
    <tr>
      <td align="center">
        <table role="presentation" class="email-content" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="card" align="left" style="border-radius:12px; overflow:hidden;">
              <!-- Header / Brand -->
              <div class="brand">
                <div class="logo">ES</div>
                <h1>Ecomm Store</h1>
              </div>

              <!-- Body -->
              <div class="body">
                <p class="greeting">Bonjour {{ strtoupper($fname)  }} - {{ strtoupper($lname) }} ,</p>

                <p class="note">
                  Votre mot de passe a été réinitialisé comme demandé. Voici vos nouvelles informations de connexion :
                </p>

                <div class="password-box">
                  {{ $password }}
                </div>

                <p class="note">
                  Pour votre sécurité, nous vous recommandons de vous connecter et de changer ce mot de passe dès que possible via votre espace personnel.
                </p>

                <p style="margin: 18px 0;">
                  <a href="#" class="btn" target="_blank" rel="noopener">Se connecter</a>
                </p>

                <hr style="border:none;border-top:1px solid #eef3f6;margin:18px 0;">

                <p style="font-size:13px;color:#666;margin:0;">
                  Si vous n'avez pas demandé cette réinitialisation, <strong>ignorez cet email</strong> ou contactez notre support.
                </p>
              </div>

              <!-- Footer -->
              <div class="footer" style="text-align:center;">
                <div style="margin-bottom:8px;">L'équipe LunaFlow</div>
                <div>Adresse: Casablanca • Maroc</div>
                <div style="margin-top:6px;">© {{ date('Y') }} LunaFlow. Tous droits réservés.</div>
              </div>
            </td>
          </tr>

          <!-- Small plain footer text -->
          <tr>
            <td style="padding-top:12px;text-align:center;font-size:12px;color:#9aa6b2;">
              Vous recevez cet e-mail parce que votre adresse est associée à un compte sur LunaFlow.
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</body>
</html>
