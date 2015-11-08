<?php

namespace Base;

use \JaAclPerfilesRecursos as ChildJaAclPerfilesRecursos;
use \JaAclPerfilesRecursosQuery as ChildJaAclPerfilesRecursosQuery;
use \Exception;
use Map\JaAclPerfilesRecursosTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'ja_acl_perfiles_recursos' table.
 *
 * 
 *
 * @method     ChildJaAclPerfilesRecursosQuery orderByConsultar($order = Criteria::ASC) Order by the consultar column
 * @method     ChildJaAclPerfilesRecursosQuery orderByAgregar($order = Criteria::ASC) Order by the agregar column
 * @method     ChildJaAclPerfilesRecursosQuery orderByEditar($order = Criteria::ASC) Order by the editar column
 * @method     ChildJaAclPerfilesRecursosQuery orderByEliminar($order = Criteria::ASC) Order by the eliminar column
 * @method     ChildJaAclPerfilesRecursosQuery orderByRecursoId($order = Criteria::ASC) Order by the recurso_id column
 * @method     ChildJaAclPerfilesRecursosQuery orderByPerfilId($order = Criteria::ASC) Order by the perfil_id column
 *
 * @method     ChildJaAclPerfilesRecursosQuery groupByConsultar() Group by the consultar column
 * @method     ChildJaAclPerfilesRecursosQuery groupByAgregar() Group by the agregar column
 * @method     ChildJaAclPerfilesRecursosQuery groupByEditar() Group by the editar column
 * @method     ChildJaAclPerfilesRecursosQuery groupByEliminar() Group by the eliminar column
 * @method     ChildJaAclPerfilesRecursosQuery groupByRecursoId() Group by the recurso_id column
 * @method     ChildJaAclPerfilesRecursosQuery groupByPerfilId() Group by the perfil_id column
 *
 * @method     ChildJaAclPerfilesRecursosQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildJaAclPerfilesRecursosQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildJaAclPerfilesRecursosQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildJaAclPerfilesRecursosQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildJaAclPerfilesRecursosQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildJaAclPerfilesRecursosQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildJaAclPerfilesRecursosQuery leftJoinJaAclPerfiles($relationAlias = null) Adds a LEFT JOIN clause to the query using the JaAclPerfiles relation
 * @method     ChildJaAclPerfilesRecursosQuery rightJoinJaAclPerfiles($relationAlias = null) Adds a RIGHT JOIN clause to the query using the JaAclPerfiles relation
 * @method     ChildJaAclPerfilesRecursosQuery innerJoinJaAclPerfiles($relationAlias = null) Adds a INNER JOIN clause to the query using the JaAclPerfiles relation
 *
 * @method     ChildJaAclPerfilesRecursosQuery joinWithJaAclPerfiles($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the JaAclPerfiles relation
 *
 * @method     ChildJaAclPerfilesRecursosQuery leftJoinWithJaAclPerfiles() Adds a LEFT JOIN clause and with to the query using the JaAclPerfiles relation
 * @method     ChildJaAclPerfilesRecursosQuery rightJoinWithJaAclPerfiles() Adds a RIGHT JOIN clause and with to the query using the JaAclPerfiles relation
 * @method     ChildJaAclPerfilesRecursosQuery innerJoinWithJaAclPerfiles() Adds a INNER JOIN clause and with to the query using the JaAclPerfiles relation
 *
 * @method     ChildJaAclPerfilesRecursosQuery leftJoinJaAclRecursos($relationAlias = null) Adds a LEFT JOIN clause to the query using the JaAclRecursos relation
 * @method     ChildJaAclPerfilesRecursosQuery rightJoinJaAclRecursos($relationAlias = null) Adds a RIGHT JOIN clause to the query using the JaAclRecursos relation
 * @method     ChildJaAclPerfilesRecursosQuery innerJoinJaAclRecursos($relationAlias = null) Adds a INNER JOIN clause to the query using the JaAclRecursos relation
 *
 * @method     ChildJaAclPerfilesRecursosQuery joinWithJaAclRecursos($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the JaAclRecursos relation
 *
 * @method     ChildJaAclPerfilesRecursosQuery leftJoinWithJaAclRecursos() Adds a LEFT JOIN clause and with to the query using the JaAclRecursos relation
 * @method     ChildJaAclPerfilesRecursosQuery rightJoinWithJaAclRecursos() Adds a RIGHT JOIN clause and with to the query using the JaAclRecursos relation
 * @method     ChildJaAclPerfilesRecursosQuery innerJoinWithJaAclRecursos() Adds a INNER JOIN clause and with to the query using the JaAclRecursos relation
 *
 * @method     \JaAclPerfilesQuery|\JaAclRecursosQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildJaAclPerfilesRecursos findOne(ConnectionInterface $con = null) Return the first ChildJaAclPerfilesRecursos matching the query
 * @method     ChildJaAclPerfilesRecursos findOneOrCreate(ConnectionInterface $con = null) Return the first ChildJaAclPerfilesRecursos matching the query, or a new ChildJaAclPerfilesRecursos object populated from the query conditions when no match is found
 *
 * @method     ChildJaAclPerfilesRecursos findOneByConsultar(boolean $consultar) Return the first ChildJaAclPerfilesRecursos filtered by the consultar column
 * @method     ChildJaAclPerfilesRecursos findOneByAgregar(boolean $agregar) Return the first ChildJaAclPerfilesRecursos filtered by the agregar column
 * @method     ChildJaAclPerfilesRecursos findOneByEditar(boolean $editar) Return the first ChildJaAclPerfilesRecursos filtered by the editar column
 * @method     ChildJaAclPerfilesRecursos findOneByEliminar(boolean $eliminar) Return the first ChildJaAclPerfilesRecursos filtered by the eliminar column
 * @method     ChildJaAclPerfilesRecursos findOneByRecursoId(int $recurso_id) Return the first ChildJaAclPerfilesRecursos filtered by the recurso_id column
 * @method     ChildJaAclPerfilesRecursos findOneByPerfilId(int $perfil_id) Return the first ChildJaAclPerfilesRecursos filtered by the perfil_id column *

 * @method     ChildJaAclPerfilesRecursos requirePk($key, ConnectionInterface $con = null) Return the ChildJaAclPerfilesRecursos by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildJaAclPerfilesRecursos requireOne(ConnectionInterface $con = null) Return the first ChildJaAclPerfilesRecursos matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildJaAclPerfilesRecursos requireOneByConsultar(boolean $consultar) Return the first ChildJaAclPerfilesRecursos filtered by the consultar column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildJaAclPerfilesRecursos requireOneByAgregar(boolean $agregar) Return the first ChildJaAclPerfilesRecursos filtered by the agregar column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildJaAclPerfilesRecursos requireOneByEditar(boolean $editar) Return the first ChildJaAclPerfilesRecursos filtered by the editar column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildJaAclPerfilesRecursos requireOneByEliminar(boolean $eliminar) Return the first ChildJaAclPerfilesRecursos filtered by the eliminar column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildJaAclPerfilesRecursos requireOneByRecursoId(int $recurso_id) Return the first ChildJaAclPerfilesRecursos filtered by the recurso_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildJaAclPerfilesRecursos requireOneByPerfilId(int $perfil_id) Return the first ChildJaAclPerfilesRecursos filtered by the perfil_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildJaAclPerfilesRecursos[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildJaAclPerfilesRecursos objects based on current ModelCriteria
 * @method     ChildJaAclPerfilesRecursos[]|ObjectCollection findByConsultar(boolean $consultar) Return ChildJaAclPerfilesRecursos objects filtered by the consultar column
 * @method     ChildJaAclPerfilesRecursos[]|ObjectCollection findByAgregar(boolean $agregar) Return ChildJaAclPerfilesRecursos objects filtered by the agregar column
 * @method     ChildJaAclPerfilesRecursos[]|ObjectCollection findByEditar(boolean $editar) Return ChildJaAclPerfilesRecursos objects filtered by the editar column
 * @method     ChildJaAclPerfilesRecursos[]|ObjectCollection findByEliminar(boolean $eliminar) Return ChildJaAclPerfilesRecursos objects filtered by the eliminar column
 * @method     ChildJaAclPerfilesRecursos[]|ObjectCollection findByRecursoId(int $recurso_id) Return ChildJaAclPerfilesRecursos objects filtered by the recurso_id column
 * @method     ChildJaAclPerfilesRecursos[]|ObjectCollection findByPerfilId(int $perfil_id) Return ChildJaAclPerfilesRecursos objects filtered by the perfil_id column
 * @method     ChildJaAclPerfilesRecursos[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class JaAclPerfilesRecursosQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\JaAclPerfilesRecursosQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\JaAclPerfilesRecursos', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildJaAclPerfilesRecursosQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildJaAclPerfilesRecursosQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildJaAclPerfilesRecursosQuery) {
            return $criteria;
        }
        $query = new ChildJaAclPerfilesRecursosQuery();
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
     * @return ChildJaAclPerfilesRecursos|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        throw new LogicException('The JaAclPerfilesRecursos object has no primary key');
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
        throw new LogicException('The JaAclPerfilesRecursos object has no primary key');
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return $this|ChildJaAclPerfilesRecursosQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        throw new LogicException('The JaAclPerfilesRecursos object has no primary key');
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildJaAclPerfilesRecursosQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        throw new LogicException('The JaAclPerfilesRecursos object has no primary key');
    }

    /**
     * Filter the query on the consultar column
     *
     * Example usage:
     * <code>
     * $query->filterByConsultar(true); // WHERE consultar = true
     * $query->filterByConsultar('yes'); // WHERE consultar = true
     * </code>
     *
     * @param     boolean|string $consultar The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildJaAclPerfilesRecursosQuery The current query, for fluid interface
     */
    public function filterByConsultar($consultar = null, $comparison = null)
    {
        if (is_string($consultar)) {
            $consultar = in_array(strtolower($consultar), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(JaAclPerfilesRecursosTableMap::COL_CONSULTAR, $consultar, $comparison);
    }

    /**
     * Filter the query on the agregar column
     *
     * Example usage:
     * <code>
     * $query->filterByAgregar(true); // WHERE agregar = true
     * $query->filterByAgregar('yes'); // WHERE agregar = true
     * </code>
     *
     * @param     boolean|string $agregar The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildJaAclPerfilesRecursosQuery The current query, for fluid interface
     */
    public function filterByAgregar($agregar = null, $comparison = null)
    {
        if (is_string($agregar)) {
            $agregar = in_array(strtolower($agregar), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(JaAclPerfilesRecursosTableMap::COL_AGREGAR, $agregar, $comparison);
    }

    /**
     * Filter the query on the editar column
     *
     * Example usage:
     * <code>
     * $query->filterByEditar(true); // WHERE editar = true
     * $query->filterByEditar('yes'); // WHERE editar = true
     * </code>
     *
     * @param     boolean|string $editar The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildJaAclPerfilesRecursosQuery The current query, for fluid interface
     */
    public function filterByEditar($editar = null, $comparison = null)
    {
        if (is_string($editar)) {
            $editar = in_array(strtolower($editar), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(JaAclPerfilesRecursosTableMap::COL_EDITAR, $editar, $comparison);
    }

    /**
     * Filter the query on the eliminar column
     *
     * Example usage:
     * <code>
     * $query->filterByEliminar(true); // WHERE eliminar = true
     * $query->filterByEliminar('yes'); // WHERE eliminar = true
     * </code>
     *
     * @param     boolean|string $eliminar The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildJaAclPerfilesRecursosQuery The current query, for fluid interface
     */
    public function filterByEliminar($eliminar = null, $comparison = null)
    {
        if (is_string($eliminar)) {
            $eliminar = in_array(strtolower($eliminar), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(JaAclPerfilesRecursosTableMap::COL_ELIMINAR, $eliminar, $comparison);
    }

    /**
     * Filter the query on the recurso_id column
     *
     * Example usage:
     * <code>
     * $query->filterByRecursoId(1234); // WHERE recurso_id = 1234
     * $query->filterByRecursoId(array(12, 34)); // WHERE recurso_id IN (12, 34)
     * $query->filterByRecursoId(array('min' => 12)); // WHERE recurso_id > 12
     * </code>
     *
     * @see       filterByJaAclRecursos()
     *
     * @param     mixed $recursoId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildJaAclPerfilesRecursosQuery The current query, for fluid interface
     */
    public function filterByRecursoId($recursoId = null, $comparison = null)
    {
        if (is_array($recursoId)) {
            $useMinMax = false;
            if (isset($recursoId['min'])) {
                $this->addUsingAlias(JaAclPerfilesRecursosTableMap::COL_RECURSO_ID, $recursoId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($recursoId['max'])) {
                $this->addUsingAlias(JaAclPerfilesRecursosTableMap::COL_RECURSO_ID, $recursoId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(JaAclPerfilesRecursosTableMap::COL_RECURSO_ID, $recursoId, $comparison);
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
     * @return $this|ChildJaAclPerfilesRecursosQuery The current query, for fluid interface
     */
    public function filterByPerfilId($perfilId = null, $comparison = null)
    {
        if (is_array($perfilId)) {
            $useMinMax = false;
            if (isset($perfilId['min'])) {
                $this->addUsingAlias(JaAclPerfilesRecursosTableMap::COL_PERFIL_ID, $perfilId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($perfilId['max'])) {
                $this->addUsingAlias(JaAclPerfilesRecursosTableMap::COL_PERFIL_ID, $perfilId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(JaAclPerfilesRecursosTableMap::COL_PERFIL_ID, $perfilId, $comparison);
    }

    /**
     * Filter the query by a related \JaAclPerfiles object
     *
     * @param \JaAclPerfiles|ObjectCollection $jaAclPerfiles The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildJaAclPerfilesRecursosQuery The current query, for fluid interface
     */
    public function filterByJaAclPerfiles($jaAclPerfiles, $comparison = null)
    {
        if ($jaAclPerfiles instanceof \JaAclPerfiles) {
            return $this
                ->addUsingAlias(JaAclPerfilesRecursosTableMap::COL_PERFIL_ID, $jaAclPerfiles->getId(), $comparison);
        } elseif ($jaAclPerfiles instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(JaAclPerfilesRecursosTableMap::COL_PERFIL_ID, $jaAclPerfiles->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildJaAclPerfilesRecursosQuery The current query, for fluid interface
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
     * Filter the query by a related \JaAclRecursos object
     *
     * @param \JaAclRecursos|ObjectCollection $jaAclRecursos The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildJaAclPerfilesRecursosQuery The current query, for fluid interface
     */
    public function filterByJaAclRecursos($jaAclRecursos, $comparison = null)
    {
        if ($jaAclRecursos instanceof \JaAclRecursos) {
            return $this
                ->addUsingAlias(JaAclPerfilesRecursosTableMap::COL_RECURSO_ID, $jaAclRecursos->getId(), $comparison);
        } elseif ($jaAclRecursos instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(JaAclPerfilesRecursosTableMap::COL_RECURSO_ID, $jaAclRecursos->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByJaAclRecursos() only accepts arguments of type \JaAclRecursos or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the JaAclRecursos relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildJaAclPerfilesRecursosQuery The current query, for fluid interface
     */
    public function joinJaAclRecursos($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('JaAclRecursos');

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
            $this->addJoinObject($join, 'JaAclRecursos');
        }

        return $this;
    }

    /**
     * Use the JaAclRecursos relation JaAclRecursos object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \JaAclRecursosQuery A secondary query class using the current class as primary query
     */
    public function useJaAclRecursosQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinJaAclRecursos($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'JaAclRecursos', '\JaAclRecursosQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildJaAclPerfilesRecursos $jaAclPerfilesRecursos Object to remove from the list of results
     *
     * @return $this|ChildJaAclPerfilesRecursosQuery The current query, for fluid interface
     */
    public function prune($jaAclPerfilesRecursos = null)
    {
        if ($jaAclPerfilesRecursos) {
            throw new LogicException('JaAclPerfilesRecursos object has no primary key');

        }

        return $this;
    }

    /**
     * Deletes all rows from the ja_acl_perfiles_recursos table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(JaAclPerfilesRecursosTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            JaAclPerfilesRecursosTableMap::clearInstancePool();
            JaAclPerfilesRecursosTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(JaAclPerfilesRecursosTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(JaAclPerfilesRecursosTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            
            JaAclPerfilesRecursosTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            JaAclPerfilesRecursosTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // JaAclPerfilesRecursosQuery
