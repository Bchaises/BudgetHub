<div style="font-family: Arial, sans-serif; color: #333; line-height: 1.6; background-color: #f9f9f9; padding: 20px;">
    <div style="max-width: 600px; margin: auto; background-color: #ffffff; border-radius: 8px; padding: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
        <h1 style="font-size: 24px; color: #4CAF50; text-align: center;">Invitation à rejoindre un compte</h1>
        <p style="font-size: 16px; color: #555;">Bonjour,</p>
        <p style="font-size: 16px; color: #555;">
            Vous avez été invité à rejoindre un compte. Pour accepter ou refuser cette invitation, veuillez cliquer sur l'un des liens ci-dessous :
        </p>
        <div style="text-align: center; margin-top: 20px;">
            <a href="{{ route('invitation.respond', ['token' => $invitation->token]).'?status=accepted' }}"
               style="display: inline-block; padding: 10px 20px; color: #fff; background-color: #4CAF50; text-decoration: none; border-radius: 5px; font-size: 16px; margin: 5px;">
                Accepter
            </a>
            <a href="{{ route('invitation.respond', ['token' => $invitation->token]).'?status=declined' }}"
               style="display: inline-block; padding: 10px 20px; color: #fff; background-color: #F44336; text-decoration: none; border-radius: 5px; font-size: 16px; margin: 5px;">
                Refuser
            </a>
        </div>
        <p style="font-size: 14px; color: #888; text-align: center; margin-top: 20px;">
            Si vous n'êtes pas à l'origine de cette invitation, vous pouvez ignorer ce message.
        </p>
        <p style="font-size: 14px; color: #aaa; text-align: center; margin-top: 20px;">
            Merci, <br/> L'équipe du projet
        </p>
    </div>
</div>
