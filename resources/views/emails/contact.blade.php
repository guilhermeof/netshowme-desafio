<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
    "http://www.w3.org/TR/html4/loose.dtd">

<html lang="pt-br">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Novo Contato</title>
</head>

<body bgcolor="#f6f6f6" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0"
      style="-webkit-font-smoothing: antialiased;width:100% !important;background:#f6f6f6;-webkit-text-size-adjust:none;">
<table width="100%" cellpadding="0" cellspacing="0" border="0" bgcolor="#f6f6f6"
       style="font-family: Arial, sans-serif;">
    <tbody>
    <tr>
        <td></td>
        <td style="display: block !important;max-width: 600px !important;margin: 0 auto !important;clear: both !important;"
            width="600">
            <div style="max-width: 600px;margin: 0 auto;display: block;padding:20px;">
                <table class="main" width="100%" cellpadding="0" cellspacing="0"
                       style="background: #fff;border: 1px solid #e9e9e9;border-radius: 3px;">
                    <tbody>
                    <tr>
                        <td style="font-size: 18px; color: #fff; font-weight: 500; padding: 20px; text-align: center; border-radius: 3px 3px 0 0; background: #265876;">
                            Dados do novo contato
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 20px;">
                            <table width="100%" cellpadding="0" cellspacing="0">
                                <tbody>
                                <tr>
                                    <td style="padding: 0 0 20px;">
                                        <h3 style="margin-top: 0; color: #74787E; font-size: 16px; line-height: 1.5em;">
                                            Informações enviadas</h3>
                                        <p style="margin-top: 0; color: #74787E; font-size: 16px; line-height: 1.5em;">
                                            <strong>Nome: </strong>{{ $name}}</p>

                                        <p style="margin-top: 0; color: #74787E; font-size: 16px; line-height: 1.5em;">
                                            <strong>E-mail: </strong>{{ $email }}</p>

                                        <p style="margin-top: 0; color: #74787E; font-size: 16px; line-height: 1.5em;">
                                            <strong>Telefone: </strong>{{ $phone }}</p>

                                        <p style="margin-top: 0; color: #74787E; font-size: 16px; line-height: 1.5em;">
                                            <strong>Endereço de IP: </strong>{{ $ip }}</p>

                                        <p style="margin-top: 0; color: #74787E; font-size: 16px; line-height: 1.5em;">
                                            <strong>Data de criação: </strong>{{ $created_at }}</p>

                                        <p style="margin-top: 0; color: #74787E; font-size: 16px; line-height: 1.5em;">
                                            <strong>Mensagem:</strong></p>
                                        <p style="margin-top: 0; color: #74787E; font-size: 16px; line-height: 1.5em;">{{ $message_sent }}</p>

                                        <p style="margin-top: 0; color: #74787E; font-size: 16px; line-height: 1.5em;">
                                            <strong>Anexo:</strong></p>
                                        <p style="margin-top: 0; color: #74787E; font-size: 16px; line-height: 1.5em;">{{ $attachment->name}} </p>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div style="width: 100%;clear: both;color: #999; padding: 20px;">
                    <table width="100%">
                        <tbody>
                        <tr>
                            <td style="font-size: 16px; font-weight: bold; text-align: center; padding: 0 0 20px;">
                                Sistema de Cadastro de Contatos
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </td>
        <td></td>
    </tr>
    </tbody>
</table>
