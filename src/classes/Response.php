<?php

/**
 * Class Response
 */
class Response implements \Guzzle\Service\Command\ResponseClassInterface
{
    /**
     * @var string
     */
    private $url;

    /**
     * @param \Guzzle\Service\Command\OperationCommand $command
     *
     * @return Response
     */
    public static function fromCommand(\Guzzle\Service\Command\OperationCommand $command)
    {
        $data     = $command->getResponse()->json();
        $response = new self();
        $response->url = $data['url'];

        return $response;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }
}
