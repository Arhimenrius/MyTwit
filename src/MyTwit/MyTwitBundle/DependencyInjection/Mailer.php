<?php
namespace MyTwit\MyTwitBundle\DependencyInjection;

/**
 * @Annotation Class is for configurate and send mail
 * 
 * @param protected $_em Include connect to DB
 * @param protected $_config Include config_helper
 * @param protected $_mailer Include mailer
 * @param protected $_returned_config Get config
 * @param protected $returned_mail Retur prepared mail
 */
class Mailer
{
    protected $_em;
    protected $_config;
    protected $_mailer;   
    protected $_returned_config;
    protected $_returned_mail;
    
    /**
     * Include services
     * 
     * @param \Doctrine\ORM\EntityManager $em Include database service
     * @param \Awojtys\TicketServBundle\DependencyInjection\ConfigHelper $config Include config_helper service
     * @param type $mailer Include mailer service
     */
    public function __construct(\Doctrine\ORM\EntityManager $em, \MyTwit\MyTwitBundle\DependencyInjection\ConfigHelper $config, $mailer)
    {
        $this->_em = $em;
        $this->_config = $config;
        $this->_mailer = $mailer;
    }
    
    /**
     * Include and return config
     */
    protected function _prepareConfig()
    {
        $options = $this->_config ->getAllOptions();
        
        $transport = \Swift_SmtpTransport::newInstance()
                ->setUsername($options['Set_Mail_Username'])
                ->setPassword($options['Set_Mail_Password'])
                ->setHost($options['Host_Name'])
                ->setPort($options['Set_Port'])
                ->setEncryption($options['Set_Encryption']);
        
        $this->_mailer = \Swift_Mailer::newInstance($transport);
    }
    
    /**
     * 
     * @param string $subject Title of mail
     * @param string $to Adress to user
     * @param string $body Content of mail
     * @return array Return prepared e-mail
     */
    public function prepareMail($subject, $to, $body)
    {
        $message = \Swift_Message::newInstance()
                ->setSubject($subject)
                ->setFrom('andrzej.wojtys@polcode.net')
                ->setTo($to)
                ->setBody($body)
                ->setContentType('text/html');
        return $this->_returned_mail = $message;        
   }
   
   /**
    * Send Mail
    */
   public function SendMail()
   {
       $this->_prepareConfig();
       $this->_mailer->send($this->_returned_mail);
   }
}

?>
