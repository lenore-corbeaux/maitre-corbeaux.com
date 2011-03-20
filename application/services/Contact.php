<?php
/**
 * Contact service
 *
 * @author Lucas CORBEAUX
 * @category MaitreCorbeaux
 * @package Default
 * @subpackage Service
 * @see MaitreCorbeaux_Service_AbstractService
 */
class MaitreCorbeaux_Service_Contact
extends MaitreCorbeaux_Service_AbstractService
{
    /**
     *
     * @var Zend_Mail
     */
    protected $_mail;

    /**
     *
     * @var Zend_Form
     */
    protected $_form;

    /**
     *
     * @var string
     */
    protected $_emailAddress;

    /**
     * Send an email using the post data
     *
     * @param array $data
     * @return bool
     */
    public function send(array $data)
    {
        $form = $this->getForm();

        if (!$form->isValid($data)) {
            return false;
        }

        $mail = $this->getMail();
        $mail->setSubject($form->getValue('subject'))
             ->setBodyText($form->getValue('body'));

        $senderEmail = $form->getValue('email');

        if ($form->getValue('copy')) {
            $copyMail = clone $mail;
            $copyMail->addTo($senderEmail)
                     ->send();
        }

        $mail->setReplyTo($senderEmail)
             ->addTo($this->getEmailAddress())
             ->send();

        return true;
    }

    /**
     *
     * @return Zend_Mail
     */
    public function getMail()
    {
        if (null === $this->_mail) {
            $this->_mail = new Zend_Mail();
        }

        return $this->_mail;
    }

    /**
     *
     * @param Zend_Mail $value
     * @return MaitreCorbeaux_Service_Contact
     */
    public function setMail(Zend_Mail $value)
    {
        $this->_mail = $mail;
        return $this;
    }

    /**
     *
     * @return Zend_Form
     */
    public function getForm()
    {
        if (null === $this->_form) {
            $bootstrap = $this->getBootstrap();
            $router = $bootstrap->getResource('router');

            $action = $router->assemble(array(
                'action' => 'index',
                'controller' => 'contact',
                'module' => 'default'
            ), 'default', true);

            $this->_form = new MaitreCorbeaux_Form_Contact(array(
                'action' => $action
            ));

            $reCaptchaService = $bootstrap->getResource('ReCaptcha');

            $this->_form->getElement('captcha')
                        ->getCaptcha()
                        ->setService($reCaptchaService);
        }

        return $this->_form;
    }

    /**
     *
     * @param Zend_Form $value
     * @return MaitreCorbeaux_Service_Contact
     */
    public function setForm(Zend_Form $value)
    {
        $this->_form = $value;
        return $this;
    }

    /**
     *
     * @return string
     */
    public function getEmailAddress()
    {
        if (null === $this->_emailAddress) {
            $bootstrap = $this->getBootstrap();
            $contactOptions = $bootstrap->getResource('Contact');
            $this->_emailAddress = $contactOptions['emailAddress'];
        }

        return $this->_emailAddress;
    }

    /**
     *
     * @param string $value
     * @return MaitreCorbeaux_Service_Contact
     */
    public function setEmailAddress($value)
    {
        $this->_emailAddress = (string) $value;
        return $this;
    }
}