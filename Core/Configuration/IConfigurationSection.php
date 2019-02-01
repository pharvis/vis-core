<?php

namespace Core\Configuration;

/**
 * Provides a mechanism to handle XML configuration sections.
 */
interface IConfigurationSection{

    /**
     * This method is intended to process XML configuration data and return
     * a section value of any type. This method is called when an instance of
     * this interface is added to a Configuration object using the add() method.
     */
    public function execute(Configuration $config, \XmlConfigElement $xml);
}