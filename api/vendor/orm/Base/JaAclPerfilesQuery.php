<?php

namespace Base;

use \JaAclPerfiles as ChildJaAclPerfiles;
use \JaAclPerfilesQuery as ChildJaAclPerfilesQuery;
use \Exception;
use \PDO;
use Map\JaAclPerfilesTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'ja_acl_perfiles' table.
 *
 * 
 *
 * @method     ChildJaAclPerfilesQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildJaAclPerfilesQuery orderByNombre($order = Criteria::ASC) Order by the nombre column
 * @method     ChildJaAclPerfilesQuery orderByFechaRegistro($order = Criteria::ASC) Order by the fecha_registro column
 *
 * @method     ChildJaAclPerfilesQuery groupById() Group by the id column
 * @method     ChildJaAclPerfilesQuery groupByNombre() Group by the nombre column
 * @method     ChildJaAclPerfilesQuery groupByFechaRegistro() Group by the fecha_registro column
 *
 * @method     ChildJaAclPerfilesQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildJaAclPerfilesQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildJaAclPerfilesQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildJaAclPerfilesQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildJaAclPerfilesQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildJaAclPerfilesQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildJaAclPerfilesQuery leftJoinJaAclPerfilesRecursos($relationAlias = null) Adds a LEFT JOIN clause to the query using the JaAclPerfilesRecursos relation
 * @method     ChildJaAclPerfilesQuery rightJoinJaAclPerfilesRecursos($relationAlias = null) Adds a RIGHT JOIN clause to the query using the JaAclPerfilesRecursos relation
 * @method     ChildJaAclPerfilesQuery innerJoinJaAclPerfilesRecursos($relationAlias = null) Adds a INNER JOIN clause to the query using the JaAclPerfilesRecursos relation
 *
 * @method     ChildJaAclPerfilesQuery joinWithJaAclPerfilesRecursos($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the JaAclPerfilesRecursos relation
 *
 * @method     ChildJaAclPerfilesQuery leftJoinWithJaAclPerfilesRecursos() Adds a LEFT JOIN clause and with to the query using the JaAclPerfilesRecursos relation
 * @method     ChildJaAclPerfilesQuery rightJoinWithJaAclPerfilesRecursos() Adds a RIGHT JOIN clause and with to the query using the JaAclPerfilesRecursos relation
 * @method     ChildJaAclPerfilesQuery innerJoinWithJaAclPerfilesRecursos() Adds a INNER JOIN clause and with to the query using the JaAclPerfilesRecursos relation
 *
 * @method     ChildJaAclPerfilesQuery leftJoinJaAclUsuariosPerfiles($relationAlias = null) Adds a LEFT JOIN clause to the query using the JaAclUsuariosPerfiles relation
 * @method     ChildJaAclPerfilesQuery rightJoinJaAclUsuariosPerfiles($relationAlias = null) Adds a RIGHT JOIN clause to the query using the JaAclUsuariosPerfiles relation
 * @method     ChildJaAclPerfilesQuery innerJoinJaAclUsuariosPerfiles($relationAlias = null) Adds a INNER JOIN clause to the query using the JaAclUsuariosPerfiles relation
 *
 * @method     ChildJaAclPerfilesQuery joinWithJaAclUsuariosPerfiles($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the JaAclUsuariosPerfiles relation
 *
 * @method     ChildJaAclPerfilesQuery leftJoinWithJaAclUsuariosPerfiles() Adds a LEFT JOIN clause and with to the query using the JaAclUsuariosPerfiles relation
 * @method     ChildJaAclPerfilesQuery rightJoinWithJaAclUsuariosPerfiles() Adds a RIGHT JOIN clause and with to the query using the JaAclUsuariosPerfiles relation
 * @method     ChildJaAclPerfilesQuery innerJoinWithJaAclUsuariosPerfiles() Adds a INNER JOIN clause and with to the query using the JaAclUsuariosPerfiles relation
 *
 * @method     \JaAclPerfilesRecursosQuery|\JaAclUsuariosPerfilesQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildJaAclPerfiles findOne(ConnectionInterface $con = null) Return the first ChildJaAclPerfiles matching the query
 * @method     ChildJaAclPerfiles findOneOrCreate(ConnectionInterface $con = null) Return the first ChildJaAclPerfiles matching the query, or a new ChildJaAclPerfiles object populated from the query conditions when no match is found
 *
 * @method     ChildJaAclPerfiles findOneById(int $id) Return the first ChildJaAclPerfiles filtered by the id column
 * @method     ChildJaAclPerfiles findOneByNombre(string $nombre) Return the first ChildJaAclPerfiles filtered by the nombre column
 * @method     ChildJaAclPerfiles findOneByFechaRegistro(string $fecha_registro) Return the first ChildJaAclPerfiles filtered by the fecha_registro column *

 * @method     ChildJaAclPerfiles requirePk($key, ConnectionInterface $con = null) Return the ChildJaAclPerfiles by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildJaAclPerfiles requireOne(ConnectionInterface $con = null) Return the first ChildJaAclPerfiles matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildJaAclPerfiles requireOneById(int $id) Return the first ChildJaAclPerfiles filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildJaAclPerfiles requireOneByNombre(string $nombre) Return the first ChildJaAclPerfiles filtered by the nombre column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildJaAclPerfiles requireOneByFechaRegistro(string $fecha_registro) Return the first ChildJaAclPerfiles filtered by the fecha_registro column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildJaAclPerfiles[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildJaAclPerfiles objects based on current ModelCriteria
 * @method     ChildJaAclPerfiles[]|ObjectCollection findById(int $id) Return ChildJaAclPerfiles objects filtered by the id column
 * @method     ChildJaAclPerfiles[]|ObjectCollection findByNombre(string $nombre) Return ChildJaAclPerfiles objects filtered by the nombre column
 * @method     ChildJaAclPerfiles[]|ObjectCollection findByFechaRegistro(string $fecha_registro) Return ChildJaAclPerfiles objects filtered by the fecha_registro column
 * @method     ChildJaAclPerfiles[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class JaAclPerfilesQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\JaAclPerfilesQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\JaAclPerfiles', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildJaAclPerfilesQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildJaAclPerfilesQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildJaAclPerfilesQuery) {
            return $criteria;
        }
        $query = new ChildJaAclPerfilesQuery();
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
     * @return ChildJaAclPerfiles|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = JaAclPerfilesTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(JaAclPerfilesTableMap::DATABASE_NAME);
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
     * @return ChildJaAclPerfiles A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, nombre, fecha_registro FROM ja_acl_perfiles WHERE id = :p0';
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
            /** @var ChildJaAclPerfiles $obj */
            $obj = new ChildJaAclPerfiles();
            $obj->hydrate($row);
            JaAclPerfilesTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildJaAclPerfiles|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildJaAclPerfilesQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(JaAclPerfilesTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildJaAclPerfilesQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(JaAclPerfilesTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildJaAclPerfilesQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(JaAclPerfilesTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(JaAclPerfilesTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(JaAclPerfilesTableMap::COL_ID, $id, $comparison);
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
     * @return $this|ChildJaAclPerfilesQuery The current query, for fluid interface
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

        return $this->addUsingAlias(JaAclPerfilesTableMap::COL_NOMBRE, $nombre, $comparison);
    }

    /**
     * Filter the query on the fecha_registro column
     *
     * Example usage:
     * <code>
     * $query->filterByFechaRegistro('2011-03-14'); // WHERE fecha_registro = '2011-03-14'
     * $query->filterByFechaRegistro('now'); // WHERE fecha_registro = '2011-03-14'
     * $query->filterByFechaRegistro(array('max' => 'yesterday')); // WHERE fecha_registro > '2011-03-13'
     * </code>
     *
     * @param     mixed $fechaRegistro The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildJaAclPerfilesQuery The current query, for fluid interface
     */
    public function filterByFechaRegistro($fechaRegistro = null, $comparison = null)
    {
        if (is_array($fechaRegistro)) {
            $useMinMax = false;
            if (isset($fechaRegistro['min'])) {
                $this->addUsingAlias(JaAclPerfilesTableMap::COL_FECHA_REGISTRO, $fechaRegistro['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($fechaRegistro['max'])) {
                $this->addUsingAlias(JaAclPerfilesTableMap::COL_FECHA_REGISTRO, $fechaRegistro['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(JaAclPerfilesTableMap::COL_FECHA_REGISTRO, $fechaRegistro, $comparison);
    }

    /**
     * Filter the query by a related \JaAclPerfilesRecursos object
     *
     * @param \JaAclPerfilesRecursos|ObjectCollection $jaAclPerfilesRecursos the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildJaAclPerfilesQuery The current query, for fluid interface
     */
    public function filterByJaAclPerfilesRecursos($jaAclPerfilesRecursos, $comparison = null)
    {
        if ($jaAclPerfilesRecursos instanceof \JaAclPerfilesRecursos) {
            return $this
                ->addUsingAlias(JaAclPerfilesTableMap::COL_ID, $jaAclPerfilesRecursos->getPerfilId(), $comparison);
        } elseif ($jaAclPerfilesRecursos instanceof ObjectCollection) {
            return $this
                ->useJaAclPerfilesRecursosQuery()
                ->filterByPrimaryKeys($jaAclPerfilesRecursos->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByJaAclPerfilesRecursos() only accepts arguments of type \JaAclPerfilesRecursos or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the JaAclPerfilesRecursos relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildJaAclPerfilesQuery The current query, for fluid interface
     */
    public function joinJaAclPerfilesRecursos($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('JaAclPerfilesRecursos');

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
            $this->addJoinObject($join, 'JaAclPerfilesRecursos');
        }

        return $this;
    }

    /**
     * Use the JaAclPerfilesRecursos relation JaAclPerfilesRecursos object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \JaAclPerfilesRecursosQuery A secondary query class using the current class as primary query
     */
    public function useJaAclPerfilesRecursosQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinJaAclPerfilesRecursos($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'JaAclPerfilesRecursos', '\JaAclPerfilesRecursosQuery');
    }

    /**
     * Filter the query by a related \JaAclUsuariosPerfiles object
     *
     * @param \JaAclUsuariosPerfiles|ObjectCollection $jaAclUsuariosPerfiles the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildJaAclPerfilesQuery The current query, for fluid interface
     */
    public function filterByJaAclUsuariosPerfiles($jaAclUsuariosPerfiles, $comparison = null)
    {
        if ($jaAclUsuariosPerfiles instanceof \JaAclUsuariosPerfiles) {
            return $this
                ->addUsingAlias(JaAclPerfilesTableMap::COL_ID, $jaAclUsuariosPerfiles->getPerfilId(), $comparison);
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
     * @return $this|ChildJaAclPerfilesQuery The current query, for fluid interface
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
     * @param   ChildJaAclPerfiles $jaAclPerfiles Object to remove from the list of results
     *
     * @return $this|ChildJaAclPerfilesQuery The current query, for fluid interface
     */
    public function prune($jaAclPerfiles = null)
    {
        if ($jaAclPerfiles) {
            $this->addUsingAlias(JaAclPerfilesTableMap::COL_ID, $jaAclPerfiles->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the ja_acl_perfiles table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(JaAclPerfilesTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            JaAclPerfilesTableMap::clearInstancePool();
            JaAclPerfilesTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(JaAclPerfilesTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(JaAclPerfilesTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            
            JaAclPerfilesTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            JaAclPerfilesTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // JaAclPerfilesQuery
