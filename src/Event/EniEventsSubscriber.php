<?php

# src/Event/

namespace Eni\Blog\Event;

use PrestaShopBundle\Service\Hook\RenderingHookEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class EniEventsSubscriber implements EventSubscriberInterface
{
    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * @return array The listeners array
     */
    public static function getSubscribedEvents()
    {
        return [
            'eni_block' => ['onRenderBlock', 0],
        ];
    }

    /**
     * Renders a block.
     *
     * @param RenderingHookEvent $event
     *
     * @throws \Exception
     */
    public function onRenderBlock(RenderingHookEvent $event)
    {
        if (!array_key_exists('block_name', $event->getHookParameters())) {
            throw new \Exception('The block_name parameter is missing.');
        }

        $blockName = $event->getHookParameters()['block_name'];

        $event->setContent([$blockName, 'test']);
    }
}
