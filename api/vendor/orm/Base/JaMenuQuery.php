<?php

namespace Base;

use \JaMenu as ChildJaMenu;
use \JaMenuQuery as ChildJaMenuQuery;
use \Exception;
use \PDO;
use Map\JaMenuTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'ja_menu' table.
 *
 * 
 *
 * @method     ChildJaMenuQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildJaMenuQuery orderByNombre($order = Criteria::ASC) Order by the nombre column
 * @method     ChildJaMenuQuery orderByClase($order = Criteria::ASC) Order by the clase column
 * @method     ChildJaMenuQuery orderByEnlace($order = Criteria::ASC) Order by the enlace column
 * @method     ChildJaMenuQuery orderByTipoEnlace($order = Criteria::ASC) Order by the tipo_enlace column
 * @method     ChildJaMenuQuery orderByTarget($order = Criteria::ASC) Order by the target column
 * @method     ChildJaMenuQuery orderByPadre($order = Criteria::ASC) Order by the padre column
 * @method     ChildJaMenuQuery orderByCategoria($order = Criteria::ASC) Order by the categoria column
 *
 * @method     ChildJaMenuQuery groupById() Group by the id column
 * @method     ChildJaMenuQuery groupByNombre() Group by the nombre column
 * @method     ChildJaMenuQuery groupByClase() Group by the clase column
 * @method     ChildJaMenuQuery groupByEnlace() Group by the enlace column
 * @method     ChildJaMenuQuery groupByTipoEnlace() Group by the tipo_enlace column
 * @method     ChildJaMenuQuery groupByTarget() Group by the target column
 * @method     ChildJaMenuQuery groupByPadre() Group by the padre column
 * @method     ChildJaMenuQuery groupByCategoria() Group by the categoria column
 *
 * @method     ChildJaMenuQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildJaMenuQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildJaMenuQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildJaMenuQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildJaMenuQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildJaMenuQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildJaMenu findOne(ConnectionInterface $con = null) Return the first ChildJaMenu matching the query
 * @method     ChildJaMenu findOneOrCreate(ConnectionInterface $con = null) Return the first ChildJaMenu matching the query, or a new ChildJaMenu object populated from the query conditions when no match is found
 *
 * @method     ChildJaMenu findOneById(int $id) Return the first ChildJaMenu filtered by the id column
 * @method     ChildJaMenu findOneByNombre(string $nombre) Return the first ChildJaMenu filtered by the nombre column
 * @method     ChildJaMenu findOneByClase(string $clase) Return the first ChildJaMenu filtered by the clase column
 * @method     ChildJaMenu findOneByEnlace(string $enlace) Return the first ChildJaMenu filtered by the enlace column
 * @method     ChildJaMenu findOneByTipoEnlace(string $tipo_enlace) Return the first ChildJaMenu filtered by the tipo_enlace column
 * @method     ChildJaMenu findOneByTarget(string $target) Return the first ChildJaMenu filtered by the target column
 * @method     ChildJaMenu findOneByPadre(int $padre) Return the first ChildJaMenu filtered by the padre column
 * @method     ChildJaMenu findOneByCategoria(string $categoria) Return the first ChildJaMenu filtered by the categoria column *

 * @method     ChildJaMenu requirePk($key, ConnectionInterface $con = null) Return the ChildJaMenu by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildJaMenu requireOne(ConnectionInterface $con = null) Return the first ChildJaMenu matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildJaMenu requireOneById(int $id) Return the first ChildJaMenu filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildJaMenu requireOneByNombre(string $nombre) Return the first ChildJaMenu filtered by the nombre column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildJaMenu requireOneByClase(string $clase) Return the first ChildJaMenu filtered by the clase column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildJaMenu requireOneByEnlace(string $enlace) Return the first ChildJaMenu filtered by the enlace column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildJaMenu requireOneByTipoEnlace(string $tipo_enlace) Return the first ChildJaMenu filtered by the tipo_enlace column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildJaMenu requireOneByTarget(string $target) Return the first ChildJaMenu filtered by the target column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildJaMenu requireOneByPadre(int $padre) Return the first ChildJaMenu filtered by the padre column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildJaMenu requireOneByCategoria(string $categoria) Return the first ChildJaMenu filtered by the categoria column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildJaMenu[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildJaMenu objects based on current ModelCriteria
 * @method     ChildJaMenu[]|ObjectCollection findById(int $id) Return ChildJaMenu objects filtered by the id column
 * @method     ChildJaMenu[]|ObjectCollection findByNombre(string $nombre) Return ChildJaMenu objects filtered by the nombre column
 * @method     ChildJaMenu[]|ObjectCollection findByClase(string $clase) Return ChildJaMenu objects filtered by the clase column
 * @method     ChildJaMenu[]|ObjectCollection findByEnlace(string $enlace) Return ChildJaMenu objects filtered by the enlace column
 * @method     ChildJaMenu[]|ObjectCollection findByTipoEnlace(string $tipo_enlace) Return ChildJaMenu objects filtered by the tipo_enlace column
 * @method     ChildJaMenu[]|ObjectCollection findByTarget(string $target) Return ChildJaMenu objects filtered by the target column
 * @method     ChildJaMenu[]|ObjectCollection findByPadre(int $padre) Return ChildJaMenu objects filtered by the padre column
 * @method     ChildJaMenu[]|ObjectCollection findByCategoria(string $categoria) Return ChildJaMenu objects filtered by the categoria column
 * @method     ChildJaMenu[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class JaMenuQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\JaMenuQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\JaMenu', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildJaMenuQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildJaMenuQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildJaMenuQuery) {
            return $criteria;
        }
        $query = new ChildJaMenuQuery();
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
     * @return ChildJaMenu|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = JaMenuTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(JaMenuTableMap::DATABASE_NAME);
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
     * @return ChildJaMenu A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, nombre, clase, enlace, tipo_enlace, target, padre, categoria FROM ja_menu WHERE id = :p0';
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
            /** @var ChildJaMenu $obj */
            $obj = new ChildJaMenu();
            $obj->hydrate($row);
            JaMenuTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildJaMenu|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildJaMenuQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(JaMenuTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildJaMenuQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(JaMenuTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildJaMenuQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(JaMenuTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(JaMenuTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(JaMenuTableMap::COL_ID, $id, $comparison);
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
     * @return $this|ChildJaMenuQuery The current query, for fluid interface
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

        return $this->addUsingAlias(JaMenuTableMap::COL_NOMBRE, $nombre, $comparison);
    }

    /**
     * Filter the query on the clase column
     *
     * Example usage:
     * <code>
     * $query->filterByClase('fooValue');   // WHERE clase = 'fooValue'
     * $query->filterByClase('%fooValue%'); // WHERE clase LIKE '%fooValue%'
     * </code>
     *
     * @param     string $clase The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildJaMenuQuery The current query, for fluid interface
     */
    public function filterByClase($clase = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($clase)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $clase)) {
                $clase = str_replace('*', '%', $clase);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(JaMenuTableMap::COL_CLASE, $clase, $comparison);
    }

    /**
     * Filter the query on the enlace column
     *
     * Example usage:
     * <code>
     * $query->filterByEnlace('fooValue');   // WHERE enlace = 'fooValue'
     * $query->filterByEnlace('%fooValue%'); // WHERE enlace LIKE '%fooValue%'
     * </code>
     *
     * @param     string $enlace The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildJaMenuQuery The current query, for fluid interface
     */
    public function filterByEnlace($enlace = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($enlace)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $enlace)) {
                $enlace = str_replace('*', '%', $enlace);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(JaMenuTableMap::COL_ENLACE, $enlace, $comparison);
    }

    /**
     * Filter the query on the tipo_enlace column
     *
     * Example usage:
     * <code>
     * $query->filterByTipoEnlace('fooValue');   // WHERE tipo_enlace = 'fooValue'
     * $query->filterByTipoEnlace('%fooValue%'); // WHERE tipo_enlace LIKE '%fooValue%'
     * </code>
     *
     * @param     string $tipoEnlace The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildJaMenuQuery The current query, for fluid interface
     */
    public function filterByTipoEnlace($tipoEnlace = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($tipoEnlace)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $tipoEnlace)) {
                $tipoEnlace = str_replace('*', '%', $tipoEnlace);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(JaMenuTableMap::COL_TIPO_ENLACE, $tipoEnlace, $comparison);
    }

    /**
     * Filter the query on the target column
     *
     * Example usage:
     * <code>
     * $query->filterByTarget('fooValue');   // WHERE target = 'fooValue'
     * $query->filterByTarget('%fooValue%'); // WHERE target LIKE '%fooValue%'
     * </code>
     *
     * @param     string $target The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildJaMenuQuery The current query, for fluid interface
     */
    public function filterByTarget($target = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($target)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $target)) {
                $target = str_replace('*', '%', $target);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(JaMenuTableMap::COL_TARGET, $target, $comparison);
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
     * @return $this|ChildJaMenuQuery The current query, for fluid interface
     */
    public function filterByPadre($padre = null, $comparison = null)
    {
        if (is_array($padre)) {
            $useMinMax = false;
            if (isset($padre['min'])) {
                $this->addUsingAlias(JaMenuTableMap::COL_PADRE, $padre['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($padre['max'])) {
                $this->addUsingAlias(JaMenuTableMap::COL_PADRE, $padre['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(JaMenuTableMap::COL_PADRE, $padre, $comparison);
    }

    /**
     * Filter the query on the categoria column
     *
     * Example usage:
     * <code>
     * $query->filterByCategoria('fooValue');   // WHERE categoria = 'fooValue'
     * $query->filterByCategoria('%fooValue%'); // WHERE categoria LIKE '%fooValue%'
     * </code>
     *
     * @param     string $categoria The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildJaMenuQuery The current query, for fluid interface
     */
    public function filterByCategoria($categoria = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($categoria)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $categoria)) {
                $categoria = str_replace('*', '%', $categoria);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(JaMenuTableMap::COL_CATEGORIA, $categoria, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   ChildJaMenu $jaMenu Object to remove from the list of results
     *
     * @return $this|ChildJaMenuQuery The current query, for fluid interface
     */
    public function prune($jaMenu = null)
    {
        if ($jaMenu) {
            $this->addUsingAlias(JaMenuTableMap::COL_ID, $jaMenu->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the ja_menu table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(JaMenuTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            JaMenuTableMap::clearInstancePool();
            JaMenuTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(JaMenuTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(JaMenuTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            
            JaMenuTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            JaMenuTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // JaMenuQuery
