<?php

namespace Eni\Blog\Services;

use Symfony\Component\Translation\TranslatorInterface;

class SearchService {
    /** @var TranslatorInterface */
    private $translator;

    /**
     * @param TranslatorInterface $translator
     */
    public function __construct(
        TranslatorInterface $translator
    ) {
        $this->translator = $translator;
    }

    /**
     * @return string
     */
    public function getNoResultsMessage() {
        return $this->translator->trans('There are no results matching your query', [], 'Modules.Eniblog');
    }
}