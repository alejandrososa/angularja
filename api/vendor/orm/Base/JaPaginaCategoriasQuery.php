<?php

namespace Base;

use \JaPaginaCategorias as ChildJaPaginaCategorias;
use \JaPaginaCategoriasQuery as ChildJaPaginaCategoriasQuery;
use \Exception;
use \PDO;
use Map\JaPaginaCategoriasTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'ja_pagina_categorias' table.
 *
 * 
 *
 * @method     ChildJaPaginaCategoriasQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildJaPaginaCategoriasQuery orderByIdPagina($order = Criteria::ASC) Order by the id_pagina column
 * @method     ChildJaPaginaCategoriasQuery orderByIdCategoria($order = Criteria::ASC) Order by the id_categoria column
 *
 * @method     ChildJaPaginaCategoriasQuery groupById() Group by the id column
 * @method     ChildJaPaginaCategoriasQuery groupByIdPagina() Group by the id_pagina column
 * @method     ChildJaPaginaCategoriasQuery groupByIdCategoria() Group by the id_categoria column
 *
 * @method     ChildJaPaginaCategoriasQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildJaPaginaCategoriasQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildJaPaginaCategoriasQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildJaPaginaCategoriasQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildJaPaginaCategoriasQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildJaPaginaCategoriasQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildJaPaginaCategoriasQuery leftJoinJaCategorias($relationAlias = null) Adds a LEFT JOIN clause to the query using the JaCategorias relation
 * @method     ChildJaPaginaCategoriasQuery rightJoinJaCategorias($relationAlias = null) Adds a RIGHT JOIN clause to the query using the JaCategorias relation
 * @method     ChildJaPaginaCategoriasQuery innerJoinJaCategorias($relationAlias = null) Adds a INNER JOIN clause to the query using the JaCategorias relation
 *
 * @method     ChildJaPaginaCategoriasQuery joinWithJaCategorias($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the JaCategorias relation
 *
 * @method     ChildJaPaginaCategoriasQuery leftJoinWithJaCategorias() Adds a LEFT JOIN clause and with to the query using the JaCategorias relation
 * @method     ChildJaPaginaCategoriasQuery rightJoinWithJaCategorias() Adds a RIGHT JOIN clause and with to the query using the JaCategorias relation
 * @method     ChildJaPaginaCategoriasQuery innerJoinWithJaCategorias() Adds a INNER JOIN clause and with to the query using the JaCategorias relation
 *
 * @method     ChildJaPaginaCategoriasQuery leftJoinJaPaginas($relationAlias = null) Adds a LEFT JOIN clause to the query using the JaPaginas relation
 * @method     ChildJaPaginaCategoriasQuery rightJoinJaPaginas($relationAlias = null) Adds a RIGHT JOIN clause to the query using the JaPaginas relation
 * @method     ChildJaPaginaCategoriasQuery innerJoinJaPaginas($relationAlias = null) Adds a INNER JOIN clause to the query using the JaPaginas relation
 *
 * @method     ChildJaPaginaCategoriasQuery joinWithJaPaginas($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the JaPaginas relation
 *
 * @method     ChildJaPaginaCategoriasQuery leftJoinWithJaPaginas() Adds a LEFT JOIN clause and with to the query using the JaPaginas relation
 * @method     ChildJaPaginaCategoriasQuery rightJoinWithJaPaginas() Adds a RIGHT JOIN clause and with to the query using the JaPaginas relation
 * @method     ChildJaPaginaCategoriasQuery innerJoinWithJaPaginas() Adds a INNER JOIN clause and with to the query using the JaPaginas relation
 *
 * @method     \JaCategoriasQuery|\JaPaginasQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildJaPaginaCategorias findOne(ConnectionInterface $con = null) Return the first ChildJaPaginaCategorias matching the query
 * @method     ChildJaPaginaCategorias findOneOrCreate(ConnectionInterface $con = null) Return the first ChildJaPaginaCategorias matching the query, or a new ChildJaPaginaCategorias object populated from the query conditions when no match is found
 *
 * @method     ChildJaPaginaCategorias findOneById(int $id) Return the first ChildJaPaginaCategorias filtered by the id column
 * @method     ChildJaPaginaCategorias findOneByIdPagina(int $id_pagina) Return the first ChildJaPaginaCategorias filtered by the id_pagina column
 * @method     ChildJaPaginaCategorias findOneByIdCategoria(int $id_categoria) Return the first ChildJaPaginaCategorias filtered by the id_categoria column *

 * @method     ChildJaPaginaCategorias requirePk($key, ConnectionInterface $con = null) Return the ChildJaPaginaCategorias by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildJaPaginaCategorias requireOne(ConnectionInterface $con = null) Return the first ChildJaPaginaCategorias matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildJaPaginaCategorias requireOneById(int $id) Return the first ChildJaPaginaCategorias filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildJaPaginaCategorias requireOneByIdPagina(int $id_pagina) Return the first ChildJaPaginaCategorias filtered by the id_pagina column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildJaPaginaCategorias requireOneByIdCategoria(int $id_categoria) Return the first ChildJaPaginaCategorias filtered by the id_categoria column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildJaPaginaCategorias[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildJaPaginaCategorias objects based on current ModelCriteria
 * @method     ChildJaPaginaCategorias[]|ObjectCollection findById(int $id) Return ChildJaPaginaCategorias objects filtered by the id column
 * @method     ChildJaPaginaCategorias[]|ObjectCollection findByIdPagina(int $id_pagina) Return ChildJaPaginaCategorias objects filtered by the id_pagina column
 * @method     ChildJaPaginaCategorias[]|ObjectCollection findByIdCategoria(int $id_categoria) Return ChildJaPaginaCategorias objects filtered by the id_categoria column
 * @method     ChildJaPaginaCategorias[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class JaPaginaCategoriasQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\JaPaginaCategoriasQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\JaPaginaCategorias', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildJaPaginaCategoriasQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildJaPaginaCategoriasQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildJaPaginaCategoriasQuery) {
            return $criteria;
        }
        $query = new ChildJaPaginaCategoriasQuery();
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
     * @return ChildJaPaginaCategorias|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = JaPaginaCategoriasTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(JaPaginaCategoriasTableMap::DATABASE_NAME);
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
     * @return ChildJaPaginaCategorias A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, id_pagina, id_categoria FROM ja_pagina_categorias WHERE id = :p0';
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
            /** @var ChildJaPaginaCategorias $obj */
            $obj = new ChildJaPaginaCategorias();
            $obj->hydrate($row);
            JaPaginaCategoriasTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildJaPaginaCategorias|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildJaPaginaCategoriasQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(JaPaginaCategoriasTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildJaPaginaCategoriasQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(JaPaginaCategoriasTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildJaPaginaCategoriasQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(JaPaginaCategoriasTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(JaPaginaCategoriasTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(JaPaginaCategoriasTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the id_pagina column
     *
     * Example usage:
     * <code>
     * $query->filterByIdPagina(1234); // WHERE id_pagina = 1234
     * $query->filterByIdPagina(array(12, 34)); // WHERE id_pagina IN (12, 34)
     * $query->filterByIdPagina(array('min' => 12)); // WHERE id_pagina > 12
     * </code>
     *
     * @see       filterByJaPaginas()
     *
     * @param     mixed $idPagina The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildJaPaginaCategoriasQuery The current query, for fluid interface
     */
    public function filterByIdPagina($idPagina = null, $comparison = null)
    {
        if (is_array($idPagina)) {
            $useMinMax = false;
            if (isset($idPagina['min'])) {
                $this->addUsingAlias(JaPaginaCategoriasTableMap::COL_ID_PAGINA, $idPagina['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idPagina['max'])) {
                $this->addUsingAlias(JaPaginaCategoriasTableMap::COL_ID_PAGINA, $idPagina['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(JaPaginaCategoriasTableMap::COL_ID_PAGINA, $idPagina, $comparison);
    }

    /**
     * Filter the query on the id_categoria column
     *
     * Example usage:
     * <code>
     * $query->filterByIdCategoria(1234); // WHERE id_categoria = 1234
     * $query->filterByIdCategoria(array(12, 34)); // WHERE id_categoria IN (12, 34)
     * $query->filterByIdCategoria(array('min' => 12)); // WHERE id_categoria > 12
     * </code>
     *
     * @see       filterByJaCategorias()
     *
     * @param     mixed $idCategoria The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildJaPaginaCategoriasQuery The current query, for fluid interface
     */
    public function filterByIdCategoria($idCategoria = null, $comparison = null)
    {
        if (is_array($idCategoria)) {
            $useMinMax = false;
            if (isset($idCategoria['min'])) {
                $this->addUsingAlias(JaPaginaCategoriasTableMap::COL_ID_CATEGORIA, $idCategoria['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idCategoria['max'])) {
                $this->addUsingAlias(JaPaginaCategoriasTableMap::COL_ID_CATEGORIA, $idCategoria['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(JaPaginaCategoriasTableMap::COL_ID_CATEGORIA, $idCategoria, $comparison);
    }

    /**
     * Filter the query by a related \JaCategorias object
     *
     * @param \JaCategorias|ObjectCollection $jaCategorias The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildJaPaginaCategoriasQuery The current query, for fluid interface
     */
    public function filterByJaCategorias($jaCategorias, $comparison = null)
    {
        if ($jaCategorias instanceof \JaCategorias) {
            return $this
                ->addUsingAlias(JaPaginaCategoriasTableMap::COL_ID_CATEGORIA, $jaCategorias->getId(), $comparison);
        } elseif ($jaCategorias instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(JaPaginaCategoriasTableMap::COL_ID_CATEGORIA, $jaCategorias->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByJaCategorias() only accepts arguments of type \JaCategorias or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the JaCategorias relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildJaPaginaCategoriasQuery The current query, for fluid interface
     */
    public function joinJaCategorias($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('JaCategorias');

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
            $this->addJoinObject($join, 'JaCategorias');
        }

        return $this;
    }

    /**
     * Use the JaCategorias relation JaCategorias object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \JaCategoriasQuery A secondary query class using the current class as primary query
     */
    public function useJaCategoriasQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinJaCategorias($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'JaCategorias', '\JaCategoriasQuery');
    }

    /**
     * Filter the query by a related \JaPaginas object
     *
     * @param \JaPaginas|ObjectCollection $jaPaginas The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildJaPaginaCategoriasQuery The current query, for fluid interface
     */
    public function filterByJaPaginas($jaPaginas, $comparison = null)
    {
        if ($jaPaginas instanceof \JaPaginas) {
            return $this
                ->addUsingAlias(JaPaginaCategoriasTableMap::COL_ID_PAGINA, $jaPaginas->getId(), $comparison);
        } elseif ($jaPaginas instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(JaPaginaCategoriasTableMap::COL_ID_PAGINA, $jaPaginas->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByJaPaginas() only accepts arguments of type \JaPaginas or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the JaPaginas relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildJaPaginaCategoriasQuery The current query, for fluid interface
     */
    public function joinJaPaginas($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('JaPaginas');

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
            $this->addJoinObject($join, 'JaPaginas');
        }

        return $this;
    }

    /**
     * Use the JaPaginas relation JaPaginas object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \JaPaginasQuery A secondary query class using the current class as primary query
     */
    public function useJaPaginasQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinJaPaginas($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'JaPaginas', '\JaPaginasQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildJaPaginaCategorias $jaPaginaCategorias Object to remove from the list of results
     *
     * @return $this|ChildJaPaginaCategoriasQuery The current query, for fluid interface
     */
    public function prune($jaPaginaCategorias = null)
    {
        if ($jaPaginaCategorias) {
            $this->addUsingAlias(JaPaginaCategoriasTableMap::COL_ID, $jaPaginaCategorias->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the ja_pagina_categorias table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(JaPaginaCategoriasTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            JaPaginaCategoriasTableMap::clearInstancePool();
            JaPaginaCategoriasTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(JaPaginaCategoriasTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(JaPaginaCategoriasTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            
            JaPaginaCategoriasTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            JaPaginaCategoriasTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // JaPaginaCategoriasQuery
