<?php

namespace Src;


class Mailer
{
    public function send($userEmail, $imageName, $name)
    {
        $transport = (new \Swift_SmtpTransport('smtp.mail.ru', 465, 'ssl'))
            ->setUsername('p-olhovoi@bk.ru')
            ->setPassword('nozhivilki183');
        // Create the Mailer using your created Transport
        $mailer = new \Swift_Mailer($transport);

        // Create a message
        $message = (new \Swift_Message('Вы успешно зарегистрированы'))
            ->setFrom(['p-olhovoi@bk.ru' => 'Павел Ольховой'])
            ->setTo([$userEmail => 'Вы прошли успешную регистрацию'])
            ->setBody("$name, текстовое описание")
            ->attach(\Swift_Attachment::fromPath("../public/images/$imageName"));

        // Send the message
        $result = $mailer->send($message);
    }
}

