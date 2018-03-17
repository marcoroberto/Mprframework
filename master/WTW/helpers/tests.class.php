<?php
namespace WTW\Helpers;

/**
 * Description of tests
 *
 * @author marco
 */
class tests {
    /**
     * send test email using the helper class
     */
    public static function sendEmail($amailTo, $eamilToName)
    {
        $paramTo = array(
            array(
                'email' => $emailTo, 
                'name' => $emailToName
            )
        );
        $paramCc = array(
            array(
                'email' => 'marco.roberto@willistowerswatson.com', 
                'name' => 'Marco Parada Roberto'
            )
        );
        $paramBcc = array(
            array(
                'email' => 'marco.roberto@willistowerswatson.com', 
                'name' => 'Marco Parada Roberto'
            )
        );
        $paramSubject = 'É o assunto do email.';
        $paramMessage = 'Esta é uma mensagem de teste<br>Cumprimentos,<br>Marco Roberto';
        $paramAltBody = '';
        $paramAttach = array('D:/workspaces_tfs2010/mybenflex/mybenflex/Branches/New Ideas/backend/composer.json');
        \WTW\Helpers\globalHelper::sendEmail($paramTo, $paramCc, $paramBcc, $paramSubject, $paramMessage, $paramAltBody, $paramAttach);        
    }
}
