<?php

namespace Base;

use \JaUsuarios as ChildJaUsuarios;
use \JaUsuariosQuery as ChildJaUsuariosQuery;
use \Exception;
use \PDO;
use Map\JaUsuariosTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'ja_usuarios' table.
 *
 * 
 *
 * @method     ChildJaUsuariosQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildJaUsuariosQuery orderByUsuario($order = Criteria::ASC) Order by the usuario column
 * @method     ChildJaUsuariosQuery orderByImagen($order = Criteria::ASC) Order by the imagen column
 * @method     ChildJaUsuariosQuery orderByNombre($order = Criteria::ASC) Order by the nombre column
 * @method     ChildJaUsuariosQuery orderByApellidos($order = Criteria::ASC) Order by the apellidos column
 * @method     ChildJaUsuariosQuery orderByBiografia($order = Criteria::ASC) Order by the biografia column
 * @method     ChildJaUsuariosQuery orderByCorreo($order = Criteria::ASC) Order by the correo column
 * @method     ChildJaUsuariosQuery orderByTelefono($order = Criteria::ASC) Order by the telefono column
 * @method     ChildJaUsuariosQuery orderByRedessociales($order = Criteria::ASC) Order by the redessociales column
 * @method     ChildJaUsuariosQuery orderByClave($order = Criteria::ASC) Order by the clave column
 * @method     ChildJaUsuariosQuery orderByDireccion($order = Criteria::ASC) Order by the direccion column
 * @method     ChildJaUsuariosQuery orderByCiudad($order = Criteria::ASC) Order by the ciudad column
 * @method     ChildJaUsuariosQuery orderByPais($order = Criteria::ASC) Order by the pais column
 * @method     ChildJaUsuariosQuery orderByFechacreado($order = Criteria::ASC) Order by the fechacreado column
 *
 * @method     ChildJaUsuariosQuery groupById() Group by the id column
 * @method     ChildJaUsuariosQuery groupByUsuario() Group by the usuario column
 * @method     ChildJaUsuariosQuery groupByImagen() Group by the imagen column
 * @method     ChildJaUsuariosQuery groupByNombre() Group by the nombre column
 * @method     ChildJaUsuariosQuery groupByApellidos() Group by the apellidos column
 * @method     ChildJaUsuariosQuery groupByBiografia() Group by the biografia column
 * @method     ChildJaUsuariosQuery groupByCorreo() Group by the correo column
 * @method     ChildJaUsuariosQuery groupByTelefono() Group by the telefono column
 * @method     ChildJaUsuariosQuery groupByRedessociales() Group by the redessociales column
 * @method     ChildJaUsuariosQuery groupByClave() Group by the clave column
 * @method     ChildJaUsuariosQuery groupByDireccion() Group by the direccion column
 * @method     ChildJaUsuariosQuery groupByCiudad() Group by the ciudad column
 * @method     ChildJaUsuariosQuery groupByPais() Group by the pais column
 * @method     ChildJaUsuariosQuery groupByFechacreado() Group by the fechacreado column
 *
 * @method     ChildJaUsuariosQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildJaUsuariosQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildJaUsuariosQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildJaUsuariosQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildJaUsuariosQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildJaUsuariosQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildJaUsuariosQuery leftJoinJaAclUsuariosPerfiles($relationAlias = null) Adds a LEFT JOIN clause to the query using the JaAclUsuariosPerfiles relation
 * @method     ChildJaUsuariosQuery rightJoinJaAclUsuariosPerfiles($relationAlias = null) Adds a RIGHT JOIN clause to the query using the JaAclUsuariosPerfiles relation
 * @method     ChildJaUsuariosQuery innerJoinJaAclUsuariosPerfiles($relationAlias = null) Adds a INNER JOIN clause to the query using the JaAclUsuariosPerfiles relation
 *
 * @method     ChildJaUsuariosQuery joinWithJaAclUsuariosPerfiles($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the JaAclUsuariosPerfiles relation
 *
 * @method     ChildJaUsuariosQuery leftJoinWithJaAclUsuariosPerfiles() Adds a LEFT JOIN clause and with to the query using the JaAclUsuariosPerfiles relation
 * @method     ChildJaUsuariosQuery rightJoinWithJaAclUsuariosPerfiles() Adds a RIGHT JOIN clause and with to the query using the JaAclUsuariosPerfiles relation
 * @method     ChildJaUsuariosQuery innerJoinWithJaAclUsuariosPerfiles() Adds a INNER JOIN clause and with to the query using the JaAclUsuariosPerfiles relation
 *
 * @method     \JaAclUsuariosPerfilesQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildJaUsuarios findOne(ConnectionInterface $con = null) Return the first ChildJaUsuarios matching the query
 * @method     ChildJaUsuarios findOneOrCreate(ConnectionInterface $con = null) Return the first ChildJaUsuarios matching the query, or a new ChildJaUsuarios object populated from the query conditions when no match is found
 *
 * @method     ChildJaUsuarios findOneById(int $id) Return the first ChildJaUsuarios filtered by the id column
 * @method     ChildJaUsuarios findOneByUsuario(string $usuario) Return the first ChildJaUsuarios filtered by the usuario column
 * @method     ChildJaUsuarios findOneByImagen(string $imagen) Return the first ChildJaUsuarios filtered by the imagen column
 * @method     ChildJaUsuarios findOneByNombre(string $nombre) Return the first ChildJaUsuarios filtered by the nombre column
 * @method     ChildJaUsuarios findOneByApellidos(string $apellidos) Return the first ChildJaUsuarios filtered by the apellidos column
 * @method     ChildJaUsuarios findOneByBiografia(string $biografia) Return the first ChildJaUsuarios filtered by the biografia column
 * @method     ChildJaUsuarios findOneByCorreo(string $correo) Return the first ChildJaUsuarios filtered by the correo column
 * @method     ChildJaUsuarios findOneByTelefono(string $telefono) Return the first ChildJaUsuarios filtered by the telefono column
 * @method     ChildJaUsuarios findOneByRedessociales(string $redessociales) Return the first ChildJaUsuarios filtered by the redessociales column
 * @method     ChildJaUsuarios findOneByClave(string $clave) Return the first ChildJaUsuarios filtered by the clave column
 * @method     ChildJaUsuarios findOneByDireccion(string $direccion) Return the first ChildJaUsuarios filtered by the direccion column
 * @method     ChildJaUsuarios findOneByCiudad(string $ciudad) Return the first ChildJaUsuarios filtered by the ciudad column
 * @method     ChildJaUsuarios findOneByPais(string $pais) Return the first ChildJaUsuarios filtered by the pais column
 * @method     ChildJaUsuarios findOneByFechacreado(string $fechacreado) Return the first ChildJaUsuarios filtered by the fechacreado column *

 * @method     ChildJaUsuarios requirePk($key, ConnectionInterface $con = null) Return the ChildJaUsuarios by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildJaUsuarios requireOne(ConnectionInterface $con = null) Return the first ChildJaUsuarios matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildJaUsuarios requireOneById(int $id) Return the first ChildJaUsuarios filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildJaUsuarios requireOneByUsuario(string $usuario) Return the first ChildJaUsuarios filtered by the usuario column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildJaUsuarios requireOneByImagen(string $imagen) Return the first ChildJaUsuarios filtered by the imagen column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildJaUsuarios requireOneByNombre(string $nombre) Return the first ChildJaUsuarios filtered by the nombre column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildJaUsuarios requireOneByApellidos(string $apellidos) Return the first ChildJaUsuarios filtered by the apellidos column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildJaUsuarios requireOneByBiografia(string $biografia) Return the first ChildJaUsuarios filtered by the biografia column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildJaUsuarios requireOneByCorreo(string $correo) Return the first ChildJaUsuarios filtered by the correo column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildJaUsuarios requireOneByTelefono(string $telefono) Return the first ChildJaUsuarios filtered by the telefono column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildJaUsuarios requireOneByRedessociales(string $redessociales) Return the first ChildJaUsuarios filtered by the redessociales column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildJaUsuarios requireOneByClave(string $clave) Return the first ChildJaUsuarios filtered by the clave column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildJaUsuarios requireOneByDireccion(string $direccion) Return the first ChildJaUsuarios filtered by the direccion column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildJaUsuarios requireOneByCiudad(string $ciudad) Return the first ChildJaUsuarios filtered by the ciudad column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildJaUsuarios requireOneByPais(string $pais) Return the first ChildJaUsuarios filtered by the pais column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildJaUsuarios requireOneByFechacreado(string $fechacreado) Return the first ChildJaUsuarios filtered by the fechacreado column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildJaUsuarios[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildJaUsuarios objects based on current ModelCriteria
 * @method     ChildJaUsuarios[]|ObjectCollection findById(int $id) Return ChildJaUsuarios objects filtered by the id column
 * @method     ChildJaUsuarios[]|ObjectCollection findByUsuario(string $usuario) Return ChildJaUsuarios objects filtered by the usuario column
 * @method     ChildJaUsuarios[]|ObjectCollection findByImagen(string $imagen) Return ChildJaUsuarios objects filtered by the imagen column
 * @method     ChildJaUsuarios[]|ObjectCollection findByNombre(string $nombre) Return ChildJaUsuarios objects filtered by the nombre column
 * @method     ChildJaUsuarios[]|ObjectCollection findByApellidos(string $apellidos) Return ChildJaUsuarios objects filtered by the apellidos column
 * @method     ChildJaUsuarios[]|ObjectCollection findByBiografia(string $biografia) Return ChildJaUsuarios objects filtered by the biografia column
 * @method     ChildJaUsuarios[]|ObjectCollection findByCorreo(string $correo) Return ChildJaUsuarios objects filtered by the correo column
 * @method     ChildJaUsuarios[]|ObjectCollection findByTelefono(string $telefono) Return ChildJaUsuarios objects filtered by the telefono column
 * @method     ChildJaUsuarios[]|ObjectCollection findByRedessociales(string $redessociales) Return ChildJaUsuarios objects filtered by the redessociales column
 * @method     ChildJaUsuarios[]|ObjectCollection findByClave(string $clave) Return ChildJaUsuarios objects filtered by the clave column
 * @method     ChildJaUsuarios[]|ObjectCollection findByDireccion(string $direccion) Return ChildJaUsuarios objects filtered by the direccion column
 * @method     ChildJaUsuarios[]|ObjectCollection findByCiudad(string $ciudad) Return ChildJaUsuarios objects filtered by the ciudad column
 * @method     ChildJaUsuarios[]|ObjectCollection findByPais(string $pais) Return ChildJaUsuarios objects filtered by the pais column
 * @method     ChildJaUsuarios[]|ObjectCollection findByFechacreado(string $fechacreado) Return ChildJaUsuarios objects filtered by the fechacreado column
 * @method     ChildJaUsuarios[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class JaUsuariosQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\JaUsuariosQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\JaUsuarios', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildJaUsuariosQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildJaUsuariosQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildJaUsuariosQuery) {
            return $criteria;
        }
        $query = new ChildJaUsuariosQuery();
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
     * @return ChildJaUsuarios|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = JaUsuariosTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(JaUsuariosTableMap::DATABASE_NAME);
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
     * @return ChildJaUsuarios A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, usuario, imagen, nombre, apellidos, biografia, correo, telefono, redessociales, clave, direccion, ciudad, pais, fechacreado FROM ja_usuarios WHERE id = :p0';
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
            /** @var ChildJaUsuarios $obj */
            $obj = new ChildJaUsuarios();
            $obj->hydrate($row);
            JaUsuariosTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildJaUsuarios|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildJaUsuariosQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(JaUsuariosTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildJaUsuariosQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(JaUsuariosTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildJaUsuariosQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(JaUsuariosTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(JaUsuariosTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(JaUsuariosTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the usuario column
     *
     * Example usage:
     * <code>
     * $query->filterByUsuario('fooValue');   // WHERE usuario = 'fooValue'
     * $query->filterByUsuario('%fooValue%'); // WHERE usuario LIKE '%fooValue%'
     * </code>
     *
     * @param     string $usuario The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildJaUsuariosQuery The current query, for fluid interface
     */
    public function filterByUsuario($usuario = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($usuario)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $usuario)) {
                $usuario = str_replace('*', '%', $usuario);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(JaUsuariosTableMap::COL_USUARIO, $usuario, $comparison);
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
     * @return $this|ChildJaUsuariosQuery The current query, for fluid interface
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

        return $this->addUsingAlias(JaUsuariosTableMap::COL_IMAGEN, $imagen, $comparison);
    }

    /**
     * Filter the query on the nombre column
     *
     * Example usage:
     * <code>
     * $query->filterByNombre('fooValue');   // WHERE nombre = 'fooValue'
     * $query->filterByNombre('%fooValue%'); // WHERE nombre LIKE '%fooValue%'
     * </code>
     *
     * @param     string $nombre The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildJaUsuariosQuery The current query, for fluid interface
     */
    public function filterByNombre($nombre = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($nombre)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $nombre)) {
                $nombre = str_replace('*', '%', $nombre);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(JaUsuariosTableMap::COL_NOMBRE, $nombre, $comparison);
    }

    /**
     * Filter the query on the apellidos column
     *
     * Example usage:
     * <code>
     * $query->filterByApellidos('fooValue');   // WHERE apellidos = 'fooValue'
     * $query->filterByApellidos('%fooValue%'); // WHERE apellidos LIKE '%fooValue%'
     * </code>
     *
     * @param     string $apellidos The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildJaUsuariosQuery The current query, for fluid interface
     */
    public function filterByApellidos($apellidos = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($apellidos)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $apellidos)) {
                $apellidos = str_replace('*', '%', $apellidos);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(JaUsuariosTableMap::COL_APELLIDOS, $apellidos, $comparison);
    }

    /**
     * Filter the query on the biografia column
     *
     * Example usage:
     * <code>
     * $query->filterByBiografia('fooValue');   // WHERE biografia = 'fooValue'
     * $query->filterByBiografia('%fooValue%'); // WHERE biografia LIKE '%fooValue%'
     * </code>
     *
     * @param     string $biografia The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildJaUsuariosQuery The current query, for fluid interface
     */
    public function filterByBiografia($biografia = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($biografia)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $biografia)) {
                $biografia = str_replace('*', '%', $biografia);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(JaUsuariosTableMap::COL_BIOGRAFIA, $biografia, $comparison);
    }

    /**
     * Filter the query on the correo column
     *
     * Example usage:
     * <code>
     * $query->filterByCorreo('fooValue');   // WHERE correo = 'fooValue'
     * $query->filterByCorreo('%fooValue%'); // WHERE correo LIKE '%fooValue%'
     * </code>
     *
     * @param     string $correo The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildJaUsuariosQuery The current query, for fluid interface
     */
    public function filterByCorreo($correo = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($correo)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $correo)) {
                $correo = str_replace('*', '%', $correo);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(JaUsuariosTableMap::COL_CORREO, $correo, $comparison);
    }

    /**
     * Filter the query on the telefono column
     *
     * Example usage:
     * <code>
     * $query->filterByTelefono('fooValue');   // WHERE telefono = 'fooValue'
     * $query->filterByTelefono('%fooValue%'); // WHERE telefono LIKE '%fooValue%'
     * </code>
     *
     * @param     string $telefono The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildJaUsuariosQuery The current query, for fluid interface
     */
    public function filterByTelefono($telefono = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($telefono)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $telefono)) {
                $telefono = str_replace('*', '%', $telefono);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(JaUsuariosTableMap::COL_TELEFONO, $telefono, $comparison);
    }

    /**
     * Filter the query on the redessociales column
     *
     * Example usage:
     * <code>
     * $query->filterByRedessociales('fooValue');   // WHERE redessociales = 'fooValue'
     * $query->filterByRedessociales('%fooValue%'); // WHERE redessociales LIKE '%fooValue%'
     * </code>
     *
     * @param     string $redessociales The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildJaUsuariosQuery The current query, for fluid interface
     */
    public function filterByRedessociales($redessociales = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($redessociales)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $redessociales)) {
                $redessociales = str_replace('*', '%', $redessociales);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(JaUsuariosTableMap::COL_REDESSOCIALES, $redessociales, $comparison);
    }

    /**
     * Filter the query on the clave column
     *
     * Example usage:
     * <code>
     * $query->filterByClave('fooValue');   // WHERE clave = 'fooValue'
     * $query->filterByClave('%fooValue%'); // WHERE clave LIKE '%fooValue%'
     * </code>
     *
     * @param     string $clave The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildJaUsuariosQuery The current query, for fluid interface
     */
    public function filterByClave($clave = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($clave)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $clave)) {
                $clave = str_replace('*', '%', $clave);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(JaUsuariosTableMap::COL_CLAVE, $clave, $comparison);
    }

    /**
     * Filter the query on the direccion column
     *
     * Example usage:
     * <code>
     * $query->filterByDireccion('fooValue');   // WHERE direccion = 'fooValue'
     * $query->filterByDireccion('%fooValue%'); // WHERE direccion LIKE '%fooValue%'
     * </code>
     *
     * @param     string $direccion The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildJaUsuariosQuery The current query, for fluid interface
     */
    public function filterByDireccion($direccion = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($direccion)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $direccion)) {
                $direccion = str_replace('*', '%', $direccion);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(JaUsuariosTableMap::COL_DIRECCION, $direccion, $comparison);
    }

    /**
     * Filter the query on the ciudad column
     *
     * Example usage:
     * <code>
     * $query->filterByCiudad('fooValue');   // WHERE ciudad = 'fooValue'
     * $query->filterByCiudad('%fooValue%'); // WHERE ciudad LIKE '%fooValue%'
     * </code>
     *
     * @param     string $ciudad The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildJaUsuariosQuery The current query, for fluid interface
     */
    public function filterByCiudad($ciudad = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($ciudad)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $ciudad)) {
                $ciudad = str_replace('*', '%', $ciudad);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(JaUsuariosTableMap::COL_CIUDAD, $ciudad, $comparison);
    }

    /**
     * Filter the query on the pais column
     *
     * Example usage:
     * <code>
     * $query->filterByPais('fooValue');   // WHERE pais = 'fooValue'
     * $query->filterByPais('%fooValue%'); // WHERE pais LIKE '%fooValue%'
     * </code>
     *
     * @param     string $pais The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildJaUsuariosQuery The current query, for fluid interface
     */
    public function filterByPais($pais = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($pais)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $pais)) {
                $pais = str_replace('*', '%', $pais);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(JaUsuariosTableMap::COL_PAIS, $pais, $comparison);
    }

    /**
     * Filter the query on the fechacreado column
     *
     * Example usage:
     * <code>
     * $query->filterByFechacreado('2011-03-14'); // WHERE fechacreado = '2011-03-14'
     * $query->filterByFechacreado('now'); // WHERE fechacreado = '2011-03-14'
     * $query->filterByFechacreado(array('max' => 'yesterday')); // WHERE fechacreado > '2011-03-13'
     * </code>
     *
     * @param     mixed $fechacreado The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildJaUsuariosQuery The current query, for fluid interface
     */
    public function filterByFechacreado($fechacreado = null, $comparison = null)
    {
        if (is_array($fechacreado)) {
            $useMinMax = false;
            if (isset($fechacreado['min'])) {
                $this->addUsingAlias(JaUsuariosTableMap::COL_FECHACREADO, $fechacreado['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($fechacreado['max'])) {
                $this->addUsingAlias(JaUsuariosTableMap::COL_FECHACREADO, $fechacreado['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(JaUsuariosTableMap::COL_FECHACREADO, $fechacreado, $comparison);
    }

    /**
     * Filter the query by a related \JaAclUsuariosPerfiles object
     *
     * @param \JaAclUsuariosPerfiles|ObjectCollection $jaAclUsuariosPerfiles the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildJaUsuariosQuery The current query, for fluid interface
     */
    public function filterByJaAclUsuariosPerfiles($jaAclUsuariosPerfiles, $comparison = null)
    {
        if ($jaAclUsuariosPerfiles instanceof \JaAclUsuariosPerfiles) {
            return $this
                ->addUsingAlias(JaUsuariosTableMap::COL_ID, $jaAclUsuariosPerfiles->getUsuarioId(), $comparison);
        } elseif ($jaAclUsuariosPerfiles instanceof ObjectCollection) {
            return $this
                ->useJaAclUsuariosPerfilesQuery()
                ->filterByPrimaryKeys($jaAclUsuariosPerfiles->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByJaAclUsuariosPerfiles() only accepts arguments of type \JaAclUsuariosPerfiles or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the JaAclUsuariosPerfiles relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildJaUsuariosQuery The current query, for fluid interface
     */
    public function joinJaAclUsuariosPerfiles($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('JaAclUsuariosPerfiles');

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
            $this->addJoinObject($join, 'JaAclUsuariosPerfiles');
        }

        return $this;
    }

    /**
     * Use the JaAclUsuariosPerfiles relation JaAclUsuariosPerfiles object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \JaAclUsuariosPerfilesQuery A secondary query class using the current class as primary query
     */
    public function useJaAclUsuariosPerfilesQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinJaAclUsuariosPerfiles($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'JaAclUsuariosPerfiles', '\JaAclUsuariosPerfilesQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildJaUsuarios $jaUsuarios Object to remove from the list of results
     *
     * @return $this|ChildJaUsuariosQuery The current query, for fluid interface
     */
    public function prune($jaUsuarios = null)
    {
        if ($jaUsuarios) {
            $this->addUsingAlias(JaUsuariosTableMap::COL_ID, $jaUsuarios->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the ja_usuarios table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(JaUsuariosTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            JaUsuariosTableMap::clearInstancePool();
            JaUsuariosTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(JaUsuariosTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(JaUsuariosTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            
            JaUsuariosTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            JaUsuariosTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // JaUsuariosQuery
