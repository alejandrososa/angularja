<?php

namespace Map;

use \JaAclPerfilesRecursos;
use \JaAclPerfilesRecursosQuery;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\InstancePoolTrait;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\DataFetcher\DataFetcherInterface;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\RelationMap;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Map\TableMapTrait;


/**
 * This class defines the structure of the 'ja_acl_perfiles_recursos' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class JaAclPerfilesRecursosTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.JaAclPerfilesRecursosTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'ja_acl_perfiles_recursos';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\JaAclPerfilesRecursos';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'JaAclPerfilesRecursos';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 6;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 6;

    /**
     * the column name for the consultar field
     */
    const COL_CONSULTAR = 'ja_acl_perfiles_recursos.consultar';

    /**
     * the column name for the agregar field
     */
    const COL_AGREGAR = 'ja_acl_perfiles_recursos.agregar';

    /**
     * the column name for the editar field
     */
    const COL_EDITAR = 'ja_acl_perfiles_recursos.editar';

    /**
     * the column name for the eliminar field
     */
    const COL_ELIMINAR = 'ja_acl_perfiles_recursos.eliminar';

    /**
     * the column name for the recurso_id field
     */
    const COL_RECURSO_ID = 'ja_acl_perfiles_recursos.recurso_id';

    /**
     * the column name for the perfil_id field
     */
    const COL_PERFIL_ID = 'ja_acl_perfiles_recursos.perfil_id';

    /**
     * The default string format for model objects of the related table
     */
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        self::TYPE_PHPNAME       => array('Consultar', 'Agregar', 'Editar', 'Eliminar', 'RecursoId', 'PerfilId', ),
        self::TYPE_CAMELNAME     => array('consultar', 'agregar', 'editar', 'eliminar', 'recursoId', 'perfilId', ),
        self::TYPE_COLNAME       => array(JaAclPerfilesRecursosTableMap::COL_CONSULTAR, JaAclPerfilesRecursosTableMap::COL_AGREGAR, JaAclPerfilesRecursosTableMap::COL_EDITAR, JaAclPerfilesRecursosTableMap::COL_ELIMINAR, JaAclPerfilesRecursosTableMap::COL_RECURSO_ID, JaAclPerfilesRecursosTableMap::COL_PERFIL_ID, ),
        self::TYPE_FIELDNAME     => array('consultar', 'agregar', 'editar', 'eliminar', 'recurso_id', 'perfil_id', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Consultar' => 0, 'Agregar' => 1, 'Editar' => 2, 'Eliminar' => 3, 'RecursoId' => 4, 'PerfilId' => 5, ),
        self::TYPE_CAMELNAME     => array('consultar' => 0, 'agregar' => 1, 'editar' => 2, 'eliminar' => 3, 'recursoId' => 4, 'perfilId' => 5, ),
        self::TYPE_COLNAME       => array(JaAclPerfilesRecursosTableMap::COL_CONSULTAR => 0, JaAclPerfilesRecursosTableMap::COL_AGREGAR => 1, JaAclPerfilesRecursosTableMap::COL_EDITAR => 2, JaAclPerfilesRecursosTableMap::COL_ELIMINAR => 3, JaAclPerfilesRecursosTableMap::COL_RECURSO_ID => 4, JaAclPerfilesRecursosTableMap::COL_PERFIL_ID => 5, ),
        self::TYPE_FIELDNAME     => array('consultar' => 0, 'agregar' => 1, 'editar' => 2, 'eliminar' => 3, 'recurso_id' => 4, 'perfil_id' => 5, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, )
    );

    /**
     * Initialize the table attributes and columns
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('ja_acl_perfiles_recursos');
        $this->setPhpName('JaAclPerfilesRecursos');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\JaAclPerfilesRecursos');
        $this->setPackage('');
        $this->setUseIdGenerator(false);
        // columns
        $this->addColumn('consultar', 'Consultar', 'BOOLEAN', false, 1, false);
        $this->addColumn('agregar', 'Agregar', 'BOOLEAN', false, 1, false);
        $this->addColumn('editar', 'Editar', 'BOOLEAN', false, 1, false);
        $this->addColumn('eliminar', 'Eliminar', 'BOOLEAN', false, 1, false);
        $this->addForeignKey('recurso_id', 'RecursoId', 'INTEGER', 'ja_acl_recursos', 'id', true, null, null);
        $this->addForeignKey('perfil_id', 'PerfilId', 'INTEGER', 'ja_acl_perfiles', 'id', true, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('JaAclPerfiles', '\\JaAclPerfiles', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':perfil_id',
    1 => ':id',
  ),
), null, null, null, false);
        $this->addRelation('JaAclRecursos', '\\JaAclRecursos', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':recurso_id',
    1 => ':id',
  ),
), null, null, null, false);
    } // buildRelations()

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return string The primary key hash of the row
     */
    public static function getPrimaryKeyHashFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        return null;
    }

    /**
     * Retrieves the primary key from the DB resultset row
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, an array of the primary key columns will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return mixed The primary key of the row
     */
    public static function getPrimaryKeyFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        return '';
    }
    
    /**
     * The class that the tableMap will make instances of.
     *
     * If $withPrefix is true, the returned path
     * uses a dot-path notation which is translated into a path
     * relative to a location on the PHP include_path.
     * (e.g. path.to.MyClass -> 'path/to/MyClass.php')
     *
     * @param boolean $withPrefix Whether or not to return the path with the class name
     * @return string path.to.ClassName
     */
    public static function getOMClass($withPrefix = true)
    {
        return $withPrefix ? JaAclPerfilesRecursosTableMap::CLASS_DEFAULT : JaAclPerfilesRecursosTableMap::OM_CLASS;
    }

    /**
     * Populates an object of the default type or an object that inherit from the default.
     *
     * @param array  $row       row returned by DataFetcher->fetch().
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                 One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     * @return array           (JaAclPerfilesRecursos object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = JaAclPerfilesRecursosTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = JaAclPerfilesRecursosTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + JaAclPerfilesRecursosTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = JaAclPerfilesRecursosTableMap::OM_CLASS;
            /** @var JaAclPerfilesRecursos $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            JaAclPerfilesRecursosTableMap::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }

    /**
     * The returned array will contain objects of the default type or
     * objects that inherit from the default.
     *
     * @param DataFetcherInterface $dataFetcher
     * @return array
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function populateObjects(DataFetcherInterface $dataFetcher)
    {
        $results = array();
    
        // set the class once to avoid overhead in the loop
        $cls = static::getOMClass(false);
        // populate the object(s)
        while ($row = $dataFetcher->fetch()) {
            $key = JaAclPerfilesRecursosTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = JaAclPerfilesRecursosTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var JaAclPerfilesRecursos $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                JaAclPerfilesRecursosTableMap::addInstanceToPool($obj, $key);
            } // if key exists
        }

        return $results;
    }
    /**
     * Add all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be added to the select list and only loaded
     * on demand.
     *
     * @param Criteria $criteria object containing the columns to add.
     * @param string   $alias    optional table alias
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function addSelectColumns(Criteria $criteria, $alias = null)
    {
        if (null === $alias) {
            $criteria->addSelectColumn(JaAclPerfilesRecursosTableMap::COL_CONSULTAR);
            $criteria->addSelectColumn(JaAclPerfilesRecursosTableMap::COL_AGREGAR);
            $criteria->addSelectColumn(JaAclPerfilesRecursosTableMap::COL_EDITAR);
            $criteria->addSelectColumn(JaAclPerfilesRecursosTableMap::COL_ELIMINAR);
            $criteria->addSelectColumn(JaAclPerfilesRecursosTableMap::COL_RECURSO_ID);
            $criteria->addSelectColumn(JaAclPerfilesRecursosTableMap::COL_PERFIL_ID);
        } else {
            $criteria->addSelectColumn($alias . '.consultar');
            $criteria->addSelectColumn($alias . '.agregar');
            $criteria->addSelectColumn($alias . '.editar');
            $criteria->addSelectColumn($alias . '.eliminar');
            $criteria->addSelectColumn($alias . '.recurso_id');
            $criteria->addSelectColumn($alias . '.perfil_id');
        }
    }

    /**
     * Returns the TableMap related to this object.
     * This method is not needed for general use but a specific application could have a need.
     * @return TableMap
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function getTableMap()
    {
        return Propel::getServiceContainer()->getDatabaseMap(JaAclPerfilesRecursosTableMap::DATABASE_NAME)->getTable(JaAclPerfilesRecursosTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(JaAclPerfilesRecursosTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(JaAclPerfilesRecursosTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new JaAclPerfilesRecursosTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a JaAclPerfilesRecursos or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or JaAclPerfilesRecursos object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param  ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
     public static function doDelete($values, ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(JaAclPerfilesRecursosTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \JaAclPerfilesRecursos) { // it's a model object
            // create criteria based on pk value
            $criteria = $values->buildCriteria();
        } else { // it's a primary key, or an array of pks
            throw new LogicException('The JaAclPerfilesRecursos object has no primary key');
        }

        $query = JaAclPerfilesRecursosQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            JaAclPerfilesRecursosTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                JaAclPerfilesRecursosTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the ja_acl_perfiles_recursos table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return JaAclPerfilesRecursosQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a JaAclPerfilesRecursos or Criteria object.
     *
     * @param mixed               $criteria Criteria or JaAclPerfilesRecursos object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(JaAclPerfilesRecursosTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from JaAclPerfilesRecursos object
        }


        // Set the correct dbName
        $query = JaAclPerfilesRecursosQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // JaAclPerfilesRecursosTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
JaAclPerfilesRecursosTableMap::buildTableMap();
