<?php

namespace Map;

use \JaPaginas;
use \JaPaginasQuery;
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
 * This class defines the structure of the 'ja_paginas' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class JaPaginasTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.JaPaginasTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'ja_paginas';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\JaPaginas';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'JaPaginas';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 17;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 17;

    /**
     * the column name for the id field
     */
    const COL_ID = 'ja_paginas.id';

    /**
     * the column name for the titulo field
     */
    const COL_TITULO = 'ja_paginas.titulo';

    /**
     * the column name for the contenido field
     */
    const COL_CONTENIDO = 'ja_paginas.contenido';

    /**
     * the column name for the imagen field
     */
    const COL_IMAGEN = 'ja_paginas.imagen';

    /**
     * the column name for the leermas field
     */
    const COL_LEERMAS = 'ja_paginas.leermas';

    /**
     * the column name for the estado field
     */
    const COL_ESTADO = 'ja_paginas.estado';

    /**
     * the column name for the categoria field
     */
    const COL_CATEGORIA = 'ja_paginas.categoria';

    /**
     * the column name for the tipo field
     */
    const COL_TIPO = 'ja_paginas.tipo';

    /**
     * the column name for the autor field
     */
    const COL_AUTOR = 'ja_paginas.autor';

    /**
     * the column name for the padre field
     */
    const COL_PADRE = 'ja_paginas.padre';

    /**
     * the column name for the slug field
     */
    const COL_SLUG = 'ja_paginas.slug';

    /**
     * the column name for the meta_descripcion field
     */
    const COL_META_DESCRIPCION = 'ja_paginas.meta_descripcion';

    /**
     * the column name for the meta_palabras field
     */
    const COL_META_PALABRAS = 'ja_paginas.meta_palabras';

    /**
     * the column name for the meta_titulo field
     */
    const COL_META_TITULO = 'ja_paginas.meta_titulo';

    /**
     * the column name for the fecha_creado field
     */
    const COL_FECHA_CREADO = 'ja_paginas.fecha_creado';

    /**
     * the column name for the fecha_modificado field
     */
    const COL_FECHA_MODIFICADO = 'ja_paginas.fecha_modificado';

    /**
     * the column name for the configuracion field
     */
    const COL_CONFIGURACION = 'ja_paginas.configuracion';

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
        self::TYPE_PHPNAME       => array('Id', 'Titulo', 'Contenido', 'Imagen', 'Leermas', 'Estado', 'Categoria', 'Tipo', 'Autor', 'Padre', 'Slug', 'MetaDescripcion', 'MetaPalabras', 'MetaTitulo', 'FechaCreado', 'FechaModificado', 'Configuracion', ),
        self::TYPE_CAMELNAME     => array('id', 'titulo', 'contenido', 'imagen', 'leermas', 'estado', 'categoria', 'tipo', 'autor', 'padre', 'slug', 'metaDescripcion', 'metaPalabras', 'metaTitulo', 'fechaCreado', 'fechaModificado', 'configuracion', ),
        self::TYPE_COLNAME       => array(JaPaginasTableMap::COL_ID, JaPaginasTableMap::COL_TITULO, JaPaginasTableMap::COL_CONTENIDO, JaPaginasTableMap::COL_IMAGEN, JaPaginasTableMap::COL_LEERMAS, JaPaginasTableMap::COL_ESTADO, JaPaginasTableMap::COL_CATEGORIA, JaPaginasTableMap::COL_TIPO, JaPaginasTableMap::COL_AUTOR, JaPaginasTableMap::COL_PADRE, JaPaginasTableMap::COL_SLUG, JaPaginasTableMap::COL_META_DESCRIPCION, JaPaginasTableMap::COL_META_PALABRAS, JaPaginasTableMap::COL_META_TITULO, JaPaginasTableMap::COL_FECHA_CREADO, JaPaginasTableMap::COL_FECHA_MODIFICADO, JaPaginasTableMap::COL_CONFIGURACION, ),
        self::TYPE_FIELDNAME     => array('id', 'titulo', 'contenido', 'imagen', 'leermas', 'estado', 'categoria', 'tipo', 'autor', 'padre', 'slug', 'meta_descripcion', 'meta_palabras', 'meta_titulo', 'fecha_creado', 'fecha_modificado', 'configuracion', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'Titulo' => 1, 'Contenido' => 2, 'Imagen' => 3, 'Leermas' => 4, 'Estado' => 5, 'Categoria' => 6, 'Tipo' => 7, 'Autor' => 8, 'Padre' => 9, 'Slug' => 10, 'MetaDescripcion' => 11, 'MetaPalabras' => 12, 'MetaTitulo' => 13, 'FechaCreado' => 14, 'FechaModificado' => 15, 'Configuracion' => 16, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'titulo' => 1, 'contenido' => 2, 'imagen' => 3, 'leermas' => 4, 'estado' => 5, 'categoria' => 6, 'tipo' => 7, 'autor' => 8, 'padre' => 9, 'slug' => 10, 'metaDescripcion' => 11, 'metaPalabras' => 12, 'metaTitulo' => 13, 'fechaCreado' => 14, 'fechaModificado' => 15, 'configuracion' => 16, ),
        self::TYPE_COLNAME       => array(JaPaginasTableMap::COL_ID => 0, JaPaginasTableMap::COL_TITULO => 1, JaPaginasTableMap::COL_CONTENIDO => 2, JaPaginasTableMap::COL_IMAGEN => 3, JaPaginasTableMap::COL_LEERMAS => 4, JaPaginasTableMap::COL_ESTADO => 5, JaPaginasTableMap::COL_CATEGORIA => 6, JaPaginasTableMap::COL_TIPO => 7, JaPaginasTableMap::COL_AUTOR => 8, JaPaginasTableMap::COL_PADRE => 9, JaPaginasTableMap::COL_SLUG => 10, JaPaginasTableMap::COL_META_DESCRIPCION => 11, JaPaginasTableMap::COL_META_PALABRAS => 12, JaPaginasTableMap::COL_META_TITULO => 13, JaPaginasTableMap::COL_FECHA_CREADO => 14, JaPaginasTableMap::COL_FECHA_MODIFICADO => 15, JaPaginasTableMap::COL_CONFIGURACION => 16, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'titulo' => 1, 'contenido' => 2, 'imagen' => 3, 'leermas' => 4, 'estado' => 5, 'categoria' => 6, 'tipo' => 7, 'autor' => 8, 'padre' => 9, 'slug' => 10, 'meta_descripcion' => 11, 'meta_palabras' => 12, 'meta_titulo' => 13, 'fecha_creado' => 14, 'fecha_modificado' => 15, 'configuracion' => 16, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, )
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
        $this->setName('ja_paginas');
        $this->setPhpName('JaPaginas');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\JaPaginas');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, 10, null);
        $this->addColumn('titulo', 'Titulo', 'LONGVARCHAR', true, null, null);
        $this->addColumn('contenido', 'Contenido', 'CLOB', false, null, null);
        $this->addColumn('imagen', 'Imagen', 'VARCHAR', false, 200, null);
        $this->addColumn('leermas', 'Leermas', 'LONGVARCHAR', false, null, null);
        $this->addColumn('estado', 'Estado', 'CHAR', false, null, 'publicado');
        $this->addColumn('categoria', 'Categoria', 'INTEGER', false, 4, null);
        $this->addColumn('tipo', 'Tipo', 'CHAR', true, null, 'articulo');
        $this->addColumn('autor', 'Autor', 'INTEGER', false, 4, 0);
        $this->addColumn('padre', 'Padre', 'BIGINT', false, null, 0);
        $this->addColumn('slug', 'Slug', 'LONGVARCHAR', false, null, null);
        $this->addColumn('meta_descripcion', 'MetaDescripcion', 'LONGVARCHAR', false, null, null);
        $this->addColumn('meta_palabras', 'MetaPalabras', 'LONGVARCHAR', false, null, null);
        $this->addColumn('meta_titulo', 'MetaTitulo', 'VARCHAR', false, 80, null);
        $this->addColumn('fecha_creado', 'FechaCreado', 'TIMESTAMP', false, null, '0000-00-00 00:00:00');
        $this->addColumn('fecha_modificado', 'FechaModificado', 'TIMESTAMP', false, null, '0000-00-00 00:00:00');
        $this->addColumn('configuracion', 'Configuracion', 'LONGVARCHAR', false, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('JaPaginaCategorias', '\\JaPaginaCategorias', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':id_pagina',
    1 => ':id',
  ),
), 'CASCADE', null, 'JaPaginaCategoriass', false);
    } // buildRelations()
    /**
     * Method to invalidate the instance pool of all tables related to ja_paginas     * by a foreign key with ON DELETE CASCADE
     */
    public static function clearRelatedInstancePool()
    {
        // Invalidate objects in related instance pools,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        JaPaginaCategoriasTableMap::clearInstancePool();
    }

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
        return $withPrefix ? JaPaginasTableMap::CLASS_DEFAULT : JaPaginasTableMap::OM_CLASS;
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
     * @return array           (JaPaginas object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = JaPaginasTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = JaPaginasTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + JaPaginasTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = JaPaginasTableMap::OM_CLASS;
            /** @var JaPaginas $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            JaPaginasTableMap::addInstanceToPool($obj, $key);
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
            $key = JaPaginasTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = JaPaginasTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var JaPaginas $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                JaPaginasTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(JaPaginasTableMap::COL_ID);
            $criteria->addSelectColumn(JaPaginasTableMap::COL_TITULO);
            $criteria->addSelectColumn(JaPaginasTableMap::COL_CONTENIDO);
            $criteria->addSelectColumn(JaPaginasTableMap::COL_IMAGEN);
            $criteria->addSelectColumn(JaPaginasTableMap::COL_LEERMAS);
            $criteria->addSelectColumn(JaPaginasTableMap::COL_ESTADO);
            $criteria->addSelectColumn(JaPaginasTableMap::COL_CATEGORIA);
            $criteria->addSelectColumn(JaPaginasTableMap::COL_TIPO);
            $criteria->addSelectColumn(JaPaginasTableMap::COL_AUTOR);
            $criteria->addSelectColumn(JaPaginasTableMap::COL_PADRE);
            $criteria->addSelectColumn(JaPaginasTableMap::COL_SLUG);
            $criteria->addSelectColumn(JaPaginasTableMap::COL_META_DESCRIPCION);
            $criteria->addSelectColumn(JaPaginasTableMap::COL_META_PALABRAS);
            $criteria->addSelectColumn(JaPaginasTableMap::COL_META_TITULO);
            $criteria->addSelectColumn(JaPaginasTableMap::COL_FECHA_CREADO);
            $criteria->addSelectColumn(JaPaginasTableMap::COL_FECHA_MODIFICADO);
            $criteria->addSelectColumn(JaPaginasTableMap::COL_CONFIGURACION);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.titulo');
            $criteria->addSelectColumn($alias . '.contenido');
            $criteria->addSelectColumn($alias . '.imagen');
            $criteria->addSelectColumn($alias . '.leermas');
            $criteria->addSelectColumn($alias . '.estado');
            $criteria->addSelectColumn($alias . '.categoria');
            $criteria->addSelectColumn($alias . '.tipo');
            $criteria->addSelectColumn($alias . '.autor');
            $criteria->addSelectColumn($alias . '.padre');
            $criteria->addSelectColumn($alias . '.slug');
            $criteria->addSelectColumn($alias . '.meta_descripcion');
            $criteria->addSelectColumn($alias . '.meta_palabras');
            $criteria->addSelectColumn($alias . '.meta_titulo');
            $criteria->addSelectColumn($alias . '.fecha_creado');
            $criteria->addSelectColumn($alias . '.fecha_modificado');
            $criteria->addSelectColumn($alias . '.configuracion');
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
        return Propel::getServiceContainer()->getDatabaseMap(JaPaginasTableMap::DATABASE_NAME)->getTable(JaPaginasTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(JaPaginasTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(JaPaginasTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new JaPaginasTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a JaPaginas or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or JaPaginas object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(JaPaginasTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \JaPaginas) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(JaPaginasTableMap::DATABASE_NAME);
            $criteria->add(JaPaginasTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = JaPaginasQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            JaPaginasTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                JaPaginasTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the ja_paginas table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return JaPaginasQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a JaPaginas or Criteria object.
     *
     * @param mixed               $criteria Criteria or JaPaginas object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(JaPaginasTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from JaPaginas object
        }

        if ($criteria->containsKey(JaPaginasTableMap::COL_ID) && $criteria->keyContainsValue(JaPaginasTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.JaPaginasTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = JaPaginasQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // JaPaginasTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
JaPaginasTableMap::buildTableMap();
