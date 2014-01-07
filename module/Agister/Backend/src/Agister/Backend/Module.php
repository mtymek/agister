<?php

namespace Agister\Backend;

use Zend\Mvc\MvcEvent;
use Zend\Json\Json;

class Module
{
    /**
     * Provide module configuration
     *
     * @return array
     */
    public function getConfig()
    {
        return include __DIR__ . '/../../../config/module.config.php';
    }

    /**
     * Optional pretty print of JSON output
     *
     * @param MvcEvent $e
     */
    public function onBootstrap(MvcEvent $e)
    {
        $app = $e->getApplication();
        $em = $app->getEventManager();

        $em->attach(
            MvcEvent::EVENT_FINISH,

            // TODO: move to separate class
            function ($e) {
                $response = $e->getResponse();
                $headers = $response->getHeaders();
                if (!$headers->has('Content-Type')) {
                    return;
                }

                $contentType = $headers->get('Content-Type');
                $value = $contentType->getFieldValue();
                if (false !== strpos('application/json', $value)) {
                    return;
                }

                $request = $e->getRequest();
                $headers = $request->getHeaders();
                if (!$headers->has('X-Pretty-Json')) {
                    return;
                }

                $body = $response->getContent();
                $body = Json::prettyPrint(
                    $body,
                    array(
                        'indent' => '  '
                    )
                );
                $body = $body . "\n";
                $response->setContent($body);
            }
        );
    }
}
