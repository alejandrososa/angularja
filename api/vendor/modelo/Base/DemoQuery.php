<?php

namespace Base;

use \Demo as ChildDemo;
use \DemoQuery as ChildDemoQuery;
use \Exception;
use \PDO;
use Map\DemoTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'demo' table.
 *
 * 
 *
 * @method     ChildDemoQuery orderByIddemo($order = Criteria::ASC) Order by the iddemo column
 * @method     ChildDemoQuery orderByTitulo($order = Criteria::ASC) Order by the titulo column
 * @method     ChildDemoQuery orderByPrueba($order = Criteria::ASC) Order by the prueba column
 * @method     ChildDemoQuery orderByOtrocampo($order = Criteria::ASC) Order by the otrocampo column
 *
 * @method     ChildDemoQuery groupByIddemo() Group by the iddemo column
 * @method     ChildDemoQuery groupByTitulo() Group by the titulo column
 * @method     ChildDemoQuery groupByPrueba() Group by the prueba column
 * @method     ChildDemoQuery groupByOtrocampo() Group by the otrocampo column
 *
 * @method     ChildDemoQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildDemoQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildDemoQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildDemoQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildDemoQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildDemoQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildDemo findOne(ConnectionInterface $con = null) Return the first ChildDemo matching the query
 * @method     ChildDemo findOneOrCreate(ConnectionInterface $con = null) Return the first ChildDemo matching the query, or a new ChildDemo object populated from the query conditions when no match is found
 *
 * @method     ChildDemo findOneByIddemo(int $iddemo) Return the first ChildDemo filtered by the iddemo column
 * @method     ChildDemo findOneByTitulo(string $titulo) Return the first ChildDemo filtered by the titulo column
 * @method     ChildDemo findOneByPrueba(string $prueba) Return the first ChildDemo filtered by the prueba column
 * @method     ChildDemo findOneByOtrocampo(string $otrocampo) Return the first ChildDemo filtered by the otrocampo column *

 * @method     ChildDemo requirePk($key, ConnectionInterface $con = null) Return the ChildDemo by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDemo requireOne(ConnectionInterface $con = null) Return the first ChildDemo matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildDemo requireOneByIddemo(int $iddemo) Return the first ChildDemo filtered by the iddemo column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDemo requireOneByTitulo(string $titulo) Return the first ChildDemo filtered by the titulo column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDemo requireOneByPrueba(string $prueba) Return the first ChildDemo filtered by the prueba column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDemo requireOneByOtrocampo(string $otrocampo) Return the first ChildDemo filtered by the otrocampo column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildDemo[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildDemo objects based on current ModelCriteria
 * @method     ChildDemo[]|ObjectCollection findByIddemo(int $iddemo) Return ChildDemo objects filtered by the iddemo column
 * @method     ChildDemo[]|ObjectCollection findByTitulo(string $titulo) Return ChildDemo objects filtered by the titulo column
 * @method     ChildDemo[]|ObjectCollection findByPrueba(string $prueba) Return ChildDemo objects filtered by the prueba column
 * @method     ChildDemo[]|ObjectCollection findByOtrocampo(string $otrocampo) Return ChildDemo objects filtered by the otrocampo column
 * @method     ChildDemo[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class DemoQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\DemoQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Demo', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildDemoQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildDemoQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildDemoQuery) {
            return $criteria;
        }
        $query = new ChildDemoQuery();
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
     * @return ChildDemo|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = DemoTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(DemoTableMap::DATABASE_NAME);
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
     * @return ChildDemo A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT iddemo, titulo, prueba, otrocampo FROM demo WHERE iddemo = :p0';
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
            /** @var ChildDemo $obj */
            $obj = new ChildDemo();
            $obj->hydrate($row);
            DemoTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildDemo|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildDemoQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(DemoTableMap::COL_IDDEMO, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildDemoQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(DemoTableMap::COL_IDDEMO, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the iddemo column
     *
     * Example usage:
     * <code>
     * $query->filterByIddemo(1234); // WHERE iddemo = 1234
     * $query->filterByIddemo(array(12, 34)); // WHERE iddemo IN (12, 34)
     * $query->filterByIddemo(array('min' => 12)); // WHERE iddemo > 12
     * </code>
     *
     * @param     mixed $iddemo The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDemoQuery The current query, for fluid interface
     */
    public function filterByIddemo($iddemo = null, $comparison = null)
    {
        if (is_array($iddemo)) {
            $useMinMax = false;
            if (isset($iddemo['min'])) {
                $this->addUsingAlias(DemoTableMap::COL_IDDEMO, $iddemo['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($iddemo['max'])) {
                $this->addUsingAlias(DemoTableMap::COL_IDDEMO, $iddemo['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DemoTableMap::COL_IDDEMO, $iddemo, $comparison);
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
     * @return $this|ChildDemoQuery The current query, for fluid interface
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

        return $this->addUsingAlias(DemoTableMap::COL_TITULO, $titulo, $comparison);
    }

    /**
     * Filter the query on the prueba column
     *
     * Example usage:
     * <code>
     * $query->filterByPrueba('fooValue');   // WHERE prueba = 'fooValue'
     * $query->filterByPrueba('%fooValue%'); // WHERE prueba LIKE '%fooValue%'
     * </code>
     *
     * @param     string $prueba The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDemoQuery The current query, for fluid interface
     */
    public function filterByPrueba($prueba = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($prueba)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $prueba)) {
                $prueba = str_replace('*', '%', $prueba);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(DemoTableMap::COL_PRUEBA, $prueba, $comparison);
    }

    /**
     * Filter the query on the otrocampo column
     *
     * Example usage:
     * <code>
     * $query->filterByOtrocampo('fooValue');   // WHERE otrocampo = 'fooValue'
     * $query->filterByOtrocampo('%fooValue%'); // WHERE otrocampo LIKE '%fooValue%'
     * </code>
     *
     * @param     string $otrocampo The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDemoQuery The current query, for fluid interface
     */
    public function filterByOtrocampo($otrocampo = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($otrocampo)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $otrocampo)) {
                $otrocampo = str_replace('*', '%', $otrocampo);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(DemoTableMap::COL_OTROCAMPO, $otrocampo, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   ChildDemo $demo Object to remove from the list of results
     *
     * @return $this|ChildDemoQuery The current query, for fluid interface
     */
    public function prune($demo = null)
    {
        if ($demo) {
            $this->addUsingAlias(DemoTableMap::COL_IDDEMO, $demo->getIddemo(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the demo table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(DemoTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            DemoTableMap::clearInstancePool();
            DemoTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(DemoTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(DemoTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            
            DemoTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            DemoTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // DemoQuery
