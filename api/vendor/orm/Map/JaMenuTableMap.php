<?php

namespace Map;

use \JaMenu;
use \JaMenuQuery;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\InstancePoolTrait;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\DataFetcher\DataFetcherInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\RelationMap;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Map\TableMapTrait;


/**
 * This class defines the structure of the 'ja_menu' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class JaMenuTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.JaMenuTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'ja_menu';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\JaMenu';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'JaMenu';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 8;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 8;

    /**
     * the column name for the id field
     */
    const COL_ID = 'ja_menu.id';

    /**
     * the column name for the nombre field
     */
    const COL_NOMBRE = 'ja_menu.nombre';

    /**
     * the column name for the clase field
     */
    const COL_CLASE = 'ja_menu.clase';

    /**
     * the column name for the enlace field
     */
    const COL_ENLACE = 'ja_menu.enlace';

    /**
     * the column name for the tipo_enlace field
     */
    const COL_TIPO_ENLACE = 'ja_menu.tipo_enlace';

    /**
     * the column name for the target field
     */
    const COL_TARGET = 'ja_menu.target';

    /**
     * the column name for the padre field
     */
    const COL_PADRE = 'ja_menu.padre';

    /**
     * the column name for the categoria field
     */
    const COL_CATEGORIA = 'ja_menu.categoria';

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
        self::TYPE_PHPNAME       => array('Id', 'Nombre', 'Clase', 'Enlace', 'TipoEnlace', 'Target', 'Padre', 'Categoria', ),
        self::TYPE_CAMELNAME     => array('id', 'nombre', 'clase', 'enlace', 'tipoEnlace', 'target', 'padre', 'categoria', ),
        self::TYPE_COLNAME       => array(JaMenuTableMap::COL_ID, JaMenuTableMap::COL_NOMBRE, JaMenuTableMap::COL_CLASE, JaMenuTableMap::COL_ENLACE, JaMenuTableMap::COL_TIPO_ENLACE, JaMenuTableMap::COL_TARGET, JaMenuTableMap::COL_PADRE, JaMenuTableMap::COL_CATEGORIA, ),
        self::TYPE_FIELDNAME     => array('id', 'nombre', 'clase', 'enlace', 'tipo_enlace', 'target', 'padre', 'categoria', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'Nombre' => 1, 'Clase' => 2, 'Enlace' => 3, 'TipoEnlace' => 4, 'Target' => 5, 'Padre' => 6, 'Categoria' => 7, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'nombre' => 1, 'clase' => 2, 'enlace' => 3, 'tipoEnlace' => 4, 'target' => 5, 'padre' => 6, 'categoria' => 7, ),
        self::TYPE_COLNAME       => array(JaMenuTableMap::COL_ID => 0, JaMenuTableMap::COL_NOMBRE => 1, JaMenuTableMap::COL_CLASE => 2, JaMenuTableMap::COL_ENLACE => 3, JaMenuTableMap::COL_TIPO_ENLACE => 4, JaMenuTableMap::COL_TARGET => 5, JaMenuTableMap::COL_PADRE => 6, JaMenuTableMap::COL_CATEGORIA => 7, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'nombre' => 1, 'clase' => 2, 'enlace' => 3, 'tipo_enlace' => 4, 'target' => 5, 'padre' => 6, 'categoria' => 7, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, )
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
        $this->setName('ja_menu');
        $this->setPhpName('JaMenu');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\JaMenu');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('nombre', 'Nombre', 'VARCHAR', true, 255, '');
        $this->addColumn('clase', 'Clase', 'VARCHAR', true, 255, '');
        $this->addColumn('enlace', 'Enlace', 'VARCHAR', true, 255, '#');
        $this->addColumn('tipo_enlace', 'TipoEnlace', 'CHAR', false, null, 'interno');
        $this->addColumn('target', 'Target', 'CHAR', true, null, '_self');
        $this->addColumn('padre', 'Padre', 'INTEGER', true, null, 0);
        $this->addColumn('categoria', 'Categoria', 'CHAR', false, null, '6');
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
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
        // If the PK cannot be derived from the row, return NULL.
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
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
        return (int) $row[
            $indexType == TableMap::TYPE_NUM
                ? 0 + $offset
                : self::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)
        ];
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
        return $withPrefix ? JaMenuTableMap::CLASS_DEFAULT : JaMenuTableMap::OM_CLASS;
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
     * @return array           (JaMenu object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = JaMenuTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = JaMenuTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + JaMenuTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = JaMenuTableMap::OM_CLASS;
            /** @var JaMenu $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            JaMenuTableMap::addInstanceToPool($obj, $key);
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
            $key = JaMenuTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = JaMenuTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var JaMenu $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                JaMenuTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(JaMenuTableMap::COL_ID);
            $criteria->addSelectColumn(JaMenuTableMap::COL_NOMBRE);
            $criteria->addSelectColumn(JaMenuTableMap::COL_CLASE);
            $criteria->addSelectColumn(JaMenuTableMap::COL_ENLACE);
            $criteria->addSelectColumn(JaMenuTableMap::COL_TIPO_ENLACE);
            $criteria->addSelectColumn(JaMenuTableMap::COL_TARGET);
            $criteria->addSelectColumn(JaMenuTableMap::COL_PADRE);
            $criteria->addSelectColumn(JaMenuTableMap::COL_CATEGORIA);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.nombre');
            $criteria->addSelectColumn($alias . '.clase');
            $criteria->addSelectColumn($alias . '.enlace');
            $criteria->addSelectColumn($alias . '.tipo_enlace');
            $criteria->addSelectColumn($alias . '.target');
            $criteria->addSelectColumn($alias . '.padre');
            $criteria->addSelectColumn($alias . '.categoria');
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
        return Propel::getServiceContainer()->getDatabaseMap(JaMenuTableMap::DATABASE_NAME)->getTable(JaMenuTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(JaMenuTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(JaMenuTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new JaMenuTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a JaMenu or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or JaMenu object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(JaMenuTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \JaMenu) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(JaMenuTableMap::DATABASE_NAME);
            $criteria->add(JaMenuTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = JaMenuQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            JaMenuTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                JaMenuTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the ja_menu table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return JaMenuQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a JaMenu or Criteria object.
     *
     * @param mixed               $criteria Criteria or JaMenu object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(JaMenuTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from JaMenu object
        }

        if ($criteria->containsKey(JaMenuTableMap::COL_ID) && $criteria->keyContainsValue(JaMenuTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.JaMenuTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = JaMenuQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // JaMenuTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
JaMenuTableMap::buildTableMap();
