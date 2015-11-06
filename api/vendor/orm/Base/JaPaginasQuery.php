<?php

namespace Base;

use \JaPaginas as ChildJaPaginas;
use \JaPaginasQuery as ChildJaPaginasQuery;
use \Exception;
use \PDO;
use Map\JaPaginasTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'ja_paginas' table.
 *
 * 
 *
 * @method     ChildJaPaginasQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildJaPaginasQuery orderByTitulo($order = Criteria::ASC) Order by the titulo column
 * @method     ChildJaPaginasQuery orderByContenido($order = Criteria::ASC) Order by the contenido column
 * @method     ChildJaPaginasQuery orderByImagen($order = Criteria::ASC) Order by the imagen column
 * @method     ChildJaPaginasQuery orderByLeermas($order = Criteria::ASC) Order by the leermas column
 * @method     ChildJaPaginasQuery orderByEstado($order = Criteria::ASC) Order by the estado column
 * @method     ChildJaPaginasQuery orderByCategoria($order = Criteria::ASC) Order by the categoria column
 * @method     ChildJaPaginasQuery orderByTipo($order = Criteria::ASC) Order by the tipo column
 * @method     ChildJaPaginasQuery orderByAutor($order = Criteria::ASC) Order by the autor column
 * @method     ChildJaPaginasQuery orderByPadre($order = Criteria::ASC) Order by the padre column
 * @method     ChildJaPaginasQuery orderBySlug($order = Criteria::ASC) Order by the slug column
 * @method     ChildJaPaginasQuery orderByMetaDescripcion($order = Criteria::ASC) Order by the meta_descripcion column
 * @method     ChildJaPaginasQuery orderByMetaPalabras($order = Criteria::ASC) Order by the meta_palabras column
 * @method     ChildJaPaginasQuery orderByMetaTitulo($order = Criteria::ASC) Order by the meta_titulo column
 * @method     ChildJaPaginasQuery orderByFechaCreado($order = Criteria::ASC) Order by the fecha_creado column
 * @method     ChildJaPaginasQuery orderByFechaModificado($order = Criteria::ASC) Order by the fecha_modificado column
 * @method     ChildJaPaginasQuery orderByConfiguracion($order = Criteria::ASC) Order by the configuracion column
 *
 * @method     ChildJaPaginasQuery groupById() Group by the id column
 * @method     ChildJaPaginasQuery groupByTitulo() Group by the titulo column
 * @method     ChildJaPaginasQuery groupByContenido() Group by the contenido column
 * @method     ChildJaPaginasQuery groupByImagen() Group by the imagen column
 * @method     ChildJaPaginasQuery groupByLeermas() Group by the leermas column
 * @method     ChildJaPaginasQuery groupByEstado() Group by the estado column
 * @method     ChildJaPaginasQuery groupByCategoria() Group by the categoria column
 * @method     ChildJaPaginasQuery groupByTipo() Group by the tipo column
 * @method     ChildJaPaginasQuery groupByAutor() Group by the autor column
 * @method     ChildJaPaginasQuery groupByPadre() Group by the padre column
 * @method     ChildJaPaginasQuery groupBySlug() Group by the slug column
 * @method     ChildJaPaginasQuery groupByMetaDescripcion() Group by the meta_descripcion column
 * @method     ChildJaPaginasQuery groupByMetaPalabras() Group by the meta_palabras column
 * @method     ChildJaPaginasQuery groupByMetaTitulo() Group by the meta_titulo column
 * @method     ChildJaPaginasQuery groupByFechaCreado() Group by the fecha_creado column
 * @method     ChildJaPaginasQuery groupByFechaModificado() Group by the fecha_modificado column
 * @method     ChildJaPaginasQuery groupByConfiguracion() Group by the configuracion column
 *
 * @method     ChildJaPaginasQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildJaPaginasQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildJaPaginasQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildJaPaginasQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildJaPaginasQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildJaPaginasQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildJaPaginasQuery leftJoinJaPaginaCategorias($relationAlias = null) Adds a LEFT JOIN clause to the query using the JaPaginaCategorias relation
 * @method     ChildJaPaginasQuery rightJoinJaPaginaCategorias($relationAlias = null) Adds a RIGHT JOIN clause to the query using the JaPaginaCategorias relation
 * @method     ChildJaPaginasQuery innerJoinJaPaginaCategorias($relationAlias = null) Adds a INNER JOIN clause to the query using the JaPaginaCategorias relation
 *
 * @method     ChildJaPaginasQuery joinWithJaPaginaCategorias($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the JaPaginaCategorias relation
 *
 * @method     ChildJaPaginasQuery leftJoinWithJaPaginaCategorias() Adds a LEFT JOIN clause and with to the query using the JaPaginaCategorias relation
 * @method     ChildJaPaginasQuery rightJoinWithJaPaginaCategorias() Adds a RIGHT JOIN clause and with to the query using the JaPaginaCategorias relation
 * @method     ChildJaPaginasQuery innerJoinWithJaPaginaCategorias() Adds a INNER JOIN clause and with to the query using the JaPaginaCategorias relation
 *
 * @method     \JaPaginaCategoriasQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildJaPaginas findOne(ConnectionInterface $con = null) Return the first ChildJaPaginas matching the query
 * @method     ChildJaPaginas findOneOrCreate(ConnectionInterface $con = null) Return the first ChildJaPaginas matching the query, or a new ChildJaPaginas object populated from the query conditions when no match is found
 *
 * @method     ChildJaPaginas findOneById(int $id) Return the first ChildJaPaginas filtered by the id column
 * @method     ChildJaPaginas findOneByTitulo(string $titulo) Return the first ChildJaPaginas filtered by the titulo column
 * @method     ChildJaPaginas findOneByContenido(string $contenido) Return the first ChildJaPaginas filtered by the contenido column
 * @method     ChildJaPaginas findOneByImagen(string $imagen) Return the first ChildJaPaginas filtered by the imagen column
 * @method     ChildJaPaginas findOneByLeermas(string $leermas) Return the first ChildJaPaginas filtered by the leermas column
 * @method     ChildJaPaginas findOneByEstado(string $estado) Return the first ChildJaPaginas filtered by the estado column
 * @method     ChildJaPaginas findOneByCategoria(int $categoria) Return the first ChildJaPaginas filtered by the categoria column
 * @method     ChildJaPaginas findOneByTipo(string $tipo) Return the first ChildJaPaginas filtered by the tipo column
 * @method     ChildJaPaginas findOneByAutor(int $autor) Return the first ChildJaPaginas filtered by the autor column
 * @method     ChildJaPaginas findOneByPadre(string $padre) Return the first ChildJaPaginas filtered by the padre column
 * @method     ChildJaPaginas findOneBySlug(string $slug) Return the first ChildJaPaginas filtered by the slug column
 * @method     ChildJaPaginas findOneByMetaDescripcion(string $meta_descripcion) Return the first ChildJaPaginas filtered by the meta_descripcion column
 * @method     ChildJaPaginas findOneByMetaPalabras(string $meta_palabras) Return the first ChildJaPaginas filtered by the meta_palabras column
 * @method     ChildJaPaginas findOneByMetaTitulo(string $meta_titulo) Return the first ChildJaPaginas filtered by the meta_titulo column
 * @method     ChildJaPaginas findOneByFechaCreado(string $fecha_creado) Return the first ChildJaPaginas filtered by the fecha_creado column
 * @method     ChildJaPaginas findOneByFechaModificado(string $fecha_modificado) Return the first ChildJaPaginas filtered by the fecha_modificado column
 * @method     ChildJaPaginas findOneByConfiguracion(string $configuracion) Return the first ChildJaPaginas filtered by the configuracion column *

 * @method     ChildJaPaginas requirePk($key, ConnectionInterface $con = null) Return the ChildJaPaginas by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildJaPaginas requireOne(ConnectionInterface $con = null) Return the first ChildJaPaginas matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildJaPaginas requireOneById(int $id) Return the first ChildJaPaginas filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildJaPaginas requireOneByTitulo(string $titulo) Return the first ChildJaPaginas filtered by the titulo column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildJaPaginas requireOneByContenido(string $contenido) Return the first ChildJaPaginas filtered by the contenido column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildJaPaginas requireOneByImagen(string $imagen) Return the first ChildJaPaginas filtered by the imagen column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildJaPaginas requireOneByLeermas(string $leermas) Return the first ChildJaPaginas filtered by the leermas column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildJaPaginas requireOneByEstado(string $estado) Return the first ChildJaPaginas filtered by the estado column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildJaPaginas requireOneByCategoria(int $categoria) Return the first ChildJaPaginas filtered by the categoria column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildJaPaginas requireOneByTipo(string $tipo) Return the first ChildJaPaginas filtered by the tipo column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildJaPaginas requireOneByAutor(int $autor) Return the first ChildJaPaginas filtered by the autor column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildJaPaginas requireOneByPadre(string $padre) Return the first ChildJaPaginas filtered by the padre column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildJaPaginas requireOneBySlug(string $slug) Return the first ChildJaPaginas filtered by the slug column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildJaPaginas requireOneByMetaDescripcion(string $meta_descripcion) Return the first ChildJaPaginas filtered by the meta_descripcion column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildJaPaginas requireOneByMetaPalabras(string $meta_palabras) Return the first ChildJaPaginas filtered by the meta_palabras column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildJaPaginas requireOneByMetaTitulo(string $meta_titulo) Return the first ChildJaPaginas filtered by the meta_titulo column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildJaPaginas requireOneByFechaCreado(string $fecha_creado) Return the first ChildJaPaginas filtered by the fecha_creado column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildJaPaginas requireOneByFechaModificado(string $fecha_modificado) Return the first ChildJaPaginas filtered by the fecha_modificado column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildJaPaginas requireOneByConfiguracion(string $configuracion) Return the first ChildJaPaginas filtered by the configuracion column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildJaPaginas[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildJaPaginas objects based on current ModelCriteria
 * @method     ChildJaPaginas[]|ObjectCollection findById(int $id) Return ChildJaPaginas objects filtered by the id column
 * @method     ChildJaPaginas[]|ObjectCollection findByTitulo(string $titulo) Return ChildJaPaginas objects filtered by the titulo column
 * @method     ChildJaPaginas[]|ObjectCollection findByContenido(string $contenido) Return ChildJaPaginas objects filtered by the contenido column
 * @method     ChildJaPaginas[]|ObjectCollection findByImagen(string $imagen) Return ChildJaPaginas objects filtered by the imagen column
 * @method     ChildJaPaginas[]|ObjectCollection findByLeermas(string $leermas) Return ChildJaPaginas objects filtered by the leermas column
 * @method     ChildJaPaginas[]|ObjectCollection findByEstado(string $estado) Return ChildJaPaginas objects filtered by the estado column
 * @method     ChildJaPaginas[]|ObjectCollection findByCategoria(int $categoria) Return ChildJaPaginas objects filtered by the categoria column
 * @method     ChildJaPaginas[]|ObjectCollection findByTipo(string $tipo) Return ChildJaPaginas objects filtered by the tipo column
 * @method     ChildJaPaginas[]|ObjectCollection findByAutor(int $autor) Return ChildJaPaginas objects filtered by the autor column
 * @method     ChildJaPaginas[]|ObjectCollection findByPadre(string $padre) Return ChildJaPaginas objects filtered by the padre column
 * @method     ChildJaPaginas[]|ObjectCollection findBySlug(string $slug) Return ChildJaPaginas objects filtered by the slug column
 * @method     ChildJaPaginas[]|ObjectCollection findByMetaDescripcion(string $meta_descripcion) Return ChildJaPaginas objects filtered by the meta_descripcion column
 * @method     ChildJaPaginas[]|ObjectCollection findByMetaPalabras(string $meta_palabras) Return ChildJaPaginas objects filtered by the meta_palabras column
 * @method     ChildJaPaginas[]|ObjectCollection findByMetaTitulo(string $meta_titulo) Return ChildJaPaginas objects filtered by the meta_titulo column
 * @method     ChildJaPaginas[]|ObjectCollection findByFechaCreado(string $fecha_creado) Return ChildJaPaginas objects filtered by the fecha_creado column
 * @method     ChildJaPaginas[]|ObjectCollection findByFechaModificado(string $fecha_modificado) Return ChildJaPaginas objects filtered by the fecha_modificado column
 * @method     ChildJaPaginas[]|ObjectCollection findByConfiguracion(string $configuracion) Return ChildJaPaginas objects filtered by the configuracion column
 * @method     ChildJaPaginas[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class JaPaginasQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\JaPaginasQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\JaPaginas', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildJaPaginasQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildJaPaginasQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildJaPaginasQuery) {
            return $criteria;
        }
        $query = new ChildJaPaginasQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildJaPaginas|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = JaPaginasTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(JaPaginasTableMap::DATABASE_NAME);
        }
        $this->basePreSelect($con);
        if ($this->formatter || $this->modelAlias || $this->with || $this->select
         || $this->selectColumns || $this->asColumns || $this->selectModifiers
         || $this->map || $this->having || $this->joins) {
            return $this->findPkComplex($key, $con);
        } else {
            return $this->findPkSimple($key, $con);
        }
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildJaPaginas A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, titulo, contenido, imagen, leermas, estado, categoria, tipo, autor, padre, slug, meta_descripcion, meta_palabras, meta_titulo, fecha_creado, fecha_modificado, configuracion FROM ja_paginas WHERE id = :p0';
        try {
            $stmt = $con->prepare($sql);            
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildJaPaginas $obj */
            $obj = new ChildJaPaginas();
            $obj->hydrate($row);
            JaPaginasTableMap::addInstanceToPool($obj, (string) $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return ChildJaPaginas|array|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, ConnectionInterface $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($dataFetcher);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ObjectCollection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getReadConnection($this->getDbName());
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($dataFetcher);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return $this|ChildJaPaginasQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(JaPaginasTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildJaPaginasQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(JaPaginasTableMap::COL_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE id = 1234
     * $query->filterById(array(12, 34)); // WHERE id IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE id > 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildJaPaginasQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(JaPaginasTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(JaPaginasTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(JaPaginasTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the titulo column
     *
     * Example usage:
     * <code>
     * $query->filterByTitulo('fooValue');   // WHERE titulo = 'fooValue'
     * $query->filterByTitulo('%fooValue%'); // WHERE titulo LIKE '%fooValue%'
     * </code>
     *
     * @param     string $titulo The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildJaPaginasQuery The current query, for fluid interface
     */
    public function filterByTitulo($titulo = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($titulo)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $titulo)) {
                $titulo = str_replace('*', '%', $titulo);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(JaPaginasTableMap::COL_TITULO, $titulo, $comparison);
    }

    /**
     * Filter the query on the contenido column
     *
     * Example usage:
     * <code>
     * $query->filterByContenido('fooValue');   // WHERE contenido = 'fooValue'
     * $query->filterByContenido('%fooValue%'); // WHERE contenido LIKE '%fooValue%'
     * </code>
     *
     * @param     string $contenido The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildJaPaginasQuery The current query, for fluid interface
     */
    public function filterByContenido($contenido = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($contenido)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $contenido)) {
                $contenido = str_replace('*', '%', $contenido);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(JaPaginasTableMap::COL_CONTENIDO, $contenido, $comparison);
    }

    /**
     * Filter the query on the imagen column
     *
     * Example usage:
     * <code>
     * $query->filterByImagen('fooValue');   // WHERE imagen = 'fooValue'
     * $query->filterByImagen('%fooValue%'); // WHERE imagen LIKE '%fooValue%'
     * </code>
     *
     * @param     string $imagen The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildJaPaginasQuery The current query, for fluid interface
     */
    public function filterByImagen($imagen = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($imagen)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $imagen)) {
                $imagen = str_replace('*', '%', $imagen);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(JaPaginasTableMap::COL_IMAGEN, $imagen, $comparison);
    }

    /**
     * Filter the query on the leermas column
     *
     * Example usage:
     * <code>
     * $query->filterByLeermas('fooValue');   // WHERE leermas = 'fooValue'
     * $query->filterByLeermas('%fooValue%'); // WHERE leermas LIKE '%fooValue%'
     * </code>
     *
     * @param     string $leermas The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildJaPaginasQuery The current query, for fluid interface
     */
    public function filterByLeermas($leermas = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($leermas)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $leermas)) {
                $leermas = str_replace('*', '%', $leermas);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(JaPaginasTableMap::COL_LEERMAS, $leermas, $comparison);
    }

    /**
     * Filter the query on the estado column
     *
     * Example usage:
     * <code>
     * $query->filterByEstado('fooValue');   // WHERE estado = 'fooValue'
     * $query->filterByEstado('%fooValue%'); // WHERE estado LIKE '%fooValue%'
     * </code>
     *
     * @param     string $estado The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildJaPaginasQuery The current query, for fluid interface
     */
    public function filterByEstado($estado = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($estado)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $estado)) {
                $estado = str_replace('*', '%', $estado);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(JaPaginasTableMap::COL_ESTADO, $estado, $comparison);
    }

    /**
     * Filter the query on the categoria column
     *
     * Example usage:
     * <code>
     * $query->filterByCategoria(1234); // WHERE categoria = 1234
     * $query->filterByCategoria(array(12, 34)); // WHERE categoria IN (12, 34)
     * $query->filterByCategoria(array('min' => 12)); // WHERE categoria > 12
     * </code>
     *
     * @param     mixed $categoria The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildJaPaginasQuery The current query, for fluid interface
     */
    public function filterByCategoria($categoria = null, $comparison = null)
    {
        if (is_array($categoria)) {
            $useMinMax = false;
            if (isset($categoria['min'])) {
                $this->addUsingAlias(JaPaginasTableMap::COL_CATEGORIA, $categoria['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($categoria['max'])) {
                $this->addUsingAlias(JaPaginasTableMap::COL_CATEGORIA, $categoria['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(JaPaginasTableMap::COL_CATEGORIA, $categoria, $comparison);
    }

    /**
     * Filter the query on the tipo column
     *
     * Example usage:
     * <code>
     * $query->filterByTipo('fooValue');   // WHERE tipo = 'fooValue'
     * $query->filterByTipo('%fooValue%'); // WHERE tipo LIKE '%fooValue%'
     * </code>
     *
     * @param     string $tipo The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildJaPaginasQuery The current query, for fluid interface
     */
    public function filterByTipo($tipo = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($tipo)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $tipo)) {
                $tipo = str_replace('*', '%', $tipo);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(JaPaginasTableMap::COL_TIPO, $tipo, $comparison);
    }

    /**
     * Filter the query on the autor column
     *
     * Example usage:
     * <code>
     * $query->filterByAutor(1234); // WHERE autor = 1234
     * $query->filterByAutor(array(12, 34)); // WHERE autor IN (12, 34)
     * $query->filterByAutor(array('min' => 12)); // WHERE autor > 12
     * </code>
     *
     * @param     mixed $autor The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildJaPaginasQuery The current query, for fluid interface
     */
    public function filterByAutor($autor = null, $comparison = null)
    {
        if (is_array($autor)) {
            $useMinMax = false;
            if (isset($autor['min'])) {
                $this->addUsingAlias(JaPaginasTableMap::COL_AUTOR, $autor['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($autor['max'])) {
                $this->addUsingAlias(JaPaginasTableMap::COL_AUTOR, $autor['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(JaPaginasTableMap::COL_AUTOR, $autor, $comparison);
    }

    /**
     * Filter the query on the padre column
     *
     * Example usage:
     * <code>
     * $query->filterByPadre(1234); // WHERE padre = 1234
     * $query->filterByPadre(array(12, 34)); // WHERE padre IN (12, 34)
     * $query->filterByPadre(array('min' => 12)); // WHERE padre > 12
     * </code>
     *
     * @param     mixed $padre The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildJaPaginasQuery The current query, for fluid interface
     */
    public function filterByPadre($padre = null, $comparison = null)
    {
        if (is_array($padre)) {
            $useMinMax = false;
            if (isset($padre['min'])) {
                $this->addUsingAlias(JaPaginasTableMap::COL_PADRE, $padre['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($padre['max'])) {
                $this->addUsingAlias(JaPaginasTableMap::COL_PADRE, $padre['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(JaPaginasTableMap::COL_PADRE, $padre, $comparison);
    }

    /**
     * Filter the query on the slug column
     *
     * Example usage:
     * <code>
     * $query->filterBySlug('fooValue');   // WHERE slug = 'fooValue'
     * $query->filterBySlug('%fooValue%'); // WHERE slug LIKE '%fooValue%'
     * </code>
     *
     * @param     string $slug The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildJaPaginasQuery The current query, for fluid interface
     */
    public function filterBySlug($slug = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($slug)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $slug)) {
                $slug = str_replace('*', '%', $slug);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(JaPaginasTableMap::COL_SLUG, $slug, $comparison);
    }

    /**
     * Filter the query on the meta_descripcion column
     *
     * Example usage:
     * <code>
     * $query->filterByMetaDescripcion('fooValue');   // WHERE meta_descripcion = 'fooValue'
     * $query->filterByMetaDescripcion('%fooValue%'); // WHERE meta_descripcion LIKE '%fooValue%'
     * </code>
     *
     * @param     string $metaDescripcion The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildJaPaginasQuery The current query, for fluid interface
     */
    public function filterByMetaDescripcion($metaDescripcion = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($metaDescripcion)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $metaDescripcion)) {
                $metaDescripcion = str_replace('*', '%', $metaDescripcion);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(JaPaginasTableMap::COL_META_DESCRIPCION, $metaDescripcion, $comparison);
    }

    /**
     * Filter the query on the meta_palabras column
     *
     * Example usage:
     * <code>
     * $query->filterByMetaPalabras('fooValue');   // WHERE meta_palabras = 'fooValue'
     * $query->filterByMetaPalabras('%fooValue%'); // WHERE meta_palabras LIKE '%fooValue%'
     * </code>
     *
     * @param     string $metaPalabras The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildJaPaginasQuery The current query, for fluid interface
     */
    public function filterByMetaPalabras($metaPalabras = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($metaPalabras)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $metaPalabras)) {
                $metaPalabras = str_replace('*', '%', $metaPalabras);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(JaPaginasTableMap::COL_META_PALABRAS, $metaPalabras, $comparison);
    }

    /**
     * Filter the query on the meta_titulo column
     *
     * Example usage:
     * <code>
     * $query->filterByMetaTitulo('fooValue');   // WHERE meta_titulo = 'fooValue'
     * $query->filterByMetaTitulo('%fooValue%'); // WHERE meta_titulo LIKE '%fooValue%'
     * </code>
     *
     * @param     string $metaTitulo The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildJaPaginasQuery The current query, for fluid interface
     */
    public function filterByMetaTitulo($metaTitulo = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($metaTitulo)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $metaTitulo)) {
                $metaTitulo = str_replace('*', '%', $metaTitulo);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(JaPaginasTableMap::COL_META_TITULO, $metaTitulo, $comparison);
    }

    /**
     * Filter the query on the fecha_creado column
     *
     * Example usage:
     * <code>
     * $query->filterByFechaCreado('2011-03-14'); // WHERE fecha_creado = '2011-03-14'
     * $query->filterByFechaCreado('now'); // WHERE fecha_creado = '2011-03-14'
     * $query->filterByFechaCreado(array('max' => 'yesterday')); // WHERE fecha_creado > '2011-03-13'
     * </code>
     *
     * @param     mixed $fechaCreado The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildJaPaginasQuery The current query, for fluid interface
     */
    public function filterByFechaCreado($fechaCreado = null, $comparison = null)
    {
        if (is_array($fechaCreado)) {
            $useMinMax = false;
            if (isset($fechaCreado['min'])) {
                $this->addUsingAlias(JaPaginasTableMap::COL_FECHA_CREADO, $fechaCreado['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($fechaCreado['max'])) {
                $this->addUsingAlias(JaPaginasTableMap::COL_FECHA_CREADO, $fechaCreado['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(JaPaginasTableMap::COL_FECHA_CREADO, $fechaCreado, $comparison);
    }

    /**
     * Filter the query on the fecha_modificado column
     *
     * Example usage:
     * <code>
     * $query->filterByFechaModificado('2011-03-14'); // WHERE fecha_modificado = '2011-03-14'
     * $query->filterByFechaModificado('now'); // WHERE fecha_modificado = '2011-03-14'
     * $query->filterByFechaModificado(array('max' => 'yesterday')); // WHERE fecha_modificado > '2011-03-13'
     * </code>
     *
     * @param     mixed $fechaModificado The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildJaPaginasQuery The current query, for fluid interface
     */
    public function filterByFechaModificado($fechaModificado = null, $comparison = null)
    {
        if (is_array($fechaModificado)) {
            $useMinMax = false;
            if (isset($fechaModificado['min'])) {
                $this->addUsingAlias(JaPaginasTableMap::COL_FECHA_MODIFICADO, $fechaModificado['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($fechaModificado['max'])) {
                $this->addUsingAlias(JaPaginasTableMap::COL_FECHA_MODIFICADO, $fechaModificado['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(JaPaginasTableMap::COL_FECHA_MODIFICADO, $fechaModificado, $comparison);
    }

    /**
     * Filter the query on the configuracion column
     *
     * Example usage:
     * <code>
     * $query->filterByConfiguracion('fooValue');   // WHERE configuracion = 'fooValue'
     * $query->filterByConfiguracion('%fooValue%'); // WHERE configuracion LIKE '%fooValue%'
     * </code>
     *
     * @param     string $configuracion The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildJaPaginasQuery The current query, for fluid interface
     */
    public function filterByConfiguracion($configuracion = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($configuracion)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $configuracion)) {
                $configuracion = str_replace('*', '%', $configuracion);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(JaPaginasTableMap::COL_CONFIGURACION, $configuracion, $comparison);
    }

    /**
     * Filter the query by a related \JaPaginaCategorias object
     *
     * @param \JaPaginaCategorias|ObjectCollection $jaPaginaCategorias the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildJaPaginasQuery The current query, for fluid interface
     */
    public function filterByJaPaginaCategorias($jaPaginaCategorias, $comparison = null)
    {
        if ($jaPaginaCategorias instanceof \JaPaginaCategorias) {
            return $this
                ->addUsingAlias(JaPaginasTableMap::COL_ID, $jaPaginaCategorias->getIdPagina(), $comparison);
        } elseif ($jaPaginaCategorias instanceof ObjectCollection) {
            return $this
                ->useJaPaginaCategoriasQuery()
                ->filterByPrimaryKeys($jaPaginaCategorias->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByJaPaginaCategorias() only accepts arguments of type \JaPaginaCategorias or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the JaPaginaCategorias relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildJaPaginasQuery The current query, for fluid interface
     */
    public function joinJaPaginaCategorias($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('JaPaginaCategorias');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'JaPaginaCategorias');
        }

        return $this;
    }

    /**
     * Use the JaPaginaCategorias relation JaPaginaCategorias object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \JaPaginaCategoriasQuery A secondary query class using the current class as primary query
     */
    public function useJaPaginaCategoriasQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinJaPaginaCategorias($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'JaPaginaCategorias', '\JaPaginaCategoriasQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildJaPaginas $jaPaginas Object to remove from the list of results
     *
     * @return $this|ChildJaPaginasQuery The current query, for fluid interface
     */
    public function prune($jaPaginas = null)
    {
        if ($jaPaginas) {
            $this->addUsingAlias(JaPaginasTableMap::COL_ID, $jaPaginas->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the ja_paginas table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(JaPaginasTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            JaPaginasTableMap::clearInstancePool();
            JaPaginasTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    /**
     * Performs a DELETE on the database based on the current ModelCriteria
     *
     * @param ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public function delete(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(JaPaginasTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(JaPaginasTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            
            JaPaginasTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            JaPaginasTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // JaPaginasQuery
