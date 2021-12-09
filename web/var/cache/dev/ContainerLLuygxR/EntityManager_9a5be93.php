<?php

namespace ContainerLLuygxR;
include_once \dirname(__DIR__, 4).'/vendor/doctrine/persistence/lib/Doctrine/Persistence/ObjectManager.php';
include_once \dirname(__DIR__, 4).'/vendor/doctrine/orm/lib/Doctrine/ORM/EntityManagerInterface.php';
include_once \dirname(__DIR__, 4).'/vendor/doctrine/orm/lib/Doctrine/ORM/EntityManager.php';

class EntityManager_9a5be93 extends \Doctrine\ORM\EntityManager implements \ProxyManager\Proxy\VirtualProxyInterface
{
    /**
     * @var \Doctrine\ORM\EntityManager|null wrapped object, if the proxy is initialized
     */
    private $valueHolder257fa = null;

    /**
     * @var \Closure|null initializer responsible for generating the wrapped object
     */
    private $initializerf8689 = null;

    /**
     * @var bool[] map of public properties of the parent class
     */
    private static $publicPropertiesc8344 = [
        
    ];

    public function getConnection()
    {
        $this->initializerf8689 && ($this->initializerf8689->__invoke($valueHolder257fa, $this, 'getConnection', array(), $this->initializerf8689) || 1) && $this->valueHolder257fa = $valueHolder257fa;

        return $this->valueHolder257fa->getConnection();
    }

    public function getMetadataFactory()
    {
        $this->initializerf8689 && ($this->initializerf8689->__invoke($valueHolder257fa, $this, 'getMetadataFactory', array(), $this->initializerf8689) || 1) && $this->valueHolder257fa = $valueHolder257fa;

        return $this->valueHolder257fa->getMetadataFactory();
    }

    public function getExpressionBuilder()
    {
        $this->initializerf8689 && ($this->initializerf8689->__invoke($valueHolder257fa, $this, 'getExpressionBuilder', array(), $this->initializerf8689) || 1) && $this->valueHolder257fa = $valueHolder257fa;

        return $this->valueHolder257fa->getExpressionBuilder();
    }

    public function beginTransaction()
    {
        $this->initializerf8689 && ($this->initializerf8689->__invoke($valueHolder257fa, $this, 'beginTransaction', array(), $this->initializerf8689) || 1) && $this->valueHolder257fa = $valueHolder257fa;

        return $this->valueHolder257fa->beginTransaction();
    }

    public function getCache()
    {
        $this->initializerf8689 && ($this->initializerf8689->__invoke($valueHolder257fa, $this, 'getCache', array(), $this->initializerf8689) || 1) && $this->valueHolder257fa = $valueHolder257fa;

        return $this->valueHolder257fa->getCache();
    }

    public function transactional($func)
    {
        $this->initializerf8689 && ($this->initializerf8689->__invoke($valueHolder257fa, $this, 'transactional', array('func' => $func), $this->initializerf8689) || 1) && $this->valueHolder257fa = $valueHolder257fa;

        return $this->valueHolder257fa->transactional($func);
    }

    public function wrapInTransaction(callable $func)
    {
        $this->initializerf8689 && ($this->initializerf8689->__invoke($valueHolder257fa, $this, 'wrapInTransaction', array('func' => $func), $this->initializerf8689) || 1) && $this->valueHolder257fa = $valueHolder257fa;

        return $this->valueHolder257fa->wrapInTransaction($func);
    }

    public function commit()
    {
        $this->initializerf8689 && ($this->initializerf8689->__invoke($valueHolder257fa, $this, 'commit', array(), $this->initializerf8689) || 1) && $this->valueHolder257fa = $valueHolder257fa;

        return $this->valueHolder257fa->commit();
    }

    public function rollback()
    {
        $this->initializerf8689 && ($this->initializerf8689->__invoke($valueHolder257fa, $this, 'rollback', array(), $this->initializerf8689) || 1) && $this->valueHolder257fa = $valueHolder257fa;

        return $this->valueHolder257fa->rollback();
    }

    public function getClassMetadata($className)
    {
        $this->initializerf8689 && ($this->initializerf8689->__invoke($valueHolder257fa, $this, 'getClassMetadata', array('className' => $className), $this->initializerf8689) || 1) && $this->valueHolder257fa = $valueHolder257fa;

        return $this->valueHolder257fa->getClassMetadata($className);
    }

    public function createQuery($dql = '')
    {
        $this->initializerf8689 && ($this->initializerf8689->__invoke($valueHolder257fa, $this, 'createQuery', array('dql' => $dql), $this->initializerf8689) || 1) && $this->valueHolder257fa = $valueHolder257fa;

        return $this->valueHolder257fa->createQuery($dql);
    }

    public function createNamedQuery($name)
    {
        $this->initializerf8689 && ($this->initializerf8689->__invoke($valueHolder257fa, $this, 'createNamedQuery', array('name' => $name), $this->initializerf8689) || 1) && $this->valueHolder257fa = $valueHolder257fa;

        return $this->valueHolder257fa->createNamedQuery($name);
    }

    public function createNativeQuery($sql, \Doctrine\ORM\Query\ResultSetMapping $rsm)
    {
        $this->initializerf8689 && ($this->initializerf8689->__invoke($valueHolder257fa, $this, 'createNativeQuery', array('sql' => $sql, 'rsm' => $rsm), $this->initializerf8689) || 1) && $this->valueHolder257fa = $valueHolder257fa;

        return $this->valueHolder257fa->createNativeQuery($sql, $rsm);
    }

    public function createNamedNativeQuery($name)
    {
        $this->initializerf8689 && ($this->initializerf8689->__invoke($valueHolder257fa, $this, 'createNamedNativeQuery', array('name' => $name), $this->initializerf8689) || 1) && $this->valueHolder257fa = $valueHolder257fa;

        return $this->valueHolder257fa->createNamedNativeQuery($name);
    }

    public function createQueryBuilder()
    {
        $this->initializerf8689 && ($this->initializerf8689->__invoke($valueHolder257fa, $this, 'createQueryBuilder', array(), $this->initializerf8689) || 1) && $this->valueHolder257fa = $valueHolder257fa;

        return $this->valueHolder257fa->createQueryBuilder();
    }

    public function flush($entity = null)
    {
        $this->initializerf8689 && ($this->initializerf8689->__invoke($valueHolder257fa, $this, 'flush', array('entity' => $entity), $this->initializerf8689) || 1) && $this->valueHolder257fa = $valueHolder257fa;

        return $this->valueHolder257fa->flush($entity);
    }

    public function find($className, $id, $lockMode = null, $lockVersion = null)
    {
        $this->initializerf8689 && ($this->initializerf8689->__invoke($valueHolder257fa, $this, 'find', array('className' => $className, 'id' => $id, 'lockMode' => $lockMode, 'lockVersion' => $lockVersion), $this->initializerf8689) || 1) && $this->valueHolder257fa = $valueHolder257fa;

        return $this->valueHolder257fa->find($className, $id, $lockMode, $lockVersion);
    }

    public function getReference($entityName, $id)
    {
        $this->initializerf8689 && ($this->initializerf8689->__invoke($valueHolder257fa, $this, 'getReference', array('entityName' => $entityName, 'id' => $id), $this->initializerf8689) || 1) && $this->valueHolder257fa = $valueHolder257fa;

        return $this->valueHolder257fa->getReference($entityName, $id);
    }

    public function getPartialReference($entityName, $identifier)
    {
        $this->initializerf8689 && ($this->initializerf8689->__invoke($valueHolder257fa, $this, 'getPartialReference', array('entityName' => $entityName, 'identifier' => $identifier), $this->initializerf8689) || 1) && $this->valueHolder257fa = $valueHolder257fa;

        return $this->valueHolder257fa->getPartialReference($entityName, $identifier);
    }

    public function clear($entityName = null)
    {
        $this->initializerf8689 && ($this->initializerf8689->__invoke($valueHolder257fa, $this, 'clear', array('entityName' => $entityName), $this->initializerf8689) || 1) && $this->valueHolder257fa = $valueHolder257fa;

        return $this->valueHolder257fa->clear($entityName);
    }

    public function close()
    {
        $this->initializerf8689 && ($this->initializerf8689->__invoke($valueHolder257fa, $this, 'close', array(), $this->initializerf8689) || 1) && $this->valueHolder257fa = $valueHolder257fa;

        return $this->valueHolder257fa->close();
    }

    public function persist($entity)
    {
        $this->initializerf8689 && ($this->initializerf8689->__invoke($valueHolder257fa, $this, 'persist', array('entity' => $entity), $this->initializerf8689) || 1) && $this->valueHolder257fa = $valueHolder257fa;

        return $this->valueHolder257fa->persist($entity);
    }

    public function remove($entity)
    {
        $this->initializerf8689 && ($this->initializerf8689->__invoke($valueHolder257fa, $this, 'remove', array('entity' => $entity), $this->initializerf8689) || 1) && $this->valueHolder257fa = $valueHolder257fa;

        return $this->valueHolder257fa->remove($entity);
    }

    public function refresh($entity)
    {
        $this->initializerf8689 && ($this->initializerf8689->__invoke($valueHolder257fa, $this, 'refresh', array('entity' => $entity), $this->initializerf8689) || 1) && $this->valueHolder257fa = $valueHolder257fa;

        return $this->valueHolder257fa->refresh($entity);
    }

    public function detach($entity)
    {
        $this->initializerf8689 && ($this->initializerf8689->__invoke($valueHolder257fa, $this, 'detach', array('entity' => $entity), $this->initializerf8689) || 1) && $this->valueHolder257fa = $valueHolder257fa;

        return $this->valueHolder257fa->detach($entity);
    }

    public function merge($entity)
    {
        $this->initializerf8689 && ($this->initializerf8689->__invoke($valueHolder257fa, $this, 'merge', array('entity' => $entity), $this->initializerf8689) || 1) && $this->valueHolder257fa = $valueHolder257fa;

        return $this->valueHolder257fa->merge($entity);
    }

    public function copy($entity, $deep = false)
    {
        $this->initializerf8689 && ($this->initializerf8689->__invoke($valueHolder257fa, $this, 'copy', array('entity' => $entity, 'deep' => $deep), $this->initializerf8689) || 1) && $this->valueHolder257fa = $valueHolder257fa;

        return $this->valueHolder257fa->copy($entity, $deep);
    }

    public function lock($entity, $lockMode, $lockVersion = null)
    {
        $this->initializerf8689 && ($this->initializerf8689->__invoke($valueHolder257fa, $this, 'lock', array('entity' => $entity, 'lockMode' => $lockMode, 'lockVersion' => $lockVersion), $this->initializerf8689) || 1) && $this->valueHolder257fa = $valueHolder257fa;

        return $this->valueHolder257fa->lock($entity, $lockMode, $lockVersion);
    }

    public function getRepository($entityName)
    {
        $this->initializerf8689 && ($this->initializerf8689->__invoke($valueHolder257fa, $this, 'getRepository', array('entityName' => $entityName), $this->initializerf8689) || 1) && $this->valueHolder257fa = $valueHolder257fa;

        return $this->valueHolder257fa->getRepository($entityName);
    }

    public function contains($entity)
    {
        $this->initializerf8689 && ($this->initializerf8689->__invoke($valueHolder257fa, $this, 'contains', array('entity' => $entity), $this->initializerf8689) || 1) && $this->valueHolder257fa = $valueHolder257fa;

        return $this->valueHolder257fa->contains($entity);
    }

    public function getEventManager()
    {
        $this->initializerf8689 && ($this->initializerf8689->__invoke($valueHolder257fa, $this, 'getEventManager', array(), $this->initializerf8689) || 1) && $this->valueHolder257fa = $valueHolder257fa;

        return $this->valueHolder257fa->getEventManager();
    }

    public function getConfiguration()
    {
        $this->initializerf8689 && ($this->initializerf8689->__invoke($valueHolder257fa, $this, 'getConfiguration', array(), $this->initializerf8689) || 1) && $this->valueHolder257fa = $valueHolder257fa;

        return $this->valueHolder257fa->getConfiguration();
    }

    public function isOpen()
    {
        $this->initializerf8689 && ($this->initializerf8689->__invoke($valueHolder257fa, $this, 'isOpen', array(), $this->initializerf8689) || 1) && $this->valueHolder257fa = $valueHolder257fa;

        return $this->valueHolder257fa->isOpen();
    }

    public function getUnitOfWork()
    {
        $this->initializerf8689 && ($this->initializerf8689->__invoke($valueHolder257fa, $this, 'getUnitOfWork', array(), $this->initializerf8689) || 1) && $this->valueHolder257fa = $valueHolder257fa;

        return $this->valueHolder257fa->getUnitOfWork();
    }

    public function getHydrator($hydrationMode)
    {
        $this->initializerf8689 && ($this->initializerf8689->__invoke($valueHolder257fa, $this, 'getHydrator', array('hydrationMode' => $hydrationMode), $this->initializerf8689) || 1) && $this->valueHolder257fa = $valueHolder257fa;

        return $this->valueHolder257fa->getHydrator($hydrationMode);
    }

    public function newHydrator($hydrationMode)
    {
        $this->initializerf8689 && ($this->initializerf8689->__invoke($valueHolder257fa, $this, 'newHydrator', array('hydrationMode' => $hydrationMode), $this->initializerf8689) || 1) && $this->valueHolder257fa = $valueHolder257fa;

        return $this->valueHolder257fa->newHydrator($hydrationMode);
    }

    public function getProxyFactory()
    {
        $this->initializerf8689 && ($this->initializerf8689->__invoke($valueHolder257fa, $this, 'getProxyFactory', array(), $this->initializerf8689) || 1) && $this->valueHolder257fa = $valueHolder257fa;

        return $this->valueHolder257fa->getProxyFactory();
    }

    public function initializeObject($obj)
    {
        $this->initializerf8689 && ($this->initializerf8689->__invoke($valueHolder257fa, $this, 'initializeObject', array('obj' => $obj), $this->initializerf8689) || 1) && $this->valueHolder257fa = $valueHolder257fa;

        return $this->valueHolder257fa->initializeObject($obj);
    }

    public function getFilters()
    {
        $this->initializerf8689 && ($this->initializerf8689->__invoke($valueHolder257fa, $this, 'getFilters', array(), $this->initializerf8689) || 1) && $this->valueHolder257fa = $valueHolder257fa;

        return $this->valueHolder257fa->getFilters();
    }

    public function isFiltersStateClean()
    {
        $this->initializerf8689 && ($this->initializerf8689->__invoke($valueHolder257fa, $this, 'isFiltersStateClean', array(), $this->initializerf8689) || 1) && $this->valueHolder257fa = $valueHolder257fa;

        return $this->valueHolder257fa->isFiltersStateClean();
    }

    public function hasFilters()
    {
        $this->initializerf8689 && ($this->initializerf8689->__invoke($valueHolder257fa, $this, 'hasFilters', array(), $this->initializerf8689) || 1) && $this->valueHolder257fa = $valueHolder257fa;

        return $this->valueHolder257fa->hasFilters();
    }

    /**
     * Constructor for lazy initialization
     *
     * @param \Closure|null $initializer
     */
    public static function staticProxyConstructor($initializer)
    {
        static $reflection;

        $reflection = $reflection ?? new \ReflectionClass(__CLASS__);
        $instance   = $reflection->newInstanceWithoutConstructor();

        \Closure::bind(function (\Doctrine\ORM\EntityManager $instance) {
            unset($instance->config, $instance->conn, $instance->metadataFactory, $instance->unitOfWork, $instance->eventManager, $instance->proxyFactory, $instance->repositoryFactory, $instance->expressionBuilder, $instance->closed, $instance->filterCollection, $instance->cache);
        }, $instance, 'Doctrine\\ORM\\EntityManager')->__invoke($instance);

        $instance->initializerf8689 = $initializer;

        return $instance;
    }

    protected function __construct(\Doctrine\DBAL\Connection $conn, \Doctrine\ORM\Configuration $config, \Doctrine\Common\EventManager $eventManager)
    {
        static $reflection;

        if (! $this->valueHolder257fa) {
            $reflection = $reflection ?? new \ReflectionClass('Doctrine\\ORM\\EntityManager');
            $this->valueHolder257fa = $reflection->newInstanceWithoutConstructor();
        \Closure::bind(function (\Doctrine\ORM\EntityManager $instance) {
            unset($instance->config, $instance->conn, $instance->metadataFactory, $instance->unitOfWork, $instance->eventManager, $instance->proxyFactory, $instance->repositoryFactory, $instance->expressionBuilder, $instance->closed, $instance->filterCollection, $instance->cache);
        }, $this, 'Doctrine\\ORM\\EntityManager')->__invoke($this);

        }

        $this->valueHolder257fa->__construct($conn, $config, $eventManager);
    }

    public function & __get($name)
    {
        $this->initializerf8689 && ($this->initializerf8689->__invoke($valueHolder257fa, $this, '__get', ['name' => $name], $this->initializerf8689) || 1) && $this->valueHolder257fa = $valueHolder257fa;

        if (isset(self::$publicPropertiesc8344[$name])) {
            return $this->valueHolder257fa->$name;
        }

        $realInstanceReflection = new \ReflectionClass('Doctrine\\ORM\\EntityManager');

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHolder257fa;

            $backtrace = debug_backtrace(false, 1);
            trigger_error(
                sprintf(
                    'Undefined property: %s::$%s in %s on line %s',
                    $realInstanceReflection->getName(),
                    $name,
                    $backtrace[0]['file'],
                    $backtrace[0]['line']
                ),
                \E_USER_NOTICE
            );
            return $targetObject->$name;
        }

        $targetObject = $this->valueHolder257fa;
        $accessor = function & () use ($targetObject, $name) {
            return $targetObject->$name;
        };
        $backtrace = debug_backtrace(true, 2);
        $scopeObject = isset($backtrace[1]['object']) ? $backtrace[1]['object'] : new \ProxyManager\Stub\EmptyClassStub();
        $accessor = $accessor->bindTo($scopeObject, get_class($scopeObject));
        $returnValue = & $accessor();

        return $returnValue;
    }

    public function __set($name, $value)
    {
        $this->initializerf8689 && ($this->initializerf8689->__invoke($valueHolder257fa, $this, '__set', array('name' => $name, 'value' => $value), $this->initializerf8689) || 1) && $this->valueHolder257fa = $valueHolder257fa;

        $realInstanceReflection = new \ReflectionClass('Doctrine\\ORM\\EntityManager');

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHolder257fa;

            $targetObject->$name = $value;

            return $targetObject->$name;
        }

        $targetObject = $this->valueHolder257fa;
        $accessor = function & () use ($targetObject, $name, $value) {
            $targetObject->$name = $value;

            return $targetObject->$name;
        };
        $backtrace = debug_backtrace(true, 2);
        $scopeObject = isset($backtrace[1]['object']) ? $backtrace[1]['object'] : new \ProxyManager\Stub\EmptyClassStub();
        $accessor = $accessor->bindTo($scopeObject, get_class($scopeObject));
        $returnValue = & $accessor();

        return $returnValue;
    }

    public function __isset($name)
    {
        $this->initializerf8689 && ($this->initializerf8689->__invoke($valueHolder257fa, $this, '__isset', array('name' => $name), $this->initializerf8689) || 1) && $this->valueHolder257fa = $valueHolder257fa;

        $realInstanceReflection = new \ReflectionClass('Doctrine\\ORM\\EntityManager');

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHolder257fa;

            return isset($targetObject->$name);
        }

        $targetObject = $this->valueHolder257fa;
        $accessor = function () use ($targetObject, $name) {
            return isset($targetObject->$name);
        };
        $backtrace = debug_backtrace(true, 2);
        $scopeObject = isset($backtrace[1]['object']) ? $backtrace[1]['object'] : new \ProxyManager\Stub\EmptyClassStub();
        $accessor = $accessor->bindTo($scopeObject, get_class($scopeObject));
        $returnValue = $accessor();

        return $returnValue;
    }

    public function __unset($name)
    {
        $this->initializerf8689 && ($this->initializerf8689->__invoke($valueHolder257fa, $this, '__unset', array('name' => $name), $this->initializerf8689) || 1) && $this->valueHolder257fa = $valueHolder257fa;

        $realInstanceReflection = new \ReflectionClass('Doctrine\\ORM\\EntityManager');

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHolder257fa;

            unset($targetObject->$name);

            return;
        }

        $targetObject = $this->valueHolder257fa;
        $accessor = function () use ($targetObject, $name) {
            unset($targetObject->$name);

            return;
        };
        $backtrace = debug_backtrace(true, 2);
        $scopeObject = isset($backtrace[1]['object']) ? $backtrace[1]['object'] : new \ProxyManager\Stub\EmptyClassStub();
        $accessor = $accessor->bindTo($scopeObject, get_class($scopeObject));
        $accessor();
    }

    public function __clone()
    {
        $this->initializerf8689 && ($this->initializerf8689->__invoke($valueHolder257fa, $this, '__clone', array(), $this->initializerf8689) || 1) && $this->valueHolder257fa = $valueHolder257fa;

        $this->valueHolder257fa = clone $this->valueHolder257fa;
    }

    public function __sleep()
    {
        $this->initializerf8689 && ($this->initializerf8689->__invoke($valueHolder257fa, $this, '__sleep', array(), $this->initializerf8689) || 1) && $this->valueHolder257fa = $valueHolder257fa;

        return array('valueHolder257fa');
    }

    public function __wakeup()
    {
        \Closure::bind(function (\Doctrine\ORM\EntityManager $instance) {
            unset($instance->config, $instance->conn, $instance->metadataFactory, $instance->unitOfWork, $instance->eventManager, $instance->proxyFactory, $instance->repositoryFactory, $instance->expressionBuilder, $instance->closed, $instance->filterCollection, $instance->cache);
        }, $this, 'Doctrine\\ORM\\EntityManager')->__invoke($this);
    }

    public function setProxyInitializer(\Closure $initializer = null) : void
    {
        $this->initializerf8689 = $initializer;
    }

    public function getProxyInitializer() : ?\Closure
    {
        return $this->initializerf8689;
    }

    public function initializeProxy() : bool
    {
        return $this->initializerf8689 && ($this->initializerf8689->__invoke($valueHolder257fa, $this, 'initializeProxy', array(), $this->initializerf8689) || 1) && $this->valueHolder257fa = $valueHolder257fa;
    }

    public function isProxyInitialized() : bool
    {
        return null !== $this->valueHolder257fa;
    }

    public function getWrappedValueHolderValue()
    {
        return $this->valueHolder257fa;
    }
}

if (!\class_exists('EntityManager_9a5be93', false)) {
    \class_alias(__NAMESPACE__.'\\EntityManager_9a5be93', 'EntityManager_9a5be93', false);
}
