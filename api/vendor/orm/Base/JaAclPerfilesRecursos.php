<?php

namespace Base;

use \JaAclPerfiles as ChildJaAclPerfiles;
use \JaAclPerfilesQuery as ChildJaAclPerfilesQuery;
use \JaAclPerfilesRecursosQuery as ChildJaAclPerfilesRecursosQuery;
use \JaAclRecursos as ChildJaAclRecursos;
use \JaAclRecursosQuery as ChildJaAclRecursosQuery;
use \Exception;
use \PDO;
use Map\JaAclPerfilesRecursosTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\BadMethodCallException;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Parser\AbstractParser;

/**
 * Base class that represents a row from the 'ja_acl_perfiles_recursos' table.
 *
 * 
 *
* @package    propel.generator..Base
*/
abstract class JaAclPerfilesRecursos implements ActiveRecordInterface 
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\JaAclPerfilesRecursosTableMap';


    /**
     * attribute to determine if this object has previously been saved.
     * @var boolean
     */
    protected $new = true;

    /**
     * attribute to determine whether this object has been deleted.
     * @var boolean
     */
    protected $deleted = false;

    /**
     * The columns that have been modified in current object.
     * Tracking modified columns allows us to only update modified columns.
     * @var array
     */
    protected $modifiedColumns = array();

    /**
     * The (virtual) columns that are added at runtime
     * The formatters can add supplementary columns based on a resultset
     * @var array
     */
    protected $virtualColumns = array();

    /**
     * The value for the consultar field.
     * 
     * Note: this column has a database default value of: false
     * @var        boolean
     */
    protected $consultar;

    /**
     * The value for the agregar field.
     * 
     * Note: this column has a database default value of: false
     * @var        boolean
     */
    protected $agregar;

    /**
     * The value for the editar field.
     * 
     * Note: this column has a database default value of: false
     * @var        boolean
     */
    protected $editar;

    /**
     * The value for the eliminar field.
     * 
     * Note: this column has a database default value of: false
     * @var        boolean
     */
    protected $eliminar;

    /**
     * The value for the recurso_id field.
     * 
     * @var        int
     */
    protected $recurso_id;

    /**
     * The value for the perfil_id field.
     * 
     * @var        int
     */
    protected $perfil_id;

    /**
     * @var        ChildJaAclPerfiles
     */
    protected $aJaAclPerfiles;

    /**
     * @var        ChildJaAclRecursos
     */
    protected $aJaAclRecursos;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see __construct()
     */
    public function applyDefaultValues()
    {
        $this->consultar = false;
        $this->agregar = false;
        $this->editar = false;
        $this->eliminar = false;
    }

    /**
     * Initializes internal state of Base\JaAclPerfilesRecursos object.
     * @see applyDefaults()
     */
    public function __construct()
    {
        $this->applyDefaultValues();
    }

    /**
     * Returns whether the object has been modified.
     *
     * @return boolean True if the object has been modified.
     */
    public function isModified()
    {
        return !!$this->modifiedColumns;
    }

    /**
     * Has specified column been modified?
     *
     * @param  string  $col column fully qualified name (TableMap::TYPE_COLNAME), e.g. Book::AUTHOR_ID
     * @return boolean True if $col has been modified.
     */
    public function isColumnModified($col)
    {
        return $this->modifiedColumns && isset($this->modifiedColumns[$col]);
    }

    /**
     * Get the columns that have been modified in this object.
     * @return array A unique list of the modified column names for this object.
     */
    public function getModifiedColumns()
    {
        return $this->modifiedColumns ? array_keys($this->modifiedColumns) : [];
    }

    /**
     * Returns whether the object has ever been saved.  This will
     * be false, if the object was retrieved from storage or was created
     * and then saved.
     *
     * @return boolean true, if the object has never been persisted.
     */
    public function isNew()
    {
        return $this->new;
    }

    /**
     * Setter for the isNew attribute.  This method will be called
     * by Propel-generated children and objects.
     *
     * @param boolean $b the state of the object.
     */
    public function setNew($b)
    {
        $this->new = (boolean) $b;
    }

    /**
     * Whether this object has been deleted.
     * @return boolean The deleted state of this object.
     */
    public function isDeleted()
    {
        return $this->deleted;
    }

    /**
     * Specify whether this object has been deleted.
     * @param  boolean $b The deleted state of this object.
     * @return void
     */
    public function setDeleted($b)
    {
        $this->deleted = (boolean) $b;
    }

    /**
     * Sets the modified state for the object to be false.
     * @param  string $col If supplied, only the specified column is reset.
     * @return void
     */
    public function resetModified($col = null)
    {
        if (null !== $col) {
            if (isset($this->modifiedColumns[$col])) {
                unset($this->modifiedColumns[$col]);
            }
        } else {
            $this->modifiedColumns = array();
        }
    }

    /**
     * Compares this with another <code>JaAclPerfilesRecursos</code> instance.  If
     * <code>obj</code> is an instance of <code>JaAclPerfilesRecursos</code>, delegates to
     * <code>equals(JaAclPerfilesRecursos)</code>.  Otherwise, returns <code>false</code>.
     *
     * @param  mixed   $obj The object to compare to.
     * @return boolean Whether equal to the object specified.
     */
    public function equals($obj)
    {
        if (!$obj instanceof static) {
            return false;
        }

        if ($this === $obj) {
            return true;
        }

        if (null === $this->getPrimaryKey() || null === $obj->getPrimaryKey()) {
            return false;
        }

        return $this->getPrimaryKey() === $obj->getPrimaryKey();
    }

    /**
     * Get the associative array of the virtual columns in this object
     *
     * @return array
     */
    public function getVirtualColumns()
    {
        return $this->virtualColumns;
    }

    /**
     * Checks the existence of a virtual column in this object
     *
     * @param  string  $name The virtual column name
     * @return boolean
     */
    public function hasVirtualColumn($name)
    {
        return array_key_exists($name, $this->virtualColumns);
    }

    /**
     * Get the value of a virtual column in this object
     *
     * @param  string $name The virtual column name
     * @return mixed
     *
     * @throws PropelException
     */
    public function getVirtualColumn($name)
    {
        if (!$this->hasVirtualColumn($name)) {
            throw new PropelException(sprintf('Cannot get value of inexistent virtual column %s.', $name));
        }

        return $this->virtualColumns[$name];
    }

    /**
     * Set the value of a virtual column in this object
     *
     * @param string $name  The virtual column name
     * @param mixed  $value The value to give to the virtual column
     *
     * @return $this|JaAclPerfilesRecursos The current object, for fluid interface
     */
    public function setVirtualColumn($name, $value)
    {
        $this->virtualColumns[$name] = $value;

        return $this;
    }

    /**
     * Logs a message using Propel::log().
     *
     * @param  string  $msg
     * @param  int     $priority One of the Propel::LOG_* logging levels
     * @return boolean
     */
    protected function log($msg, $priority = Propel::LOG_INFO)
    {
        return Propel::log(get_class($this) . ': ' . $msg, $priority);
    }

    /**
     * Export the current object properties to a string, using a given parser format
     * <code>
     * $book = BookQuery::create()->findPk(9012);
     * echo $book->exportTo('JSON');
     *  => {"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * @param  mixed   $parser                 A AbstractParser instance, or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param  boolean $includeLazyLoadColumns (optional) Whether to include lazy load(ed) columns. Defaults to TRUE.
     * @return string  The exported data
     */
    public function exportTo($parser, $includeLazyLoadColumns = true)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        return $parser->fromArray($this->toArray(TableMap::TYPE_PHPNAME, $includeLazyLoadColumns, array(), true));
    }

    /**
     * Clean up internal collections prior to serializing
     * Avoids recursive loops that turn into segmentation faults when serializing
     */
    public function __sleep()
    {
        $this->clearAllReferences();

        $cls = new \ReflectionClass($this);
        $propertyNames = [];
        foreach($cls->getProperties() as $property) {
            $propertyNames[] = $property->getName();
        }
        return $propertyNames;
    }

    /**
     * Get the [consultar] column value.
     * 
     * @return boolean
     */
    public function getConsultar()
    {
        return $this->consultar;
    }

    /**
     * Get the [consultar] column value.
     * 
     * @return boolean
     */
    public function isConsultar()
    {
        return $this->getConsultar();
    }

    /**
     * Get the [agregar] column value.
     * 
     * @return boolean
     */
    public function getAgregar()
    {
        return $this->agregar;
    }

    /**
     * Get the [agregar] column value.
     * 
     * @return boolean
     */
    public function isAgregar()
    {
        return $this->getAgregar();
    }

    /**
     * Get the [editar] column value.
     * 
     * @return boolean
     */
    public function getEditar()
    {
        return $this->editar;
    }

    /**
     * Get the [editar] column value.
     * 
     * @return boolean
     */
    public function isEditar()
    {
        return $this->getEditar();
    }

    /**
     * Get the [eliminar] column value.
     * 
     * @return boolean
     */
    public function getEliminar()
    {
        return $this->eliminar;
    }

    /**
     * Get the [eliminar] column value.
     * 
     * @return boolean
     */
    public function isEliminar()
    {
        return $this->getEliminar();
    }

    /**
     * Get the [recurso_id] column value.
     * 
     * @return int
     */
    public function getRecursoId()
    {
        return $this->recurso_id;
    }

    /**
     * Get the [perfil_id] column value.
     * 
     * @return int
     */
    public function getPerfilId()
    {
        return $this->perfil_id;
    }

    /**
     * Sets the value of the [consultar] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * 
     * @param  boolean|integer|string $v The new value
     * @return $this|\JaAclPerfilesRecursos The current object (for fluent API support)
     */
    public function setConsultar($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->consultar !== $v) {
            $this->consultar = $v;
            $this->modifiedColumns[JaAclPerfilesRecursosTableMap::COL_CONSULTAR] = true;
        }

        return $this;
    } // setConsultar()

    /**
     * Sets the value of the [agregar] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * 
     * @param  boolean|integer|string $v The new value
     * @return $this|\JaAclPerfilesRecursos The current object (for fluent API support)
     */
    public function setAgregar($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->agregar !== $v) {
            $this->agregar = $v;
            $this->modifiedColumns[JaAclPerfilesRecursosTableMap::COL_AGREGAR] = true;
        }

        return $this;
    } // setAgregar()

    /**
     * Sets the value of the [editar] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * 
     * @param  boolean|integer|string $v The new value
     * @return $this|\JaAclPerfilesRecursos The current object (for fluent API support)
     */
    public function setEditar($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->editar !== $v) {
            $this->editar = $v;
            $this->modifiedColumns[JaAclPerfilesRecursosTableMap::COL_EDITAR] = true;
        }

        return $this;
    } // setEditar()

    /**
     * Sets the value of the [eliminar] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * 
     * @param  boolean|integer|string $v The new value
     * @return $this|\JaAclPerfilesRecursos The current object (for fluent API support)
     */
    public function setEliminar($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->eliminar !== $v) {
            $this->eliminar = $v;
            $this->modifiedColumns[JaAclPerfilesRecursosTableMap::COL_ELIMINAR] = true;
        }

        return $this;
    } // setEliminar()

    /**
     * Set the value of [recurso_id] column.
     * 
     * @param int $v new value
     * @return $this|\JaAclPerfilesRecursos The current object (for fluent API support)
     */
    public function setRecursoId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->recurso_id !== $v) {
            $this->recurso_id = $v;
            $this->modifiedColumns[JaAclPerfilesRecursosTableMap::COL_RECURSO_ID] = true;
        }

        if ($this->aJaAclRecursos !== null && $this->aJaAclRecursos->getId() !== $v) {
            $this->aJaAclRecursos = null;
        }

        return $this;
    } // setRecursoId()

    /**
     * Set the value of [perfil_id] column.
     * 
     * @param int $v new value
     * @return $this|\JaAclPerfilesRecursos The current object (for fluent API support)
     */
    public function setPerfilId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->perfil_id !== $v) {
            $this->perfil_id = $v;
            $this->modifiedColumns[JaAclPerfilesRecursosTableMap::COL_PERFIL_ID] = true;
        }

        if ($this->aJaAclPerfiles !== null && $this->aJaAclPerfiles->getId() !== $v) {
            $this->aJaAclPerfiles = null;
        }

        return $this;
    } // setPerfilId()

    /**
     * Indicates whether the columns in this object are only set to default values.
     *
     * This method can be used in conjunction with isModified() to indicate whether an object is both
     * modified _and_ has some values set which are non-default.
     *
     * @return boolean Whether the columns in this object are only been set with default values.
     */
    public function hasOnlyDefaultValues()
    {
            if ($this->consultar !== false) {
                return false;
            }

            if ($this->agregar !== false) {
                return false;
            }

            if ($this->editar !== false) {
                return false;
            }

            if ($this->eliminar !== false) {
                return false;
            }

        // otherwise, everything was equal, so return TRUE
        return true;
    } // hasOnlyDefaultValues()

    /**
     * Hydrates (populates) the object variables with values from the database resultset.
     *
     * An offset (0-based "start column") is specified so that objects can be hydrated
     * with a subset of the columns in the resultset rows.  This is needed, for example,
     * for results of JOIN queries where the resultset row includes columns from two or
     * more tables.
     *
     * @param array   $row       The row returned by DataFetcher->fetch().
     * @param int     $startcol  0-based offset column which indicates which restultset column to start with.
     * @param boolean $rehydrate Whether this object is being re-hydrated from the database.
     * @param string  $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                  One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                            TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @return int             next starting column
     * @throws PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate($row, $startcol = 0, $rehydrate = false, $indexType = TableMap::TYPE_NUM)
    {
        try {

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : JaAclPerfilesRecursosTableMap::translateFieldName('Consultar', TableMap::TYPE_PHPNAME, $indexType)];
            $this->consultar = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : JaAclPerfilesRecursosTableMap::translateFieldName('Agregar', TableMap::TYPE_PHPNAME, $indexType)];
            $this->agregar = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : JaAclPerfilesRecursosTableMap::translateFieldName('Editar', TableMap::TYPE_PHPNAME, $indexType)];
            $this->editar = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : JaAclPerfilesRecursosTableMap::translateFieldName('Eliminar', TableMap::TYPE_PHPNAME, $indexType)];
            $this->eliminar = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : JaAclPerfilesRecursosTableMap::translateFieldName('RecursoId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->recurso_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : JaAclPerfilesRecursosTableMap::translateFieldName('PerfilId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->perfil_id = (null !== $col) ? (int) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 6; // 6 = JaAclPerfilesRecursosTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\JaAclPerfilesRecursos'), 0, $e);
        }
    }

    /**
     * Checks and repairs the internal consistency of the object.
     *
     * This method is executed after an already-instantiated object is re-hydrated
     * from the database.  It exists to check any foreign keys to make sure that
     * the objects related to the current object are correct based on foreign key.
     *
     * You can override this method in the stub class, but you should always invoke
     * the base method from the overridden method (i.e. parent::ensureConsistency()),
     * in case your model changes.
     *
     * @throws PropelException
     */
    public function ensureConsistency()
    {
        if ($this->aJaAclRecursos !== null && $this->recurso_id !== $this->aJaAclRecursos->getId()) {
            $this->aJaAclRecursos = null;
        }
        if ($this->aJaAclPerfiles !== null && $this->perfil_id !== $this->aJaAclPerfiles->getId()) {
            $this->aJaAclPerfiles = null;
        }
    } // ensureConsistency

    /**
     * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
     *
     * This will only work if the object has been saved and has a valid primary key set.
     *
     * @param      boolean $deep (optional) Whether to also de-associated any related objects.
     * @param      ConnectionInterface $con (optional) The ConnectionInterface connection to use.
     * @return void
     * @throws PropelException - if this object is deleted, unsaved or doesn't have pk match in db
     */
    public function reload($deep = false, ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("Cannot reload a deleted object.");
        }

        if ($this->isNew()) {
            throw new PropelException("Cannot reload an unsaved object.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(JaAclPerfilesRecursosTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildJaAclPerfilesRecursosQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aJaAclPerfiles = null;
            $this->aJaAclRecursos = null;
        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see JaAclPerfilesRecursos::setDeleted()
     * @see JaAclPerfilesRecursos::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(JaAclPerfilesRecursosTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildJaAclPerfilesRecursosQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
            if ($ret) {
                $deleteQuery->delete($con);
                $this->postDelete($con);
                $this->setDeleted(true);
            }
        });
    }

    /**
     * Persists this object to the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All modified related objects will also be persisted in the doSave()
     * method.  This method wraps all precipitate database operations in a
     * single transaction.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see doSave()
     */
    public function save(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(JaAclPerfilesRecursosTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $isInsert = $this->isNew();
            $ret = $this->preSave($con);
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
            } else {
                $ret = $ret && $this->preUpdate($con);
            }
            if ($ret) {
                $affectedRows = $this->doSave($con);
                if ($isInsert) {
                    $this->postInsert($con);
                } else {
                    $this->postUpdate($con);
                }
                $this->postSave($con);
                JaAclPerfilesRecursosTableMap::addInstanceToPool($this);
            } else {
                $affectedRows = 0;
            }

            return $affectedRows;
        });
    }

    /**
     * Performs the work of inserting or updating the row in the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All related objects are also updated in this method.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see save()
     */
    protected function doSave(ConnectionInterface $con)
    {
        $affectedRows = 0; // initialize var to track total num of affected rows
        if (!$this->alreadyInSave) {
            $this->alreadyInSave = true;

            // We call the save method on the following object(s) if they
            // were passed to this object by their corresponding set
            // method.  This object relates to these object(s) by a
            // foreign key reference.

            if ($this->aJaAclPerfiles !== null) {
                if ($this->aJaAclPerfiles->isModified() || $this->aJaAclPerfiles->isNew()) {
                    $affectedRows += $this->aJaAclPerfiles->save($con);
                }
                $this->setJaAclPerfiles($this->aJaAclPerfiles);
            }

            if ($this->aJaAclRecursos !== null) {
                if ($this->aJaAclRecursos->isModified() || $this->aJaAclRecursos->isNew()) {
                    $affectedRows += $this->aJaAclRecursos->save($con);
                }
                $this->setJaAclRecursos($this->aJaAclRecursos);
            }

            if ($this->isNew() || $this->isModified()) {
                // persist changes
                if ($this->isNew()) {
                    $this->doInsert($con);
                    $affectedRows += 1;
                } else {
                    $affectedRows += $this->doUpdate($con);
                }
                $this->resetModified();
            }

            $this->alreadyInSave = false;

        }

        return $affectedRows;
    } // doSave()

    /**
     * Insert the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @throws PropelException
     * @see doSave()
     */
    protected function doInsert(ConnectionInterface $con)
    {
        $modifiedColumns = array();
        $index = 0;


         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(JaAclPerfilesRecursosTableMap::COL_CONSULTAR)) {
            $modifiedColumns[':p' . $index++]  = 'consultar';
        }
        if ($this->isColumnModified(JaAclPerfilesRecursosTableMap::COL_AGREGAR)) {
            $modifiedColumns[':p' . $index++]  = 'agregar';
        }
        if ($this->isColumnModified(JaAclPerfilesRecursosTableMap::COL_EDITAR)) {
            $modifiedColumns[':p' . $index++]  = 'editar';
        }
        if ($this->isColumnModified(JaAclPerfilesRecursosTableMap::COL_ELIMINAR)) {
            $modifiedColumns[':p' . $index++]  = 'eliminar';
        }
        if ($this->isColumnModified(JaAclPerfilesRecursosTableMap::COL_RECURSO_ID)) {
            $modifiedColumns[':p' . $index++]  = 'recurso_id';
        }
        if ($this->isColumnModified(JaAclPerfilesRecursosTableMap::COL_PERFIL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'perfil_id';
        }

        $sql = sprintf(
            'INSERT INTO ja_acl_perfiles_recursos (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'consultar':
                        $stmt->bindValue($identifier, (int) $this->consultar, PDO::PARAM_INT);
                        break;
                    case 'agregar':
                        $stmt->bindValue($identifier, (int) $this->agregar, PDO::PARAM_INT);
                        break;
                    case 'editar':
                        $stmt->bindValue($identifier, (int) $this->editar, PDO::PARAM_INT);
                        break;
                    case 'eliminar':
                        $stmt->bindValue($identifier, (int) $this->eliminar, PDO::PARAM_INT);
                        break;
                    case 'recurso_id':                        
                        $stmt->bindValue($identifier, $this->recurso_id, PDO::PARAM_INT);
                        break;
                    case 'perfil_id':                        
                        $stmt->bindValue($identifier, $this->perfil_id, PDO::PARAM_INT);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), 0, $e);
        }

        $this->setNew(false);
    }

    /**
     * Update the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @return Integer Number of updated rows
     * @see doSave()
     */
    protected function doUpdate(ConnectionInterface $con)
    {
        $selectCriteria = $this->buildPkeyCriteria();
        $valuesCriteria = $this->buildCriteria();

        return $selectCriteria->doUpdate($valuesCriteria, $con);
    }

    /**
     * Retrieves a field from the object by name passed in as a string.
     *
     * @param      string $name name
     * @param      string $type The type of fieldname the $name is of:
     *                     one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                     TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                     Defaults to TableMap::TYPE_PHPNAME.
     * @return mixed Value of field.
     */
    public function getByName($name, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = JaAclPerfilesRecursosTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param      int $pos position in xml schema
     * @return mixed Value of field at $pos
     */
    public function getByPosition($pos)
    {
        switch ($pos) {
            case 0:
                return $this->getConsultar();
                break;
            case 1:
                return $this->getAgregar();
                break;
            case 2:
                return $this->getEditar();
                break;
            case 3:
                return $this->getEliminar();
                break;
            case 4:
                return $this->getRecursoId();
                break;
            case 5:
                return $this->getPerfilId();
                break;
            default:
                return null;
                break;
        } // switch()
    }

    /**
     * Exports the object as an array.
     *
     * You can specify the key type of the array by passing one of the class
     * type constants.
     *
     * @param     string  $keyType (optional) One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     *                    TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                    Defaults to TableMap::TYPE_PHPNAME.
     * @param     boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to TRUE.
     * @param     array $alreadyDumpedObjects List of objects to skip to avoid recursion
     * @param     boolean $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = TableMap::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {

        if (isset($alreadyDumpedObjects['JaAclPerfilesRecursos'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['JaAclPerfilesRecursos'][$this->hashCode()] = true;
        $keys = JaAclPerfilesRecursosTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getConsultar(),
            $keys[1] => $this->getAgregar(),
            $keys[2] => $this->getEditar(),
            $keys[3] => $this->getEliminar(),
            $keys[4] => $this->getRecursoId(),
            $keys[5] => $this->getPerfilId(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }
        
        if ($includeForeignObjects) {
            if (null !== $this->aJaAclPerfiles) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'jaAclPerfiles';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'ja_acl_perfiles';
                        break;
                    default:
                        $key = 'JaAclPerfiles';
                }
        
                $result[$key] = $this->aJaAclPerfiles->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aJaAclRecursos) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'jaAclRecursos';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'ja_acl_recursos';
                        break;
                    default:
                        $key = 'JaAclRecursos';
                }
        
                $result[$key] = $this->aJaAclRecursos->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param  string $name
     * @param  mixed  $value field value
     * @param  string $type The type of fieldname the $name is of:
     *                one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                Defaults to TableMap::TYPE_PHPNAME.
     * @return $this|\JaAclPerfilesRecursos
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = JaAclPerfilesRecursosTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\JaAclPerfilesRecursos
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setConsultar($value);
                break;
            case 1:
                $this->setAgregar($value);
                break;
            case 2:
                $this->setEditar($value);
                break;
            case 3:
                $this->setEliminar($value);
                break;
            case 4:
                $this->setRecursoId($value);
                break;
            case 5:
                $this->setPerfilId($value);
                break;
        } // switch()

        return $this;
    }

    /**
     * Populates the object using an array.
     *
     * This is particularly useful when populating an object from one of the
     * request arrays (e.g. $_POST).  This method goes through the column
     * names, checking to see whether a matching key exists in populated
     * array. If so the setByName() method is called for that column.
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param      array  $arr     An array to populate the object from.
     * @param      string $keyType The type of keys the array uses.
     * @return void
     */
    public function fromArray($arr, $keyType = TableMap::TYPE_PHPNAME)
    {
        $keys = JaAclPerfilesRecursosTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setConsultar($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setAgregar($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setEditar($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setEliminar($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setRecursoId($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setPerfilId($arr[$keys[5]]);
        }
    }

     /**
     * Populate the current object from a string, using a given parser format
     * <code>
     * $book = new Book();
     * $book->importFrom('JSON', '{"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param mixed $parser A AbstractParser instance,
     *                       or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param string $data The source data to import from
     * @param string $keyType The type of keys the array uses.
     *
     * @return $this|\JaAclPerfilesRecursos The current object, for fluid interface
     */
    public function importFrom($parser, $data, $keyType = TableMap::TYPE_PHPNAME)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        $this->fromArray($parser->toArray($data), $keyType);

        return $this;
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(JaAclPerfilesRecursosTableMap::DATABASE_NAME);

        if ($this->isColumnModified(JaAclPerfilesRecursosTableMap::COL_CONSULTAR)) {
            $criteria->add(JaAclPerfilesRecursosTableMap::COL_CONSULTAR, $this->consultar);
        }
        if ($this->isColumnModified(JaAclPerfilesRecursosTableMap::COL_AGREGAR)) {
            $criteria->add(JaAclPerfilesRecursosTableMap::COL_AGREGAR, $this->agregar);
        }
        if ($this->isColumnModified(JaAclPerfilesRecursosTableMap::COL_EDITAR)) {
            $criteria->add(JaAclPerfilesRecursosTableMap::COL_EDITAR, $this->editar);
        }
        if ($this->isColumnModified(JaAclPerfilesRecursosTableMap::COL_ELIMINAR)) {
            $criteria->add(JaAclPerfilesRecursosTableMap::COL_ELIMINAR, $this->eliminar);
        }
        if ($this->isColumnModified(JaAclPerfilesRecursosTableMap::COL_RECURSO_ID)) {
            $criteria->add(JaAclPerfilesRecursosTableMap::COL_RECURSO_ID, $this->recurso_id);
        }
        if ($this->isColumnModified(JaAclPerfilesRecursosTableMap::COL_PERFIL_ID)) {
            $criteria->add(JaAclPerfilesRecursosTableMap::COL_PERFIL_ID, $this->perfil_id);
        }

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether or not they have been modified.
     *
     * @throws LogicException if no primary key is defined
     *
     * @return Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria()
    {
        throw new LogicException('The JaAclPerfilesRecursos object has no primary key');

        return $criteria;
    }

    /**
     * If the primary key is not null, return the hashcode of the
     * primary key. Otherwise, return the hash code of the object.
     *
     * @return int Hashcode
     */
    public function hashCode()
    {
        $validPk = false;

        $validPrimaryKeyFKs = 0;
        $primaryKeyFKs = [];

        if ($validPk) {
            return crc32(json_encode($this->getPrimaryKey(), JSON_UNESCAPED_UNICODE));
        } elseif ($validPrimaryKeyFKs) {
            return crc32(json_encode($primaryKeyFKs, JSON_UNESCAPED_UNICODE));
        }

        return spl_object_hash($this);
    }
        
    /**
     * Returns NULL since this table doesn't have a primary key.
     * This method exists only for BC and is deprecated!
     * @return null
     */
    public function getPrimaryKey()
    {
        return null;
    }

    /**
     * Dummy primary key setter.
     *
     * This function only exists to preserve backwards compatibility.  It is no longer
     * needed or required by the Persistent interface.  It will be removed in next BC-breaking
     * release of Propel.
     *
     * @deprecated
     */
    public function setPrimaryKey($pk)
    {
        // do nothing, because this object doesn't have any primary keys
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return ;
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \JaAclPerfilesRecursos (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setConsultar($this->getConsultar());
        $copyObj->setAgregar($this->getAgregar());
        $copyObj->setEditar($this->getEditar());
        $copyObj->setEliminar($this->getEliminar());
        $copyObj->setRecursoId($this->getRecursoId());
        $copyObj->setPerfilId($this->getPerfilId());
        if ($makeNew) {
            $copyObj->setNew(true);
        }
    }

    /**
     * Makes a copy of this object that will be inserted as a new row in table when saved.
     * It creates a new object filling in the simple attributes, but skipping any primary
     * keys that are defined for the table.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param  boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return \JaAclPerfilesRecursos Clone of current object.
     * @throws PropelException
     */
    public function copy($deepCopy = false)
    {
        // we use get_class(), because this might be a subclass
        $clazz = get_class($this);
        $copyObj = new $clazz();
        $this->copyInto($copyObj, $deepCopy);

        return $copyObj;
    }

    /**
     * Declares an association between this object and a ChildJaAclPerfiles object.
     *
     * @param  ChildJaAclPerfiles $v
     * @return $this|\JaAclPerfilesRecursos The current object (for fluent API support)
     * @throws PropelException
     */
    public function setJaAclPerfiles(ChildJaAclPerfiles $v = null)
    {
        if ($v === null) {
            $this->setPerfilId(NULL);
        } else {
            $this->setPerfilId($v->getId());
        }

        $this->aJaAclPerfiles = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildJaAclPerfiles object, it will not be re-added.
        if ($v !== null) {
            $v->addJaAclPerfilesRecursos($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildJaAclPerfiles object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildJaAclPerfiles The associated ChildJaAclPerfiles object.
     * @throws PropelException
     */
    public function getJaAclPerfiles(ConnectionInterface $con = null)
    {
        if ($this->aJaAclPerfiles === null && ($this->perfil_id !== null)) {
            $this->aJaAclPerfiles = ChildJaAclPerfilesQuery::create()->findPk($this->perfil_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aJaAclPerfiles->addJaAclPerfilesRecursoss($this);
             */
        }

        return $this->aJaAclPerfiles;
    }

    /**
     * Declares an association between this object and a ChildJaAclRecursos object.
     *
     * @param  ChildJaAclRecursos $v
     * @return $this|\JaAclPerfilesRecursos The current object (for fluent API support)
     * @throws PropelException
     */
    public function setJaAclRecursos(ChildJaAclRecursos $v = null)
    {
        if ($v === null) {
            $this->setRecursoId(NULL);
        } else {
            $this->setRecursoId($v->getId());
        }

        $this->aJaAclRecursos = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildJaAclRecursos object, it will not be re-added.
        if ($v !== null) {
            $v->addJaAclPerfilesRecursos($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildJaAclRecursos object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildJaAclRecursos The associated ChildJaAclRecursos object.
     * @throws PropelException
     */
    public function getJaAclRecursos(ConnectionInterface $con = null)
    {
        if ($this->aJaAclRecursos === null && ($this->recurso_id !== null)) {
            $this->aJaAclRecursos = ChildJaAclRecursosQuery::create()->findPk($this->recurso_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aJaAclRecursos->addJaAclPerfilesRecursoss($this);
             */
        }

        return $this->aJaAclRecursos;
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aJaAclPerfiles) {
            $this->aJaAclPerfiles->removeJaAclPerfilesRecursos($this);
        }
        if (null !== $this->aJaAclRecursos) {
            $this->aJaAclRecursos->removeJaAclPerfilesRecursos($this);
        }
        $this->consultar = null;
        $this->agregar = null;
        $this->editar = null;
        $this->eliminar = null;
        $this->recurso_id = null;
        $this->perfil_id = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
        $this->applyDefaultValues();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);
    }

    /**
     * Resets all references and back-references to other model objects or collections of model objects.
     *
     * This method is used to reset all php object references (not the actual reference in the database).
     * Necessary for object serialisation.
     *
     * @param      boolean $deep Whether to also clear the references on all referrer objects.
     */
    public function clearAllReferences($deep = false)
    {
        if ($deep) {
        } // if ($deep)

        $this->aJaAclPerfiles = null;
        $this->aJaAclRecursos = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(JaAclPerfilesRecursosTableMap::DEFAULT_STRING_FORMAT);
    }

    /**
     * Code to be run before persisting the object
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preSave(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after persisting the object
     * @param ConnectionInterface $con
     */
    public function postSave(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before inserting to database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preInsert(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after inserting to database
     * @param ConnectionInterface $con
     */
    public function postInsert(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before updating the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preUpdate(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after updating the object in database
     * @param ConnectionInterface $con
     */
    public function postUpdate(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before deleting the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preDelete(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after deleting the object in database
     * @param ConnectionInterface $con
     */
    public function postDelete(ConnectionInterface $con = null)
    {

    }


    /**
     * Derived method to catches calls to undefined methods.
     *
     * Provides magic import/export method support (fromXML()/toXML(), fromYAML()/toYAML(), etc.).
     * Allows to define default __call() behavior if you overwrite __call()
     *
     * @param string $name
     * @param mixed  $params
     *
     * @return array|string
     */
    public function __call($name, $params)
    {
        if (0 === strpos($name, 'get')) {
            $virtualColumn = substr($name, 3);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }

            $virtualColumn = lcfirst($virtualColumn);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }
        }

        if (0 === strpos($name, 'from')) {
            $format = substr($name, 4);

            return $this->importFrom($format, reset($params));
        }

        if (0 === strpos($name, 'to')) {
            $format = substr($name, 2);
            $includeLazyLoadColumns = isset($params[0]) ? $params[0] : true;

            return $this->exportTo($format, $includeLazyLoadColumns);
        }

        throw new BadMethodCallException(sprintf('Call to undefined method: %s.', $name));
    }

}
