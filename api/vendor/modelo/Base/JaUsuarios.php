<?php

namespace Base;

use \JaAclUsuariosPerfiles as ChildJaAclUsuariosPerfiles;
use \JaAclUsuariosPerfilesQuery as ChildJaAclUsuariosPerfilesQuery;
use \JaUsuarios as ChildJaUsuarios;
use \JaUsuariosQuery as ChildJaUsuariosQuery;
use \DateTime;
use \Exception;
use \PDO;
use Map\JaUsuariosTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\BadMethodCallException;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Parser\AbstractParser;
use Propel\Runtime\Util\PropelDateTime;

/**
 * Base class that represents a row from the 'ja_usuarios' table.
 *
 * 
 *
* @package    propel.generator..Base
*/
abstract class JaUsuarios implements ActiveRecordInterface 
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\JaUsuariosTableMap';


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
     * The value for the id field.
     * 
     * @var        int
     */
    protected $id;

    /**
     * The value for the usuario field.
     * 
     * @var        string
     */
    protected $usuario;

    /**
     * The value for the imagen field.
     * 
     * @var        string
     */
    protected $imagen;

    /**
     * The value for the nombre field.
     * 
     * @var        string
     */
    protected $nombre;

    /**
     * The value for the apellidos field.
     * 
     * @var        string
     */
    protected $apellidos;

    /**
     * The value for the biografia field.
     * 
     * @var        string
     */
    protected $biografia;

    /**
     * The value for the correo field.
     * 
     * @var        string
     */
    protected $correo;

    /**
     * The value for the telefono field.
     * 
     * @var        string
     */
    protected $telefono;

    /**
     * The value for the redessociales field.
     * 
     * @var        string
     */
    protected $redessociales;

    /**
     * The value for the clave field.
     * 
     * @var        string
     */
    protected $clave;

    /**
     * The value for the direccion field.
     * 
     * @var        string
     */
    protected $direccion;

    /**
     * The value for the ciudad field.
     * 
     * @var        string
     */
    protected $ciudad;

    /**
     * The value for the pais field.
     * 
     * @var        string
     */
    protected $pais;

    /**
     * The value for the fechacreado field.
     * 
     * Note: this column has a database default value of: (expression) CURRENT_TIMESTAMP
     * @var        \DateTime
     */
    protected $fechacreado;

    /**
     * @var        ObjectCollection|ChildJaAclUsuariosPerfiles[] Collection to store aggregation of ChildJaAclUsuariosPerfiles objects.
     */
    protected $collJaAclUsuariosPerfiless;
    protected $collJaAclUsuariosPerfilessPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildJaAclUsuariosPerfiles[]
     */
    protected $jaAclUsuariosPerfilessScheduledForDeletion = null;

    /**
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see __construct()
     */
    public function applyDefaultValues()
    {
    }

    /**
     * Initializes internal state of Base\JaUsuarios object.
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
     * Compares this with another <code>JaUsuarios</code> instance.  If
     * <code>obj</code> is an instance of <code>JaUsuarios</code>, delegates to
     * <code>equals(JaUsuarios)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|JaUsuarios The current object, for fluid interface
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
     * Get the [id] column value.
     * 
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the [usuario] column value.
     * 
     * @return string
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * Get the [imagen] column value.
     * 
     * @return string
     */
    public function getImagen()
    {
        return $this->imagen;
    }

    /**
     * Get the [nombre] column value.
     * 
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Get the [apellidos] column value.
     * 
     * @return string
     */
    public function getApellidos()
    {
        return $this->apellidos;
    }

    /**
     * Get the [biografia] column value.
     * 
     * @return string
     */
    public function getBiografia()
    {
        return $this->biografia;
    }

    /**
     * Get the [correo] column value.
     * 
     * @return string
     */
    public function getCorreo()
    {
        return $this->correo;
    }

    /**
     * Get the [telefono] column value.
     * 
     * @return string
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * Get the [redessociales] column value.
     * 
     * @return string
     */
    public function getRedessociales()
    {
        return $this->redessociales;
    }

    /**
     * Get the [clave] column value.
     * 
     * @return string
     */
    public function getClave()
    {
        return $this->clave;
    }

    /**
     * Get the [direccion] column value.
     * 
     * @return string
     */
    public function getDireccion()
    {
        return $this->direccion;
    }

    /**
     * Get the [ciudad] column value.
     * 
     * @return string
     */
    public function getCiudad()
    {
        return $this->ciudad;
    }

    /**
     * Get the [pais] column value.
     * 
     * @return string
     */
    public function getPais()
    {
        return $this->pais;
    }

    /**
     * Get the [optionally formatted] temporal [fechacreado] column value.
     * 
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getFechacreado($format = NULL)
    {
        if ($format === null) {
            return $this->fechacreado;
        } else {
            return $this->fechacreado instanceof \DateTime ? $this->fechacreado->format($format) : null;
        }
    }

    /**
     * Set the value of [id] column.
     * 
     * @param int $v new value
     * @return $this|\JaUsuarios The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[JaUsuariosTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [usuario] column.
     * 
     * @param string $v new value
     * @return $this|\JaUsuarios The current object (for fluent API support)
     */
    public function setUsuario($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->usuario !== $v) {
            $this->usuario = $v;
            $this->modifiedColumns[JaUsuariosTableMap::COL_USUARIO] = true;
        }

        return $this;
    } // setUsuario()

    /**
     * Set the value of [imagen] column.
     * 
     * @param string $v new value
     * @return $this|\JaUsuarios The current object (for fluent API support)
     */
    public function setImagen($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->imagen !== $v) {
            $this->imagen = $v;
            $this->modifiedColumns[JaUsuariosTableMap::COL_IMAGEN] = true;
        }

        return $this;
    } // setImagen()

    /**
     * Set the value of [nombre] column.
     * 
     * @param string $v new value
     * @return $this|\JaUsuarios The current object (for fluent API support)
     */
    public function setNombre($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->nombre !== $v) {
            $this->nombre = $v;
            $this->modifiedColumns[JaUsuariosTableMap::COL_NOMBRE] = true;
        }

        return $this;
    } // setNombre()

    /**
     * Set the value of [apellidos] column.
     * 
     * @param string $v new value
     * @return $this|\JaUsuarios The current object (for fluent API support)
     */
    public function setApellidos($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->apellidos !== $v) {
            $this->apellidos = $v;
            $this->modifiedColumns[JaUsuariosTableMap::COL_APELLIDOS] = true;
        }

        return $this;
    } // setApellidos()

    /**
     * Set the value of [biografia] column.
     * 
     * @param string $v new value
     * @return $this|\JaUsuarios The current object (for fluent API support)
     */
    public function setBiografia($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->biografia !== $v) {
            $this->biografia = $v;
            $this->modifiedColumns[JaUsuariosTableMap::COL_BIOGRAFIA] = true;
        }

        return $this;
    } // setBiografia()

    /**
     * Set the value of [correo] column.
     * 
     * @param string $v new value
     * @return $this|\JaUsuarios The current object (for fluent API support)
     */
    public function setCorreo($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->correo !== $v) {
            $this->correo = $v;
            $this->modifiedColumns[JaUsuariosTableMap::COL_CORREO] = true;
        }

        return $this;
    } // setCorreo()

    /**
     * Set the value of [telefono] column.
     * 
     * @param string $v new value
     * @return $this|\JaUsuarios The current object (for fluent API support)
     */
    public function setTelefono($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->telefono !== $v) {
            $this->telefono = $v;
            $this->modifiedColumns[JaUsuariosTableMap::COL_TELEFONO] = true;
        }

        return $this;
    } // setTelefono()

    /**
     * Set the value of [redessociales] column.
     * 
     * @param string $v new value
     * @return $this|\JaUsuarios The current object (for fluent API support)
     */
    public function setRedessociales($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->redessociales !== $v) {
            $this->redessociales = $v;
            $this->modifiedColumns[JaUsuariosTableMap::COL_REDESSOCIALES] = true;
        }

        return $this;
    } // setRedessociales()

    /**
     * Set the value of [clave] column.
     * 
     * @param string $v new value
     * @return $this|\JaUsuarios The current object (for fluent API support)
     */
    public function setClave($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->clave !== $v) {
            $this->clave = $v;
            $this->modifiedColumns[JaUsuariosTableMap::COL_CLAVE] = true;
        }

        return $this;
    } // setClave()

    /**
     * Set the value of [direccion] column.
     * 
     * @param string $v new value
     * @return $this|\JaUsuarios The current object (for fluent API support)
     */
    public function setDireccion($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->direccion !== $v) {
            $this->direccion = $v;
            $this->modifiedColumns[JaUsuariosTableMap::COL_DIRECCION] = true;
        }

        return $this;
    } // setDireccion()

    /**
     * Set the value of [ciudad] column.
     * 
     * @param string $v new value
     * @return $this|\JaUsuarios The current object (for fluent API support)
     */
    public function setCiudad($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->ciudad !== $v) {
            $this->ciudad = $v;
            $this->modifiedColumns[JaUsuariosTableMap::COL_CIUDAD] = true;
        }

        return $this;
    } // setCiudad()

    /**
     * Set the value of [pais] column.
     * 
     * @param string $v new value
     * @return $this|\JaUsuarios The current object (for fluent API support)
     */
    public function setPais($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->pais !== $v) {
            $this->pais = $v;
            $this->modifiedColumns[JaUsuariosTableMap::COL_PAIS] = true;
        }

        return $this;
    } // setPais()

    /**
     * Sets the value of [fechacreado] column to a normalized version of the date/time value specified.
     * 
     * @param  mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return $this|\JaUsuarios The current object (for fluent API support)
     */
    public function setFechacreado($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->fechacreado !== null || $dt !== null) {
            if ($this->fechacreado === null || $dt === null || $dt->format("Y-m-d H:i:s") !== $this->fechacreado->format("Y-m-d H:i:s")) {
                $this->fechacreado = $dt === null ? null : clone $dt;
                $this->modifiedColumns[JaUsuariosTableMap::COL_FECHACREADO] = true;
            }
        } // if either are not null

        return $this;
    } // setFechacreado()

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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : JaUsuariosTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : JaUsuariosTableMap::translateFieldName('Usuario', TableMap::TYPE_PHPNAME, $indexType)];
            $this->usuario = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : JaUsuariosTableMap::translateFieldName('Imagen', TableMap::TYPE_PHPNAME, $indexType)];
            $this->imagen = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : JaUsuariosTableMap::translateFieldName('Nombre', TableMap::TYPE_PHPNAME, $indexType)];
            $this->nombre = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : JaUsuariosTableMap::translateFieldName('Apellidos', TableMap::TYPE_PHPNAME, $indexType)];
            $this->apellidos = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : JaUsuariosTableMap::translateFieldName('Biografia', TableMap::TYPE_PHPNAME, $indexType)];
            $this->biografia = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : JaUsuariosTableMap::translateFieldName('Correo', TableMap::TYPE_PHPNAME, $indexType)];
            $this->correo = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : JaUsuariosTableMap::translateFieldName('Telefono', TableMap::TYPE_PHPNAME, $indexType)];
            $this->telefono = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : JaUsuariosTableMap::translateFieldName('Redessociales', TableMap::TYPE_PHPNAME, $indexType)];
            $this->redessociales = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 9 + $startcol : JaUsuariosTableMap::translateFieldName('Clave', TableMap::TYPE_PHPNAME, $indexType)];
            $this->clave = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 10 + $startcol : JaUsuariosTableMap::translateFieldName('Direccion', TableMap::TYPE_PHPNAME, $indexType)];
            $this->direccion = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 11 + $startcol : JaUsuariosTableMap::translateFieldName('Ciudad', TableMap::TYPE_PHPNAME, $indexType)];
            $this->ciudad = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 12 + $startcol : JaUsuariosTableMap::translateFieldName('Pais', TableMap::TYPE_PHPNAME, $indexType)];
            $this->pais = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 13 + $startcol : JaUsuariosTableMap::translateFieldName('Fechacreado', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->fechacreado = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 14; // 14 = JaUsuariosTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\JaUsuarios'), 0, $e);
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
            $con = Propel::getServiceContainer()->getReadConnection(JaUsuariosTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildJaUsuariosQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collJaAclUsuariosPerfiless = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see JaUsuarios::setDeleted()
     * @see JaUsuarios::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(JaUsuariosTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildJaUsuariosQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(JaUsuariosTableMap::DATABASE_NAME);
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
                JaUsuariosTableMap::addInstanceToPool($this);
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

            if ($this->jaAclUsuariosPerfilessScheduledForDeletion !== null) {
                if (!$this->jaAclUsuariosPerfilessScheduledForDeletion->isEmpty()) {
                    \JaAclUsuariosPerfilesQuery::create()
                        ->filterByPrimaryKeys($this->jaAclUsuariosPerfilessScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->jaAclUsuariosPerfilessScheduledForDeletion = null;
                }
            }

            if ($this->collJaAclUsuariosPerfiless !== null) {
                foreach ($this->collJaAclUsuariosPerfiless as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
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

        $this->modifiedColumns[JaUsuariosTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . JaUsuariosTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(JaUsuariosTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(JaUsuariosTableMap::COL_USUARIO)) {
            $modifiedColumns[':p' . $index++]  = 'usuario';
        }
        if ($this->isColumnModified(JaUsuariosTableMap::COL_IMAGEN)) {
            $modifiedColumns[':p' . $index++]  = 'imagen';
        }
        if ($this->isColumnModified(JaUsuariosTableMap::COL_NOMBRE)) {
            $modifiedColumns[':p' . $index++]  = 'nombre';
        }
        if ($this->isColumnModified(JaUsuariosTableMap::COL_APELLIDOS)) {
            $modifiedColumns[':p' . $index++]  = 'apellidos';
        }
        if ($this->isColumnModified(JaUsuariosTableMap::COL_BIOGRAFIA)) {
            $modifiedColumns[':p' . $index++]  = 'biografia';
        }
        if ($this->isColumnModified(JaUsuariosTableMap::COL_CORREO)) {
            $modifiedColumns[':p' . $index++]  = 'correo';
        }
        if ($this->isColumnModified(JaUsuariosTableMap::COL_TELEFONO)) {
            $modifiedColumns[':p' . $index++]  = 'telefono';
        }
        if ($this->isColumnModified(JaUsuariosTableMap::COL_REDESSOCIALES)) {
            $modifiedColumns[':p' . $index++]  = 'redessociales';
        }
        if ($this->isColumnModified(JaUsuariosTableMap::COL_CLAVE)) {
            $modifiedColumns[':p' . $index++]  = 'clave';
        }
        if ($this->isColumnModified(JaUsuariosTableMap::COL_DIRECCION)) {
            $modifiedColumns[':p' . $index++]  = 'direccion';
        }
        if ($this->isColumnModified(JaUsuariosTableMap::COL_CIUDAD)) {
            $modifiedColumns[':p' . $index++]  = 'ciudad';
        }
        if ($this->isColumnModified(JaUsuariosTableMap::COL_PAIS)) {
            $modifiedColumns[':p' . $index++]  = 'pais';
        }
        if ($this->isColumnModified(JaUsuariosTableMap::COL_FECHACREADO)) {
            $modifiedColumns[':p' . $index++]  = 'fechacreado';
        }

        $sql = sprintf(
            'INSERT INTO ja_usuarios (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'id':                        
                        $stmt->bindValue($identifier, $this->id, PDO::PARAM_INT);
                        break;
                    case 'usuario':                        
                        $stmt->bindValue($identifier, $this->usuario, PDO::PARAM_STR);
                        break;
                    case 'imagen':                        
                        $stmt->bindValue($identifier, $this->imagen, PDO::PARAM_STR);
                        break;
                    case 'nombre':                        
                        $stmt->bindValue($identifier, $this->nombre, PDO::PARAM_STR);
                        break;
                    case 'apellidos':                        
                        $stmt->bindValue($identifier, $this->apellidos, PDO::PARAM_STR);
                        break;
                    case 'biografia':                        
                        $stmt->bindValue($identifier, $this->biografia, PDO::PARAM_STR);
                        break;
                    case 'correo':                        
                        $stmt->bindValue($identifier, $this->correo, PDO::PARAM_STR);
                        break;
                    case 'telefono':                        
                        $stmt->bindValue($identifier, $this->telefono, PDO::PARAM_STR);
                        break;
                    case 'redessociales':                        
                        $stmt->bindValue($identifier, $this->redessociales, PDO::PARAM_STR);
                        break;
                    case 'clave':                        
                        $stmt->bindValue($identifier, $this->clave, PDO::PARAM_STR);
                        break;
                    case 'direccion':                        
                        $stmt->bindValue($identifier, $this->direccion, PDO::PARAM_STR);
                        break;
                    case 'ciudad':                        
                        $stmt->bindValue($identifier, $this->ciudad, PDO::PARAM_STR);
                        break;
                    case 'pais':                        
                        $stmt->bindValue($identifier, $this->pais, PDO::PARAM_STR);
                        break;
                    case 'fechacreado':                        
                        $stmt->bindValue($identifier, $this->fechacreado ? $this->fechacreado->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), 0, $e);
        }

        try {
            $pk = $con->lastInsertId();
        } catch (Exception $e) {
            throw new PropelException('Unable to get autoincrement id.', 0, $e);
        }
        $this->setId($pk);

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
        $pos = JaUsuariosTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getId();
                break;
            case 1:
                return $this->getUsuario();
                break;
            case 2:
                return $this->getImagen();
                break;
            case 3:
                return $this->getNombre();
                break;
            case 4:
                return $this->getApellidos();
                break;
            case 5:
                return $this->getBiografia();
                break;
            case 6:
                return $this->getCorreo();
                break;
            case 7:
                return $this->getTelefono();
                break;
            case 8:
                return $this->getRedessociales();
                break;
            case 9:
                return $this->getClave();
                break;
            case 10:
                return $this->getDireccion();
                break;
            case 11:
                return $this->getCiudad();
                break;
            case 12:
                return $this->getPais();
                break;
            case 13:
                return $this->getFechacreado();
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

        if (isset($alreadyDumpedObjects['JaUsuarios'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['JaUsuarios'][$this->hashCode()] = true;
        $keys = JaUsuariosTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getUsuario(),
            $keys[2] => $this->getImagen(),
            $keys[3] => $this->getNombre(),
            $keys[4] => $this->getApellidos(),
            $keys[5] => $this->getBiografia(),
            $keys[6] => $this->getCorreo(),
            $keys[7] => $this->getTelefono(),
            $keys[8] => $this->getRedessociales(),
            $keys[9] => $this->getClave(),
            $keys[10] => $this->getDireccion(),
            $keys[11] => $this->getCiudad(),
            $keys[12] => $this->getPais(),
            $keys[13] => $this->getFechacreado(),
        );
        if ($result[$keys[13]] instanceof \DateTime) {
            $result[$keys[13]] = $result[$keys[13]]->format('c');
        }
        
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }
        
        if ($includeForeignObjects) {
            if (null !== $this->collJaAclUsuariosPerfiless) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'jaAclUsuariosPerfiless';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'ja_acl_usuarios_perfiless';
                        break;
                    default:
                        $key = 'JaAclUsuariosPerfiless';
                }
        
                $result[$key] = $this->collJaAclUsuariosPerfiless->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\JaUsuarios
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = JaUsuariosTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\JaUsuarios
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setUsuario($value);
                break;
            case 2:
                $this->setImagen($value);
                break;
            case 3:
                $this->setNombre($value);
                break;
            case 4:
                $this->setApellidos($value);
                break;
            case 5:
                $this->setBiografia($value);
                break;
            case 6:
                $this->setCorreo($value);
                break;
            case 7:
                $this->setTelefono($value);
                break;
            case 8:
                $this->setRedessociales($value);
                break;
            case 9:
                $this->setClave($value);
                break;
            case 10:
                $this->setDireccion($value);
                break;
            case 11:
                $this->setCiudad($value);
                break;
            case 12:
                $this->setPais($value);
                break;
            case 13:
                $this->setFechacreado($value);
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
        $keys = JaUsuariosTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setUsuario($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setImagen($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setNombre($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setApellidos($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setBiografia($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setCorreo($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setTelefono($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setRedessociales($arr[$keys[8]]);
        }
        if (array_key_exists($keys[9], $arr)) {
            $this->setClave($arr[$keys[9]]);
        }
        if (array_key_exists($keys[10], $arr)) {
            $this->setDireccion($arr[$keys[10]]);
        }
        if (array_key_exists($keys[11], $arr)) {
            $this->setCiudad($arr[$keys[11]]);
        }
        if (array_key_exists($keys[12], $arr)) {
            $this->setPais($arr[$keys[12]]);
        }
        if (array_key_exists($keys[13], $arr)) {
            $this->setFechacreado($arr[$keys[13]]);
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
     * @return $this|\JaUsuarios The current object, for fluid interface
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
        $criteria = new Criteria(JaUsuariosTableMap::DATABASE_NAME);

        if ($this->isColumnModified(JaUsuariosTableMap::COL_ID)) {
            $criteria->add(JaUsuariosTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(JaUsuariosTableMap::COL_USUARIO)) {
            $criteria->add(JaUsuariosTableMap::COL_USUARIO, $this->usuario);
        }
        if ($this->isColumnModified(JaUsuariosTableMap::COL_IMAGEN)) {
            $criteria->add(JaUsuariosTableMap::COL_IMAGEN, $this->imagen);
        }
        if ($this->isColumnModified(JaUsuariosTableMap::COL_NOMBRE)) {
            $criteria->add(JaUsuariosTableMap::COL_NOMBRE, $this->nombre);
        }
        if ($this->isColumnModified(JaUsuariosTableMap::COL_APELLIDOS)) {
            $criteria->add(JaUsuariosTableMap::COL_APELLIDOS, $this->apellidos);
        }
        if ($this->isColumnModified(JaUsuariosTableMap::COL_BIOGRAFIA)) {
            $criteria->add(JaUsuariosTableMap::COL_BIOGRAFIA, $this->biografia);
        }
        if ($this->isColumnModified(JaUsuariosTableMap::COL_CORREO)) {
            $criteria->add(JaUsuariosTableMap::COL_CORREO, $this->correo);
        }
        if ($this->isColumnModified(JaUsuariosTableMap::COL_TELEFONO)) {
            $criteria->add(JaUsuariosTableMap::COL_TELEFONO, $this->telefono);
        }
        if ($this->isColumnModified(JaUsuariosTableMap::COL_REDESSOCIALES)) {
            $criteria->add(JaUsuariosTableMap::COL_REDESSOCIALES, $this->redessociales);
        }
        if ($this->isColumnModified(JaUsuariosTableMap::COL_CLAVE)) {
            $criteria->add(JaUsuariosTableMap::COL_CLAVE, $this->clave);
        }
        if ($this->isColumnModified(JaUsuariosTableMap::COL_DIRECCION)) {
            $criteria->add(JaUsuariosTableMap::COL_DIRECCION, $this->direccion);
        }
        if ($this->isColumnModified(JaUsuariosTableMap::COL_CIUDAD)) {
            $criteria->add(JaUsuariosTableMap::COL_CIUDAD, $this->ciudad);
        }
        if ($this->isColumnModified(JaUsuariosTableMap::COL_PAIS)) {
            $criteria->add(JaUsuariosTableMap::COL_PAIS, $this->pais);
        }
        if ($this->isColumnModified(JaUsuariosTableMap::COL_FECHACREADO)) {
            $criteria->add(JaUsuariosTableMap::COL_FECHACREADO, $this->fechacreado);
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
        $criteria = ChildJaUsuariosQuery::create();
        $criteria->add(JaUsuariosTableMap::COL_ID, $this->id);

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
        $validPk = null !== $this->getId();

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
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getId();
    }

    /**
     * Generic method to set the primary key (id column).
     *
     * @param       int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \JaUsuarios (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setUsuario($this->getUsuario());
        $copyObj->setImagen($this->getImagen());
        $copyObj->setNombre($this->getNombre());
        $copyObj->setApellidos($this->getApellidos());
        $copyObj->setBiografia($this->getBiografia());
        $copyObj->setCorreo($this->getCorreo());
        $copyObj->setTelefono($this->getTelefono());
        $copyObj->setRedessociales($this->getRedessociales());
        $copyObj->setClave($this->getClave());
        $copyObj->setDireccion($this->getDireccion());
        $copyObj->setCiudad($this->getCiudad());
        $copyObj->setPais($this->getPais());
        $copyObj->setFechacreado($this->getFechacreado());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getJaAclUsuariosPerfiless() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addJaAclUsuariosPerfiles($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setId(NULL); // this is a auto-increment column, so set to default value
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
     * @return \JaUsuarios Clone of current object.
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
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param      string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName)
    {
        if ('JaAclUsuariosPerfiles' == $relationName) {
            return $this->initJaAclUsuariosPerfiless();
        }
    }

    /**
     * Clears out the collJaAclUsuariosPerfiless collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addJaAclUsuariosPerfiless()
     */
    public function clearJaAclUsuariosPerfiless()
    {
        $this->collJaAclUsuariosPerfiless = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collJaAclUsuariosPerfiless collection loaded partially.
     */
    public function resetPartialJaAclUsuariosPerfiless($v = true)
    {
        $this->collJaAclUsuariosPerfilessPartial = $v;
    }

    /**
     * Initializes the collJaAclUsuariosPerfiless collection.
     *
     * By default this just sets the collJaAclUsuariosPerfiless collection to an empty array (like clearcollJaAclUsuariosPerfiless());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initJaAclUsuariosPerfiless($overrideExisting = true)
    {
        if (null !== $this->collJaAclUsuariosPerfiless && !$overrideExisting) {
            return;
        }
        $this->collJaAclUsuariosPerfiless = new ObjectCollection();
        $this->collJaAclUsuariosPerfiless->setModel('\JaAclUsuariosPerfiles');
    }

    /**
     * Gets an array of ChildJaAclUsuariosPerfiles objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildJaUsuarios is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildJaAclUsuariosPerfiles[] List of ChildJaAclUsuariosPerfiles objects
     * @throws PropelException
     */
    public function getJaAclUsuariosPerfiless(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collJaAclUsuariosPerfilessPartial && !$this->isNew();
        if (null === $this->collJaAclUsuariosPerfiless || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collJaAclUsuariosPerfiless) {
                // return empty collection
                $this->initJaAclUsuariosPerfiless();
            } else {
                $collJaAclUsuariosPerfiless = ChildJaAclUsuariosPerfilesQuery::create(null, $criteria)
                    ->filterByJaUsuarios($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collJaAclUsuariosPerfilessPartial && count($collJaAclUsuariosPerfiless)) {
                        $this->initJaAclUsuariosPerfiless(false);

                        foreach ($collJaAclUsuariosPerfiless as $obj) {
                            if (false == $this->collJaAclUsuariosPerfiless->contains($obj)) {
                                $this->collJaAclUsuariosPerfiless->append($obj);
                            }
                        }

                        $this->collJaAclUsuariosPerfilessPartial = true;
                    }

                    return $collJaAclUsuariosPerfiless;
                }

                if ($partial && $this->collJaAclUsuariosPerfiless) {
                    foreach ($this->collJaAclUsuariosPerfiless as $obj) {
                        if ($obj->isNew()) {
                            $collJaAclUsuariosPerfiless[] = $obj;
                        }
                    }
                }

                $this->collJaAclUsuariosPerfiless = $collJaAclUsuariosPerfiless;
                $this->collJaAclUsuariosPerfilessPartial = false;
            }
        }

        return $this->collJaAclUsuariosPerfiless;
    }

    /**
     * Sets a collection of ChildJaAclUsuariosPerfiles objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $jaAclUsuariosPerfiless A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildJaUsuarios The current object (for fluent API support)
     */
    public function setJaAclUsuariosPerfiless(Collection $jaAclUsuariosPerfiless, ConnectionInterface $con = null)
    {
        /** @var ChildJaAclUsuariosPerfiles[] $jaAclUsuariosPerfilessToDelete */
        $jaAclUsuariosPerfilessToDelete = $this->getJaAclUsuariosPerfiless(new Criteria(), $con)->diff($jaAclUsuariosPerfiless);

        
        $this->jaAclUsuariosPerfilessScheduledForDeletion = $jaAclUsuariosPerfilessToDelete;

        foreach ($jaAclUsuariosPerfilessToDelete as $jaAclUsuariosPerfilesRemoved) {
            $jaAclUsuariosPerfilesRemoved->setJaUsuarios(null);
        }

        $this->collJaAclUsuariosPerfiless = null;
        foreach ($jaAclUsuariosPerfiless as $jaAclUsuariosPerfiles) {
            $this->addJaAclUsuariosPerfiles($jaAclUsuariosPerfiles);
        }

        $this->collJaAclUsuariosPerfiless = $jaAclUsuariosPerfiless;
        $this->collJaAclUsuariosPerfilessPartial = false;

        return $this;
    }

    /**
     * Returns the number of related JaAclUsuariosPerfiles objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related JaAclUsuariosPerfiles objects.
     * @throws PropelException
     */
    public function countJaAclUsuariosPerfiless(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collJaAclUsuariosPerfilessPartial && !$this->isNew();
        if (null === $this->collJaAclUsuariosPerfiless || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collJaAclUsuariosPerfiless) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getJaAclUsuariosPerfiless());
            }

            $query = ChildJaAclUsuariosPerfilesQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByJaUsuarios($this)
                ->count($con);
        }

        return count($this->collJaAclUsuariosPerfiless);
    }

    /**
     * Method called to associate a ChildJaAclUsuariosPerfiles object to this object
     * through the ChildJaAclUsuariosPerfiles foreign key attribute.
     *
     * @param  ChildJaAclUsuariosPerfiles $l ChildJaAclUsuariosPerfiles
     * @return $this|\JaUsuarios The current object (for fluent API support)
     */
    public function addJaAclUsuariosPerfiles(ChildJaAclUsuariosPerfiles $l)
    {
        if ($this->collJaAclUsuariosPerfiless === null) {
            $this->initJaAclUsuariosPerfiless();
            $this->collJaAclUsuariosPerfilessPartial = true;
        }

        if (!$this->collJaAclUsuariosPerfiless->contains($l)) {
            $this->doAddJaAclUsuariosPerfiles($l);
        }

        return $this;
    }

    /**
     * @param ChildJaAclUsuariosPerfiles $jaAclUsuariosPerfiles The ChildJaAclUsuariosPerfiles object to add.
     */
    protected function doAddJaAclUsuariosPerfiles(ChildJaAclUsuariosPerfiles $jaAclUsuariosPerfiles)
    {
        $this->collJaAclUsuariosPerfiless[]= $jaAclUsuariosPerfiles;
        $jaAclUsuariosPerfiles->setJaUsuarios($this);
    }

    /**
     * @param  ChildJaAclUsuariosPerfiles $jaAclUsuariosPerfiles The ChildJaAclUsuariosPerfiles object to remove.
     * @return $this|ChildJaUsuarios The current object (for fluent API support)
     */
    public function removeJaAclUsuariosPerfiles(ChildJaAclUsuariosPerfiles $jaAclUsuariosPerfiles)
    {
        if ($this->getJaAclUsuariosPerfiless()->contains($jaAclUsuariosPerfiles)) {
            $pos = $this->collJaAclUsuariosPerfiless->search($jaAclUsuariosPerfiles);
            $this->collJaAclUsuariosPerfiless->remove($pos);
            if (null === $this->jaAclUsuariosPerfilessScheduledForDeletion) {
                $this->jaAclUsuariosPerfilessScheduledForDeletion = clone $this->collJaAclUsuariosPerfiless;
                $this->jaAclUsuariosPerfilessScheduledForDeletion->clear();
            }
            $this->jaAclUsuariosPerfilessScheduledForDeletion[]= clone $jaAclUsuariosPerfiles;
            $jaAclUsuariosPerfiles->setJaUsuarios(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this JaUsuarios is new, it will return
     * an empty collection; or if this JaUsuarios has previously
     * been saved, it will retrieve related JaAclUsuariosPerfiless from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in JaUsuarios.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildJaAclUsuariosPerfiles[] List of ChildJaAclUsuariosPerfiles objects
     */
    public function getJaAclUsuariosPerfilessJoinJaAclPerfiles(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildJaAclUsuariosPerfilesQuery::create(null, $criteria);
        $query->joinWith('JaAclPerfiles', $joinBehavior);

        return $this->getJaAclUsuariosPerfiless($query, $con);
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        $this->id = null;
        $this->usuario = null;
        $this->imagen = null;
        $this->nombre = null;
        $this->apellidos = null;
        $this->biografia = null;
        $this->correo = null;
        $this->telefono = null;
        $this->redessociales = null;
        $this->clave = null;
        $this->direccion = null;
        $this->ciudad = null;
        $this->pais = null;
        $this->fechacreado = null;
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
            if ($this->collJaAclUsuariosPerfiless) {
                foreach ($this->collJaAclUsuariosPerfiless as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collJaAclUsuariosPerfiless = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(JaUsuariosTableMap::DEFAULT_STRING_FORMAT);
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
