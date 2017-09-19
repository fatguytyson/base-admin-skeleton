<?php
namespace AppBundle\Util;

use Symfony\Component\Templating\EngineInterface;

class TwigMailGenerator
{
    /**
     * @var EngineInterface $render
     */
    protected $render;

    /**
     * @var string $template
     */
    protected $template;

    /**
     * @var array $parameters
     */
    protected $parameters;

    public function __construct(EngineInterface $render)
    {
        $this->render = $render;
    }

    /**
     * Simplifies sending multi-part email through the twig interface.
     *
     * @param string $identifier
     * @param array $parameters
     * @return \Swift_Message $this
     */
    public function getMessage($identifier, $parameters = array())
    {
        $this->setIdentifier($identifier)->setParameters($parameters);

        $subject  = $this->renderBlock('subject');
        $bodyHtml = $this->renderBlock('body_html');
        $bodyText = $this->renderBlock('body_text');

        return \Swift_Message::newInstance()
            ->setSubject($subject)
            ->setBody($bodyHtml, 'text/html')
            ->addPart($bodyText, 'text/plain')
            ;
    }

    private function renderBlock($block)
    {
        return $this->render->render($this->getTemplate(), array_merge(array('email_filter' => $block), $this->parameters));
    }

    public function setIdentifier($identifier)
    {
        $this->template = $identifier;
        return $this;
    }

    public function getTemplate()
    {
        return 'emails/'.$this->template.'.twig';
    }

    public function setParameters($parameters)
    {
        $this->parameters = $parameters;
        return $this;
    }

    public function getParameters()
    {
        return $this->parameters;
    }
}