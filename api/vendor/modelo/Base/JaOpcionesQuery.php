<?php

namespace Base;

use \JaOpciones as ChildJaOpciones;
use \JaOpcionesQuery as ChildJaOpcionesQuery;
use \Exception;
use \PDO;
use Map\JaOpcionesTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'ja_opciones' table.
 *
 * 
 *
 * @method     ChildJaOpcionesQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildJaOpcionesQuery orderByNombre($order = Criteria::ASC) Order by the nombre column
 * @method     ChildJaOpcionesQuery orderByValor($order = Criteria::ASC) Order by the valor column
 * @method     ChildJaOpcionesQuery orderByAutoload($order = Criteria::ASC) Order by the autoload column
 *
 * @method     ChildJaOpcionesQuery groupById() Group by the id column
 * @method     ChildJaOpcionesQuery groupByNombre() Group by the nombre column
 * @method     ChildJaOpcionesQuery groupByValor() Group by the valor column
 * @method     ChildJaOpcionesQuery groupByAutoload() Group by the autoload column
 *
 * @method     ChildJaOpcionesQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildJaOpcionesQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildJaOpcionesQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildJaOpcionesQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildJaOpcionesQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildJaOpcionesQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildJaOpciones findOne(ConnectionInterface $con = null) Return the first ChildJaOpciones matching the query
 * @method     ChildJaOpciones findOneOrCreate(ConnectionInterface $con = null) Return the first ChildJaOpciones matching the query, or a new ChildJaOpciones object populated from the query conditions when no match is found
 *
 * @method     ChildJaOpciones findOneById(string $id) Return the first ChildJaOpciones filtered by the id column
 * @method     ChildJaOpciones findOneByNombre(string $nombre) Return the first ChildJaOpciones filtered by the nombre column
 * @method     ChildJaOpciones findOneByValor(string $valor) Return the first ChildJaOpciones filtered by the valor column
 * @method     ChildJaOpciones findOneByAutoload(string $autoload) Return the first ChildJaOpciones filtered by the autoload column *

 * @method     ChildJaOpciones requirePk($key, ConnectionInterface $con = null) Return the ChildJaOpciones by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildJaOpciones requireOne(ConnectionInterface $con = null) Return the first ChildJaOpciones matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildJaOpciones requireOneById(string $id) Return the first ChildJaOpciones filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildJaOpciones requireOneByNombre(string $nombre) Return the first ChildJaOpciones filtered by the nombre column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildJaOpciones requireOneByValor(string $valor) Return the first ChildJaOpciones filtered by the valor column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildJaOpciones requireOneByAutoload(string $autoload) Return the first ChildJaOpciones filtered by the autoload column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildJaOpciones[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildJaOpciones objects based on current ModelCriteria
 * @method     ChildJaOpciones[]|ObjectCollection findById(string $id) Return ChildJaOpciones objects filtered by the id column
 * @method     ChildJaOpciones[]|ObjectCollection findByNombre(string $nombre) Return ChildJaOpciones objects filtered by the nombre column
 * @method     ChildJaOpciones[]|ObjectCollection findByValor(string $valor) Return ChildJaOpciones objects filtered by the valor column
 * @method     ChildJaOpciones[]|ObjectCollection findByAutoload(string $autoload) Return ChildJaOpciones objects filtered by the autoload column
 * @method     ChildJaOpciones[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class JaOpcionesQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\JaOpcionesQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\JaOpciones', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildJaOpcionesQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildJaOpcionesQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildJaOpcionesQuery) {
            return $criteria;
        }
        $query = new ChildJaOpcionesQuery();
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
     * @return ChildJaOpciones|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = JaOpcionesTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(JaOpcionesTableMap::DATABASE_NAME);
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
     * @return ChildJaOpciones A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, nombre, valor, autoload FROM ja_opciones WHERE id = :p0';
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
            /** @var ChildJaOpciones $obj */
            $obj = new ChildJaOpciones();
            $obj->hydrate($row);
            JaOpcionesTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildJaOpciones|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildJaOpcionesQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(JaOpcionesTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildJaOpcionesQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(JaOpcionesTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildJaOpcionesQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(JaOpcionesTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(JaOpcionesTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(JaOpcionesTableMap::COL_ID, $id, $comparison);
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
     * @return $this|ChildJaOpcionesQuery The current query, for fluid interface
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

        return $this->addUsingAlias(JaOpcionesTableMap::COL_NOMBRE, $nombre, $comparison);
    }

    /**
     * Filter the query on the valor column
     *
     * Example usage:
     * <code>
     * $query->filterByValor('fooValue');   // WHERE valor = 'fooValue'
     * $query->filterByValor('%fooValue%'); // WHERE valor LIKE '%fooValue%'
     * </code>
     *
     * @param     string $valor The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildJaOpcionesQuery The current query, for fluid interface
     */
    public function filterByValor($valor = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($valor)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $valor)) {
                $valor = str_replace('*', '%', $valor);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(JaOpcionesTableMap::COL_VALOR, $valor, $comparison);
    }

    /**
     * Filter the query on the autoload column
     *
     * Example usage:
     * <code>
     * $query->filterByAutoload('fooValue');   // WHERE autoload = 'fooValue'
     * $query->filterByAutoload('%fooValue%'); // WHERE autoload LIKE '%fooValue%'
     * </code>
     *
     * @param     string $autoload The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildJaOpcionesQuery The current query, for fluid interface
     */
    public function filterByAutoload($autoload = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($autoload)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $autoload)) {
                $autoload = str_replace('*', '%', $autoload);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(JaOpcionesTableMap::COL_AUTOLOAD, $autoload, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   ChildJaOpciones $jaOpciones Object to remove from the list of results
     *
     * @return $this|ChildJaOpcionesQuery The current query, for fluid interface
     */
    public function prune($jaOpciones = null)
    {
        if ($jaOpciones) {
            $this->addUsingAlias(JaOpcionesTableMap::COL_ID, $jaOpciones->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the ja_opciones table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(JaOpcionesTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            JaOpcionesTableMap::clearInstancePool();
            JaOpcionesTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(JaOpcionesTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(JaOpcionesTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            
            JaOpcionesTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            JaOpcionesTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // JaOpcionesQuery
