<?php
/**
 * Contact form
 *
 * @author Lucas CORBEAUX
 * @category MaitreCorbeaux
 * @package Default
 * @subpackage Form
 * @see Zend_Form
 */
class MaitreCorbeaux_Form_Contact extends Zend_Form
{
    public function init()
    {
        $this->setMethod('post');
        
        $this->addElement('text', 'email', array(
            'label' => 'Votre adresse email* :',
            'required' => true,
            'validators' => array('EmailAddress')
        ));

        $this->addElement('text', 'subject', array(
            'label' => 'Objet de votre message* :',
            'required' => true,
            'validators' => array(array('StringLength', false, array(5, 50)))
        ));

        $this->addElement('textarea', 'body', array(
            'label' => 'Votre message* :',
            'required' => true
        ));

        $this->addElement('checkbox', 'copy', array(
            'label' => 'Je souhaite recevoir une copie de cet email :',
            'decorators' => array('Label',
                                  'ViewHelper',
                                  array('HtmlTag',
                                        array('tag' => 'dd',
                                              'id' => 'copy-element')))
        ));

        $this->addElement('captcha', 'captcha', array(
            'captcha' => 'ReCaptcha'
        ));

        $this->addElement('submit', 'send', array(
            'label' => 'Envoyer',
            'decorators' => array('ViewHelper',
                                  array('HtmlTag',
                                        array('tag' => 'dd',
                                              'id' => 'send-element')))
        ));
    }
}