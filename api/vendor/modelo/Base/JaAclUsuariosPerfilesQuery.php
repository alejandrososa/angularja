<?php

namespace Base;

use \JaAclUsuariosPerfiles as ChildJaAclUsuariosPerfiles;
use \JaAclUsuariosPerfilesQuery as ChildJaAclUsuariosPerfilesQuery;
use \Exception;
use Map\JaAclUsuariosPerfilesTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'ja_acl_usuarios_perfiles' table.
 *
 * 
 *
 * @method     ChildJaAclUsuariosPerfilesQuery orderByUsuarioId($order = Criteria::ASC) Order by the usuario_id column
 * @method     ChildJaAclUsuariosPerfilesQuery orderByPerfilId($order = Criteria::ASC) Order by the perfil_id column
 *
 * @method     ChildJaAclUsuariosPerfilesQuery groupByUsuarioId() Group by the usuario_id column
 * @method     ChildJaAclUsuariosPerfilesQuery groupByPerfilId() Group by the perfil_id column
 *
 * @method     ChildJaAclUsuariosPerfilesQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildJaAclUsuariosPerfilesQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildJaAclUsuariosPerfilesQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildJaAclUsuariosPerfilesQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildJaAclUsuariosPerfilesQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildJaAclUsuariosPerfilesQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildJaAclUsuariosPerfilesQuery leftJoinJaAclPerfiles($relationAlias = null) Adds a LEFT JOIN clause to the query using the JaAclPerfiles relation
 * @method     ChildJaAclUsuariosPerfilesQuery rightJoinJaAclPerfiles($relationAlias = null) Adds a RIGHT JOIN clause to the query using the JaAclPerfiles relation
 * @method     ChildJaAclUsuariosPerfilesQuery innerJoinJaAclPerfiles($relationAlias = null) Adds a INNER JOIN clause to the query using the JaAclPerfiles relation
 *
 * @method     ChildJaAclUsuariosPerfilesQuery joinWithJaAclPerfiles($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the JaAclPerfiles relation
 *
 * @method     ChildJaAclUsuariosPerfilesQuery leftJoinWithJaAclPerfiles() Adds a LEFT JOIN clause and with to the query using the JaAclPerfiles relation
 * @method     ChildJaAclUsuariosPerfilesQuery rightJoinWithJaAclPerfiles() Adds a RIGHT JOIN clause and with to the query using the JaAclPerfiles relation
 * @method     ChildJaAclUsuariosPerfilesQuery innerJoinWithJaAclPerfiles() Adds a INNER JOIN clause and with to the query using the JaAclPerfiles relation
 *
 * @method     ChildJaAclUsuariosPerfilesQuery leftJoinJaUsuarios($relationAlias = null) Adds a LEFT JOIN clause to the query using the JaUsuarios relation
 * @method     ChildJaAclUsuariosPerfilesQuery rightJoinJaUsuarios($relationAlias = null) Adds a RIGHT JOIN clause to the query using the JaUsuarios relation
 * @method     ChildJaAclUsuariosPerfilesQuery innerJoinJaUsuarios($relationAlias = null) Adds a INNER JOIN clause to the query using the JaUsuarios relation
 *
 * @method     ChildJaAclUsuariosPerfilesQuery joinWithJaUsuarios($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the JaUsuarios relation
 *
 * @method     ChildJaAclUsuariosPerfilesQuery leftJoinWithJaUsuarios() Adds a LEFT JOIN clause and with to the query using the JaUsuarios relation
 * @method     ChildJaAclUsuariosPerfilesQuery rightJoinWithJaUsuarios() Adds a RIGHT JOIN clause and with to the query using the JaUsuarios relation
 * @method     ChildJaAclUsuariosPerfilesQuery innerJoinWithJaUsuarios() Adds a INNER JOIN clause and with to the query using the JaUsuarios relation
 *
 * @method     \JaAclPerfilesQuery|\JaUsuariosQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildJaAclUsuariosPerfiles findOne(ConnectionInterface $con = null) Return the first ChildJaAclUsuariosPerfiles matching the query
 * @method     ChildJaAclUsuariosPerfiles findOneOrCreate(ConnectionInterface $con = null) Return the first ChildJaAclUsuariosPerfiles matching the query, or a new ChildJaAclUsuariosPerfiles object populated from the query conditions when no match is found
 *
 * @method     ChildJaAclUsuariosPerfiles findOneByUsuarioId(int $usuario_id) Return the first ChildJaAclUsuariosPerfiles filtered by the usuario_id column
 * @method     ChildJaAclUsuariosPerfiles findOneByPerfilId(int $perfil_id) Return the first ChildJaAclUsuariosPerfiles filtered by the perfil_id column *

 * @method     ChildJaAclUsuariosPerfiles requirePk($key, ConnectionInterface $con = null) Return the ChildJaAclUsuariosPerfiles by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildJaAclUsuariosPerfiles requireOne(ConnectionInterface $con = null) Return the first ChildJaAclUsuariosPerfiles matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildJaAclUsuariosPerfiles requireOneByUsuarioId(int $usuario_id) Return the first ChildJaAclUsuariosPerfiles filtered by the usuario_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildJaAclUsuariosPerfiles requireOneByPerfilId(int $perfil_id) Return the first ChildJaAclUsuariosPerfiles filtered by the perfil_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildJaAclUsuariosPerfiles[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildJaAclUsuariosPerfiles objects based on current ModelCriteria
 * @method     ChildJaAclUsuariosPerfiles[]|ObjectCollection findByUsuarioId(int $usuario_id) Return ChildJaAclUsuariosPerfiles objects filtered by the usuario_id column
 * @method     ChildJaAclUsuariosPerfiles[]|ObjectCollection findByPerfilId(int $perfil_id) Return ChildJaAclUsuariosPerfiles objects filtered by the perfil_id column
 * @method     ChildJaAclUsuariosPerfiles[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class JaAclUsuariosPerfilesQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\JaAclUsuariosPerfilesQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\JaAclUsuariosPerfiles', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildJaAclUsuariosPerfilesQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildJaAclUsuariosPerfilesQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildJaAclUsuariosPerfilesQuery) {
            return $criteria;
        }
        $query = new ChildJaAclUsuariosPerfilesQuery();
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
     * @return ChildJaAclUsuariosPerfiles|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        throw new LogicException('The JaAclUsuariosPerfiles object has no primary key');
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(array(12, 56), array(832, 123), array(123, 456)), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ObjectCollection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, ConnectionInterface $con = null)
    {
        throw new LogicException('The JaAclUsuariosPerfiles object has no primary key');
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return $this|ChildJaAclUsuariosPerfilesQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        throw new LogicException('The JaAclUsuariosPerfiles object has no primary key');
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildJaAclUsuariosPerfilesQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        throw new LogicException('The JaAclUsuariosPerfiles object has no primary key');
    }

    /**
     * Filter the query on the usuario_id column
     *
     * Example usage:
     * <code>
     * $query->filterByUsuarioId(1234); // WHERE usuario_id = 1234
     * $query->filterByUsuarioId(array(12, 34)); // WHERE usuario_id IN (12, 34)
     * $query->filterByUsuarioId(array('min' => 12)); // WHERE usuario_id > 12
     * </code>
     *
     * @see       filterByJaUsuarios()
     *
     * @param     mixed $usuarioId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildJaAclUsuariosPerfilesQuery The current query, for fluid interface
     */
    public function filterByUsuarioId($usuarioId = null, $comparison = null)
    {
        if (is_array($usuarioId)) {
            $useMinMax = false;
            if (isset($usuarioId['min'])) {
                $this->addUsingAlias(JaAclUsuariosPerfilesTableMap::COL_USUARIO_ID, $usuarioId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($usuarioId['max'])) {
                $this->addUsingAlias(JaAclUsuariosPerfilesTableMap::COL_USUARIO_ID, $usuarioId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(JaAclUsuariosPerfilesTableMap::COL_USUARIO_ID, $usuarioId, $comparison);
    }

    /**
     * Filter the query on the perfil_id column
     *
     * Example usage:
     * <code>
     * $query->filterByPerfilId(1234); // WHERE perfil_id = 1234
     * $query->filterByPerfilId(array(12, 34)); // WHERE perfil_id IN (12, 34)
     * $query->filterByPerfilId(array('min' => 12)); // WHERE perfil_id > 12
     * </code>
     *
     * @see       filterByJaAclPerfiles()
     *
     * @param     mixed $perfilId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildJaAclUsuariosPerfilesQuery The current query, for fluid interface
     */
    public function filterByPerfilId($perfilId = null, $comparison = null)
    {
        if (is_array($perfilId)) {
            $useMinMax = false;
            if (isset($perfilId['min'])) {
                $this->addUsingAlias(JaAclUsuariosPerfilesTableMap::COL_PERFIL_ID, $perfilId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($perfilId['max'])) {
                $this->addUsingAlias(JaAclUsuariosPerfilesTableMap::COL_PERFIL_ID, $perfilId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(JaAclUsuariosPerfilesTableMap::COL_PERFIL_ID, $perfilId, $comparison);
    }

    /**
     * Filter the query by a related \JaAclPerfiles object
     *
     * @param \JaAclPerfiles|ObjectCollection $jaAclPerfiles The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildJaAclUsuariosPerfilesQuery The current query, for fluid interface
     */
    public function filterByJaAclPerfiles($jaAclPerfiles, $comparison = null)
    {
        if ($jaAclPerfiles instanceof \JaAclPerfiles) {
            return $this
                ->addUsingAlias(JaAclUsuariosPerfilesTableMap::COL_PERFIL_ID, $jaAclPerfiles->getId(), $comparison);
        } elseif ($jaAclPerfiles instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(JaAclUsuariosPerfilesTableMap::COL_PERFIL_ID, $jaAclPerfiles->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByJaAclPerfiles() only accepts arguments of type \JaAclPerfiles or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the JaAclPerfiles relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildJaAclUsuariosPerfilesQuery The current query, for fluid interface
     */
    public function joinJaAclPerfiles($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('JaAclPerfiles');

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
            $this->addJoinObject($join, 'JaAclPerfiles');
        }

        return $this;
    }

    /**
     * Use the JaAclPerfiles relation JaAclPerfiles object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \JaAclPerfilesQuery A secondary query class using the current class as primary query
     */
    public function useJaAclPerfilesQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinJaAclPerfiles($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'JaAclPerfiles', '\JaAclPerfilesQuery');
    }

    /**
     * Filter the query by a related \JaUsuarios object
     *
     * @param \JaUsuarios|ObjectCollection $jaUsuarios The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildJaAclUsuariosPerfilesQuery The current query, for fluid interface
     */
    public function filterByJaUsuarios($jaUsuarios, $comparison = null)
    {
        if ($jaUsuarios instanceof \JaUsuarios) {
            return $this
                ->addUsingAlias(JaAclUsuariosPerfilesTableMap::COL_USUARIO_ID, $jaUsuarios->getId(), $comparison);
        } elseif ($jaUsuarios instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(JaAclUsuariosPerfilesTableMap::COL_USUARIO_ID, $jaUsuarios->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByJaUsuarios() only accepts arguments of type \JaUsuarios or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the JaUsuarios relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildJaAclUsuariosPerfilesQuery The current query, for fluid interface
     */
    public function joinJaUsuarios($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('JaUsuarios');

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
            $this->addJoinObject($join, 'JaUsuarios');
        }

        return $this;
    }

    /**
     * Use the JaUsuarios relation JaUsuarios object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \JaUsuariosQuery A secondary query class using the current class as primary query
     */
    public function useJaUsuariosQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinJaUsuarios($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'JaUsuarios', '\JaUsuariosQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildJaAclUsuariosPerfiles $jaAclUsuariosPerfiles Object to remove from the list of results
     *
     * @return $this|ChildJaAclUsuariosPerfilesQuery The current query, for fluid interface
     */
    public function prune($jaAclUsuariosPerfiles = null)
    {
        if ($jaAclUsuariosPerfiles) {
            throw new LogicException('JaAclUsuariosPerfiles object has no primary key');

        }

        return $this;
    }

    /**
     * Deletes all rows from the ja_acl_usuarios_perfiles table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(JaAclUsuariosPerfilesTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            JaAclUsuariosPerfilesTableMap::clearInstancePool();
            JaAclUsuariosPerfilesTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(JaAclUsuariosPerfilesTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(JaAclUsuariosPerfilesTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            
            JaAclUsuariosPerfilesTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            JaAclUsuariosPerfilesTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // JaAclUsuariosPerfilesQuery
