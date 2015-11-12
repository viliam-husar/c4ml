<?php

namespace ViliamHusar\C4ml;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\Processor;
use ViliamHusar\C4ml\Model\Container;
use ViliamHusar\C4ml\Model\ExternalSystem;
use ViliamHusar\C4ml\Model\ExternalUser;
use ViliamHusar\C4ml\Model\InternalSystem;
use ViliamHusar\C4ml\Model\InternalUser;
use ViliamHusar\C4ml\Model\Model;
use ViliamHusar\C4ml\Model\ElementInterface;
use ViliamHusar\C4ml\Model\Usage;
use Symfony\Component\Yaml\Yaml;

class C4ml
{
    const VERSION = '1.0.0';

    /**
     * @param string $content
     *
     * @return Model
     *
     */
    public static function parse($content)
    {
        $content = Yaml::parse($content);

        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('model');
        $rootNode
            ->normalizeKeys(false)
            ->children()
            ->scalarNode('name')->end()
            ->scalarNode('desc')->defaultNull()->end()
            ->arrayNode('internal-systems')
            ->normalizeKeys(false)
            ->prototype('array')
            ->children()
            ->scalarNode('name')->end()
            ->scalarNode('desc')->defaultNull()->end()
            ->arrayNode('containers')
            ->normalizeKeys(false)
            ->prototype('array')
            ->children()
            ->scalarNode('name')->end()
            ->scalarNode('desc')->defaultNull()->end()
            ->scalarNode('type')->defaultNull()->end()
            ->arrayNode('uses')
            ->normalizeKeys(false)
            ->prototype('array')
            ->children()
            ->scalarNode('for')->defaultNull()->end()
            ->scalarNode('type')->defaultNull()->end()
            ->end()
            ->end()
            ->end()
            ->end()
            ->end()
            ->end()
            ->end()
            ->end()
            ->end()
            ->arrayNode('external-systems')
            ->normalizeKeys(false)
            ->prototype('array')
            ->children()
            ->scalarNode('name')->end()
            ->scalarNode('desc')->defaultNull()->end()
            ->arrayNode('uses')
            ->normalizeKeys(false)
            ->prototype('array')
            ->children()
            ->scalarNode('for')->defaultNull()->end()
            ->scalarNode('type')->defaultNull()->end()
            ->end()
            ->end()
            ->end()
            ->end()
            ->end()
            ->end()
            ->arrayNode('internal-users')
            ->normalizeKeys(false)
            ->prototype('array')
            ->children()
            ->scalarNode('name')->end()
            ->scalarNode('desc')->defaultNull()->end()
            ->arrayNode('uses')
            ->normalizeKeys(false)
            ->prototype('array')
            ->children()
            ->scalarNode('for')->defaultNull()->end()
            ->scalarNode('type')->defaultNull()->end()
            ->end()
            ->end()
            ->end()
            ->end()
            ->end()
            ->end()
            ->arrayNode('external-users')
            ->normalizeKeys(false)
            ->prototype('array')
            ->children()
            ->scalarNode('name')->end()
            ->scalarNode('desc')->defaultNull()->end()
            ->arrayNode('uses')
            ->normalizeKeys(false)
            ->prototype('array')
            ->children()
            ->scalarNode('for')->defaultNull()->end()
            ->scalarNode('type')->defaultNull()->end()
            ->end()
            ->end()
            ->end()
            ->end()
            ->end()
            ->end()
            ->end();


        $processor = new Processor();
        $modelContent = $processor->process($treeBuilder->buildTree(), $content);

        /** @var ElementInterface[] $elements */
        $elements = [];

        // create model
        $model = new Model($modelContent['name'], $modelContent['desc']);

        // parse internal systems
        foreach ($modelContent['internal-systems'] as $internalSystemId => $internalSystemContent) {
            $internalSystem = new InternalSystem($internalSystemId, $internalSystemContent['name'], $internalSystemContent['desc']);

            foreach ($internalSystemContent['containers'] as $containerId => $containerContent) {
                $container = new Container($containerId, $containerContent['name'], $containerContent['desc'], $containerContent['type']);

                $internalSystem->addContainer($container);
                $elements[$container->getId()] = $container;
            }

            $model->addInternalSystem($internalSystem);
        }

        // parse external systems
        foreach ($modelContent['external-systems'] as $externalSystemId => $externalSystemContent) {
            $externalSystem = new ExternalSystem($externalSystemId, $externalSystemContent['name'], $externalSystemContent['desc']);

            $model->addExternalSystem($externalSystem);
            $elements[$externalSystem->getId()] = $externalSystem;
        }

        // parse internal users
        foreach ($modelContent['internal-users'] as $internalUserId => $internalUserContent) {
            $internalUser = new InternalUser($internalUserId, $internalUserContent['name'], $internalUserContent['desc']);

            $model->addInternalUser($internalUser);
            $elements[$internalUser->getId()] = $internalUser;
        }
        // parse external users
        foreach ($modelContent['external-users'] as $externalUserId => $externalUserContent) {
            $externalUser = new ExternalUser($externalUserId, $externalUserContent['name'], $externalUserContent['desc']);

            $model->addExternalUser($externalUser);
            $elements[$externalUser->getId()] = $externalUser;
        }

        // parse usages in internal systems
        foreach ($modelContent['internal-systems'] as $internalSystemId => $internalSystemContent) {
            foreach ($internalSystemContent['containers'] as $containerId => $containerContent) {
                foreach ($containerContent['uses'] as $targetId => $usageContent) {
                    $usage = new Usage($elements[$targetId], $usageContent['for'], $usageContent['type']);
                    $elements[$containerId]->uses($usage);
                }
            }
        }
        // parse usages in external systems
        foreach ($modelContent['external-systems'] as $externalSystemId => $externalSystemContent) {
            foreach ($externalSystemContent['uses'] as $targetId => $usageContent) {
                $usage = new Usage($elements[$targetId], $usageContent['for'], $usageContent['type']);
                $elements[$externalSystemId]->uses($usage);
            }
        }

        // parse usages in internal users
        foreach ($modelContent['internal-users'] as $internalUserId => $internalUserContent) {
            foreach ($internalUserContent['uses'] as $targetId => $usageContent) {
                $usage = new Usage($elements[$targetId], $usageContent['for'], $usageContent['type']);
                $elements[$internalUserId]->uses($usage);
            }
        }

        // parse usages in external users
        foreach ($modelContent['external-users'] as $externalUserId => $externalUserContent) {
            foreach ($externalUserContent['uses'] as $targetId => $usageContent) {
                $usage = new Usage($elements[$targetId], $usageContent['for'], $usageContent['type']);
                $elements[$externalUserId]->uses($usage);
            }
        }

        return $model;
    }

}