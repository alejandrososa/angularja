<?php

namespace Map;

use \JaUsuarios;
use \JaUsuariosQuery;
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
 * This class defines the structure of the 'ja_usuarios' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class JaUsuariosTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.JaUsuariosTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'ja_usuarios';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\JaUsuarios';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'JaUsuarios';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 14;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 14;

    /**
     * the column name for the id field
     */
    const COL_ID = 'ja_usuarios.id';

    /**
     * the column name for the usuario field
     */
    const COL_USUARIO = 'ja_usuarios.usuario';

    /**
     * the column name for the imagen field
     */
    const COL_IMAGEN = 'ja_usuarios.imagen';

    /**
     * the column name for the nombre field
     */
    const COL_NOMBRE = 'ja_usuarios.nombre';

    /**
     * the column name for the apellidos field
     */
    const COL_APELLIDOS = 'ja_usuarios.apellidos';

    /**
     * the column name for the biografia field
     */
    const COL_BIOGRAFIA = 'ja_usuarios.biografia';

    /**
     * the column name for the correo field
     */
    const COL_CORREO = 'ja_usuarios.correo';

    /**
     * the column name for the telefono field
     */
    const COL_TELEFONO = 'ja_usuarios.telefono';

    /**
     * the column name for the redessociales field
     */
    const COL_REDESSOCIALES = 'ja_usuarios.redessociales';

    /**
     * the column name for the clave field
     */
    const COL_CLAVE = 'ja_usuarios.clave';

    /**
     * the column name for the direccion field
     */
    const COL_DIRECCION = 'ja_usuarios.direccion';

    /**
     * the column name for the ciudad field
     */
    const COL_CIUDAD = 'ja_usuarios.ciudad';

    /**
     * the column name for the pais field
     */
    const COL_PAIS = 'ja_usuarios.pais';

    /**
     * the column name for the fechacreado field
     */
    const COL_FECHACREADO = 'ja_usuarios.fechacreado';

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
        self::TYPE_PHPNAME       => array('Id', 'Usuario', 'Imagen', 'Nombre', 'Apellidos', 'Biografia', 'Correo', 'Telefono', 'Redessociales', 'Clave', 'Direccion', 'Ciudad', 'Pais', 'Fechacreado', ),
        self::TYPE_CAMELNAME     => array('id', 'usuario', 'imagen', 'nombre', 'apellidos', 'biografia', 'correo', 'telefono', 'redessociales', 'clave', 'direccion', 'ciudad', 'pais', 'fechacreado', ),
        self::TYPE_COLNAME       => array(JaUsuariosTableMap::COL_ID, JaUsuariosTableMap::COL_USUARIO, JaUsuariosTableMap::COL_IMAGEN, JaUsuariosTableMap::COL_NOMBRE, JaUsuariosTableMap::COL_APELLIDOS, JaUsuariosTableMap::COL_BIOGRAFIA, JaUsuariosTableMap::COL_CORREO, JaUsuariosTableMap::COL_TELEFONO, JaUsuariosTableMap::COL_REDESSOCIALES, JaUsuariosTableMap::COL_CLAVE, JaUsuariosTableMap::COL_DIRECCION, JaUsuariosTableMap::COL_CIUDAD, JaUsuariosTableMap::COL_PAIS, JaUsuariosTableMap::COL_FECHACREADO, ),
        self::TYPE_FIELDNAME     => array('id', 'usuario', 'imagen', 'nombre', 'apellidos', 'biografia', 'correo', 'telefono', 'redessociales', 'clave', 'direccion', 'ciudad', 'pais', 'fechacreado', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'Usuario' => 1, 'Imagen' => 2, 'Nombre' => 3, 'Apellidos' => 4, 'Biografia' => 5, 'Correo' => 6, 'Telefono' => 7, 'Redessociales' => 8, 'Clave' => 9, 'Direccion' => 10, 'Ciudad' => 11, 'Pais' => 12, 'Fechacreado' => 13, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'usuario' => 1, 'imagen' => 2, 'nombre' => 3, 'apellidos' => 4, 'biografia' => 5, 'correo' => 6, 'telefono' => 7, 'redessociales' => 8, 'clave' => 9, 'direccion' => 10, 'ciudad' => 11, 'pais' => 12, 'fechacreado' => 13, ),
        self::TYPE_COLNAME       => array(JaUsuariosTableMap::COL_ID => 0, JaUsuariosTableMap::COL_USUARIO => 1, JaUsuariosTableMap::COL_IMAGEN => 2, JaUsuariosTableMap::COL_NOMBRE => 3, JaUsuariosTableMap::COL_APELLIDOS => 4, JaUsuariosTableMap::COL_BIOGRAFIA => 5, JaUsuariosTableMap::COL_CORREO => 6, JaUsuariosTableMap::COL_TELEFONO => 7, JaUsuariosTableMap::COL_REDESSOCIALES => 8, JaUsuariosTableMap::COL_CLAVE => 9, JaUsuariosTableMap::COL_DIRECCION => 10, JaUsuariosTableMap::COL_CIUDAD => 11, JaUsuariosTableMap::COL_PAIS => 12, JaUsuariosTableMap::COL_FECHACREADO => 13, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'usuario' => 1, 'imagen' => 2, 'nombre' => 3, 'apellidos' => 4, 'biografia' => 5, 'correo' => 6, 'telefono' => 7, 'redessociales' => 8, 'clave' => 9, 'direccion' => 10, 'ciudad' => 11, 'pais' => 12, 'fechacreado' => 13, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, )
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
        $this->setName('ja_usuarios');
        $this->setPhpName('JaUsuarios');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\JaUsuarios');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('usuario', 'Usuario', 'VARCHAR', true, 45, null);
        $this->addColumn('imagen', 'Imagen', 'VARCHAR', false, 100, null);
        $this->addColumn('nombre', 'Nombre', 'VARCHAR', true, 50, null);
        $this->addColumn('apellidos', 'Apellidos', 'VARCHAR', true, 45, null);
        $this->addColumn('biografia', 'Biografia', 'LONGVARCHAR', false, null, null);
        $this->addColumn('correo', 'Correo', 'VARCHAR', true, 50, null);
        $this->addColumn('telefono', 'Telefono', 'VARCHAR', false, 100, null);
        $this->addColumn('redessociales', 'Redessociales', 'LONGVARCHAR', false, null, null);
        $this->addColumn('clave', 'Clave', 'VARCHAR', true, 200, null);
        $this->addColumn('direccion', 'Direccion', 'VARCHAR', false, 50, null);
        $this->addColumn('ciudad', 'Ciudad', 'VARCHAR', false, 50, null);
        $this->addColumn('pais', 'Pais', 'VARCHAR', false, 45, null);
        $this->addColumn('fechacreado', 'Fechacreado', 'TIMESTAMP', true, null, 'CURRENT_TIMESTAMP');
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('JaAclUsuariosPerfiles', '\\JaAclUsuariosPerfiles', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':usuario_id',
    1 => ':id',
  ),
), null, null, 'JaAclUsuariosPerfiless', false);
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
        return $withPrefix ? JaUsuariosTableMap::CLASS_DEFAULT : JaUsuariosTableMap::OM_CLASS;
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
     * @return array           (JaUsuarios object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = JaUsuariosTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = JaUsuariosTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + JaUsuariosTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = JaUsuariosTableMap::OM_CLASS;
            /** @var JaUsuarios $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            JaUsuariosTableMap::addInstanceToPool($obj, $key);
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
            $key = JaUsuariosTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = JaUsuariosTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var JaUsuarios $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                JaUsuariosTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(JaUsuariosTableMap::COL_ID);
            $criteria->addSelectColumn(JaUsuariosTableMap::COL_USUARIO);
            $criteria->addSelectColumn(JaUsuariosTableMap::COL_IMAGEN);
            $criteria->addSelectColumn(JaUsuariosTableMap::COL_NOMBRE);
            $criteria->addSelectColumn(JaUsuariosTableMap::COL_APELLIDOS);
            $criteria->addSelectColumn(JaUsuariosTableMap::COL_BIOGRAFIA);
            $criteria->addSelectColumn(JaUsuariosTableMap::COL_CORREO);
            $criteria->addSelectColumn(JaUsuariosTableMap::COL_TELEFONO);
            $criteria->addSelectColumn(JaUsuariosTableMap::COL_REDESSOCIALES);
            $criteria->addSelectColumn(JaUsuariosTableMap::COL_CLAVE);
            $criteria->addSelectColumn(JaUsuariosTableMap::COL_DIRECCION);
            $criteria->addSelectColumn(JaUsuariosTableMap::COL_CIUDAD);
            $criteria->addSelectColumn(JaUsuariosTableMap::COL_PAIS);
            $criteria->addSelectColumn(JaUsuariosTableMap::COL_FECHACREADO);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.usuario');
            $criteria->addSelectColumn($alias . '.imagen');
            $criteria->addSelectColumn($alias . '.nombre');
            $criteria->addSelectColumn($alias . '.apellidos');
            $criteria->addSelectColumn($alias . '.biografia');
            $criteria->addSelectColumn($alias . '.correo');
            $criteria->addSelectColumn($alias . '.telefono');
            $criteria->addSelectColumn($alias . '.redessociales');
            $criteria->addSelectColumn($alias . '.clave');
            $criteria->addSelectColumn($alias . '.direccion');
            $criteria->addSelectColumn($alias . '.ciudad');
            $criteria->addSelectColumn($alias . '.pais');
            $criteria->addSelectColumn($alias . '.fechacreado');
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
        return Propel::getServiceContainer()->getDatabaseMap(JaUsuariosTableMap::DATABASE_NAME)->getTable(JaUsuariosTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(JaUsuariosTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(JaUsuariosTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new JaUsuariosTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a JaUsuarios or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or JaUsuarios object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(JaUsuariosTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \JaUsuarios) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(JaUsuariosTableMap::DATABASE_NAME);
            $criteria->add(JaUsuariosTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = JaUsuariosQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            JaUsuariosTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                JaUsuariosTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the ja_usuarios table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return JaUsuariosQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a JaUsuarios or Criteria object.
     *
     * @param mixed               $criteria Criteria or JaUsuarios object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(JaUsuariosTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from JaUsuarios object
        }

        if ($criteria->containsKey(JaUsuariosTableMap::COL_ID) && $criteria->keyContainsValue(JaUsuariosTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.JaUsuariosTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = JaUsuariosQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // JaUsuariosTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
JaUsuariosTableMap::buildTableMap();
