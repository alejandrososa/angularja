<?php

namespace Base;

use \JaPaginaCategorias as ChildJaPaginaCategorias;
use \JaPaginaCategoriasQuery as ChildJaPaginaCategoriasQuery;
use \JaPaginas as ChildJaPaginas;
use \JaPaginasQuery as ChildJaPaginasQuery;
use \DateTime;
use \Exception;
use \PDO;
use Map\JaPaginasTableMap;
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
 * Base class that represents a row from the 'ja_paginas' table.
 *
 * 
 *
* @package    propel.generator..Base
*/
abstract class JaPaginas implements ActiveRecordInterface 
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\JaPaginasTableMap';


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
     * The value for the titulo field.
     * 
     * @var        string
     */
    protected $titulo;

    /**
     * The value for the contenido field.
     * 
     * @var        string
     */
    protected $contenido;

    /**
     * The value for the imagen field.
     * 
     * @var        string
     */
    protected $imagen;

    /**
     * The value for the leermas field.
     * 
     * @var        string
     */
    protected $leermas;

    /**
     * The value for the estado field.
     * 
     * Note: this column has a database default value of: 'publicado'
     * @var        string
     */
    protected $estado;

    /**
     * The value for the categoria field.
     * 
     * @var        int
     */
    protected $categoria;

    /**
     * The value for the tipo field.
     * 
     * Note: this column has a database default value of: 'articulo'
     * @var        string
     */
    protected $tipo;

    /**
     * The value for the autor field.
     * 
     * Note: this column has a database default value of: 0
     * @var        int
     */
    protected $autor;

    /**
     * The value for the padre field.
     * 
     * Note: this column has a database default value of: '0'
     * @var        string
     */
    protected $padre;

    /**
     * The value for the slug field.
     * 
     * @var        string
     */
    protected $slug;

    /**
     * The value for the meta_descripcion field.
     * 
     * @var        string
     */
    protected $meta_descripcion;

    /**
     * The value for the meta_palabras field.
     * 
     * @var        string
     */
    protected $meta_palabras;

    /**
     * The value for the meta_titulo field.
     * 
     * @var        string
     */
    protected $meta_titulo;

    /**
     * The value for the fecha_creado field.
     * 
     * Note: this column has a database default value of: NULL
     * @var        \DateTime
     */
    protected $fecha_creado;

    /**
     * The value for the fecha_modificado field.
     * 
     * Note: this column has a database default value of: NULL
     * @var        \DateTime
     */
    protected $fecha_modificado;

    /**
     * The value for the configuracion field.
     * 
     * @var        string
     */
    protected $configuracion;

    /**
     * @var        ObjectCollection|ChildJaPaginaCategorias[] Collection to store aggregation of ChildJaPaginaCategorias objects.
     */
    protected $collJaPaginaCategoriass;
    protected $collJaPaginaCategoriassPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildJaPaginaCategorias[]
     */
    protected $jaPaginaCategoriassScheduledForDeletion = null;

    /**
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see __construct()
     */
    public function applyDefaultValues()
    {
        $this->estado = 'publicado';
        $this->tipo = 'articulo';
        $this->autor = 0;
        $this->padre = '0';
        $this->fecha_creado = PropelDateTime::newInstance(NULL, null, 'DateTime');
        $this->fecha_modificado = PropelDateTime::newInstance(NULL, null, 'DateTime');
    }

    /**
     * Initializes internal state of Base\JaPaginas object.
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
     * Compares this with another <code>JaPaginas</code> instance.  If
     * <code>obj</code> is an instance of <code>JaPaginas</code>, delegates to
     * <code>equals(JaPaginas)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|JaPaginas The current object, for fluid interface
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
     * Get the [titulo] column value.
     * 
     * @return string
     */
    public function getTitulo()
    {
        return $this->titulo;
    }

    /**
     * Get the [contenido] column value.
     * 
     * @return string
     */
    public function getContenido()
    {
        return $this->contenido;
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
     * Get the [leermas] column value.
     * 
     * @return string
     */
    public function getLeermas()
    {
        return $this->leermas;
    }

    /**
     * Get the [estado] column value.
     * 
     * @return string
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Get the [categoria] column value.
     * 
     * @return int
     */
    public function getCategoria()
    {
        return $this->categoria;
    }

    /**
     * Get the [tipo] column value.
     * 
     * @return string
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Get the [autor] column value.
     * 
     * @return int
     */
    public function getAutor()
    {
        return $this->autor;
    }

    /**
     * Get the [padre] column value.
     * 
     * @return string
     */
    public function getPadre()
    {
        return $this->padre;
    }

    /**
     * Get the [slug] column value.
     * 
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Get the [meta_descripcion] column value.
     * 
     * @return string
     */
    public function getMetaDescripcion()
    {
        return $this->meta_descripcion;
    }

    /**
     * Get the [meta_palabras] column value.
     * 
     * @return string
     */
    public function getMetaPalabras()
    {
        return $this->meta_palabras;
    }

    /**
     * Get the [meta_titulo] column value.
     * 
     * @return string
     */
    public function getMetaTitulo()
    {
        return $this->meta_titulo;
    }

    /**
     * Get the [optionally formatted] temporal [fecha_creado] column value.
     * 
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getFechaCreado($format = NULL)
    {
        if ($format === null) {
            return $this->fecha_creado;
        } else {
            return $this->fecha_creado instanceof \DateTime ? $this->fecha_creado->format($format) : null;
        }
    }

    /**
     * Get the [optionally formatted] temporal [fecha_modificado] column value.
     * 
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getFechaModificado($format = NULL)
    {
        if ($format === null) {
            return $this->fecha_modificado;
        } else {
            return $this->fecha_modificado instanceof \DateTime ? $this->fecha_modificado->format($format) : null;
        }
    }

    /**
     * Get the [configuracion] column value.
     * 
     * @return string
     */
    public function getConfiguracion()
    {
        return $this->configuracion;
    }

    /**
     * Set the value of [id] column.
     * 
     * @param int $v new value
     * @return $this|\JaPaginas The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[JaPaginasTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [titulo] column.
     * 
     * @param string $v new value
     * @return $this|\JaPaginas The current object (for fluent API support)
     */
    public function setTitulo($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->titulo !== $v) {
            $this->titulo = $v;
            $this->modifiedColumns[JaPaginasTableMap::COL_TITULO] = true;
        }

        return $this;
    } // setTitulo()

    /**
     * Set the value of [contenido] column.
     * 
     * @param string $v new value
     * @return $this|\JaPaginas The current object (for fluent API support)
     */
    public function setContenido($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->contenido !== $v) {
            $this->contenido = $v;
            $this->modifiedColumns[JaPaginasTableMap::COL_CONTENIDO] = true;
        }

        return $this;
    } // setContenido()

    /**
     * Set the value of [imagen] column.
     * 
     * @param string $v new value
     * @return $this|\JaPaginas The current object (for fluent API support)
     */
    public function setImagen($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->imagen !== $v) {
            $this->imagen = $v;
            $this->modifiedColumns[JaPaginasTableMap::COL_IMAGEN] = true;
        }

        return $this;
    } // setImagen()

    /**
     * Set the value of [leermas] column.
     * 
     * @param string $v new value
     * @return $this|\JaPaginas The current object (for fluent API support)
     */
    public function setLeermas($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->leermas !== $v) {
            $this->leermas = $v;
            $this->modifiedColumns[JaPaginasTableMap::COL_LEERMAS] = true;
        }

        return $this;
    } // setLeermas()

    /**
     * Set the value of [estado] column.
     * 
     * @param string $v new value
     * @return $this|\JaPaginas The current object (for fluent API support)
     */
    public function setEstado($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->estado !== $v) {
            $this->estado = $v;
            $this->modifiedColumns[JaPaginasTableMap::COL_ESTADO] = true;
        }

        return $this;
    } // setEstado()

    /**
     * Set the value of [categoria] column.
     * 
     * @param int $v new value
     * @return $this|\JaPaginas The current object (for fluent API support)
     */
    public function setCategoria($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->categoria !== $v) {
            $this->categoria = $v;
            $this->modifiedColumns[JaPaginasTableMap::COL_CATEGORIA] = true;
        }

        return $this;
    } // setCategoria()

    /**
     * Set the value of [tipo] column.
     * 
     * @param string $v new value
     * @return $this|\JaPaginas The current object (for fluent API support)
     */
    public function setTipo($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->tipo !== $v) {
            $this->tipo = $v;
            $this->modifiedColumns[JaPaginasTableMap::COL_TIPO] = true;
        }

        return $this;
    } // setTipo()

    /**
     * Set the value of [autor] column.
     * 
     * @param int $v new value
     * @return $this|\JaPaginas The current object (for fluent API support)
     */
    public function setAutor($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->autor !== $v) {
            $this->autor = $v;
            $this->modifiedColumns[JaPaginasTableMap::COL_AUTOR] = true;
        }

        return $this;
    } // setAutor()

    /**
     * Set the value of [padre] column.
     * 
     * @param string $v new value
     * @return $this|\JaPaginas The current object (for fluent API support)
     */
    public function setPadre($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->padre !== $v) {
            $this->padre = $v;
            $this->modifiedColumns[JaPaginasTableMap::COL_PADRE] = true;
        }

        return $this;
    } // setPadre()

    /**
     * Set the value of [slug] column.
     * 
     * @param string $v new value
     * @return $this|\JaPaginas The current object (for fluent API support)
     */
    public function setSlug($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->slug !== $v) {
            $this->slug = $v;
            $this->modifiedColumns[JaPaginasTableMap::COL_SLUG] = true;
        }

        return $this;
    } // setSlug()

    /**
     * Set the value of [meta_descripcion] column.
     * 
     * @param string $v new value
     * @return $this|\JaPaginas The current object (for fluent API support)
     */
    public function setMetaDescripcion($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->meta_descripcion !== $v) {
            $this->meta_descripcion = $v;
            $this->modifiedColumns[JaPaginasTableMap::COL_META_DESCRIPCION] = true;
        }

        return $this;
    } // setMetaDescripcion()

    /**
     * Set the value of [meta_palabras] column.
     * 
     * @param string $v new value
     * @return $this|\JaPaginas The current object (for fluent API support)
     */
    public function setMetaPalabras($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->meta_palabras !== $v) {
            $this->meta_palabras = $v;
            $this->modifiedColumns[JaPaginasTableMap::COL_META_PALABRAS] = true;
        }

        return $this;
    } // setMetaPalabras()

    /**
     * Set the value of [meta_titulo] column.
     * 
     * @param string $v new value
     * @return $this|\JaPaginas The current object (for fluent API support)
     */
    public function setMetaTitulo($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->meta_titulo !== $v) {
            $this->meta_titulo = $v;
            $this->modifiedColumns[JaPaginasTableMap::COL_META_TITULO] = true;
        }

        return $this;
    } // setMetaTitulo()

    /**
     * Sets the value of [fecha_creado] column to a normalized version of the date/time value specified.
     * 
     * @param  mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return $this|\JaPaginas The current object (for fluent API support)
     */
    public function setFechaCreado($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->fecha_creado !== null || $dt !== null) {
            if ( ($dt != $this->fecha_creado) // normalized values don't match
                || ($dt->format('Y-m-d H:i:s') === NULL) // or the entered value matches the default
                 ) {
                $this->fecha_creado = $dt === null ? null : clone $dt;
                $this->modifiedColumns[JaPaginasTableMap::COL_FECHA_CREADO] = true;
            }
        } // if either are not null

        return $this;
    } // setFechaCreado()

    /**
     * Sets the value of [fecha_modificado] column to a normalized version of the date/time value specified.
     * 
     * @param  mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return $this|\JaPaginas The current object (for fluent API support)
     */
    public function setFechaModificado($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->fecha_modificado !== null || $dt !== null) {
            if ( ($dt != $this->fecha_modificado) // normalized values don't match
                || ($dt->format('Y-m-d H:i:s') === NULL) // or the entered value matches the default
                 ) {
                $this->fecha_modificado = $dt === null ? null : clone $dt;
                $this->modifiedColumns[JaPaginasTableMap::COL_FECHA_MODIFICADO] = true;
            }
        } // if either are not null

        return $this;
    } // setFechaModificado()

    /**
     * Set the value of [configuracion] column.
     * 
     * @param string $v new value
     * @return $this|\JaPaginas The current object (for fluent API support)
     */
    public function setConfiguracion($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->configuracion !== $v) {
            $this->configuracion = $v;
            $this->modifiedColumns[JaPaginasTableMap::COL_CONFIGURACION] = true;
        }

        return $this;
    } // setConfiguracion()

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
            if ($this->estado !== 'publicado') {
                return false;
            }

            if ($this->tipo !== 'articulo') {
                return false;
            }

            if ($this->autor !== 0) {
                return false;
            }

            if ($this->padre !== '0') {
                return false;
            }

            if ($this->fecha_creado && $this->fecha_creado->format('Y-m-d H:i:s') !== NULL) {
                return false;
            }

            if ($this->fecha_modificado && $this->fecha_modificado->format('Y-m-d H:i:s') !== NULL) {
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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : JaPaginasTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : JaPaginasTableMap::translateFieldName('Titulo', TableMap::TYPE_PHPNAME, $indexType)];
            $this->titulo = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : JaPaginasTableMap::translateFieldName('Contenido', TableMap::TYPE_PHPNAME, $indexType)];
            $this->contenido = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : JaPaginasTableMap::translateFieldName('Imagen', TableMap::TYPE_PHPNAME, $indexType)];
            $this->imagen = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : JaPaginasTableMap::translateFieldName('Leermas', TableMap::TYPE_PHPNAME, $indexType)];
            $this->leermas = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : JaPaginasTableMap::translateFieldName('Estado', TableMap::TYPE_PHPNAME, $indexType)];
            $this->estado = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : JaPaginasTableMap::translateFieldName('Categoria', TableMap::TYPE_PHPNAME, $indexType)];
            $this->categoria = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : JaPaginasTableMap::translateFieldName('Tipo', TableMap::TYPE_PHPNAME, $indexType)];
            $this->tipo = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : JaPaginasTableMap::translateFieldName('Autor', TableMap::TYPE_PHPNAME, $indexType)];
            $this->autor = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 9 + $startcol : JaPaginasTableMap::translateFieldName('Padre', TableMap::TYPE_PHPNAME, $indexType)];
            $this->padre = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 10 + $startcol : JaPaginasTableMap::translateFieldName('Slug', TableMap::TYPE_PHPNAME, $indexType)];
            $this->slug = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 11 + $startcol : JaPaginasTableMap::translateFieldName('MetaDescripcion', TableMap::TYPE_PHPNAME, $indexType)];
            $this->meta_descripcion = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 12 + $startcol : JaPaginasTableMap::translateFieldName('MetaPalabras', TableMap::TYPE_PHPNAME, $indexType)];
            $this->meta_palabras = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 13 + $startcol : JaPaginasTableMap::translateFieldName('MetaTitulo', TableMap::TYPE_PHPNAME, $indexType)];
            $this->meta_titulo = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 14 + $startcol : JaPaginasTableMap::translateFieldName('FechaCreado', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->fecha_creado = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 15 + $startcol : JaPaginasTableMap::translateFieldName('FechaModificado', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->fecha_modificado = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 16 + $startcol : JaPaginasTableMap::translateFieldName('Configuracion', TableMap::TYPE_PHPNAME, $indexType)];
            $this->configuracion = (null !== $col) ? (string) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 17; // 17 = JaPaginasTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\JaPaginas'), 0, $e);
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
            $con = Propel::getServiceContainer()->getReadConnection(JaPaginasTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildJaPaginasQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collJaPaginaCategoriass = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see JaPaginas::setDeleted()
     * @see JaPaginas::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(JaPaginasTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildJaPaginasQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(JaPaginasTableMap::DATABASE_NAME);
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
                JaPaginasTableMap::addInstanceToPool($this);
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

            if ($this->jaPaginaCategoriassScheduledForDeletion !== null) {
                if (!$this->jaPaginaCategoriassScheduledForDeletion->isEmpty()) {
                    \JaPaginaCategoriasQuery::create()
                        ->filterByPrimaryKeys($this->jaPaginaCategoriassScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->jaPaginaCategoriassScheduledForDeletion = null;
                }
            }

            if ($this->collJaPaginaCategoriass !== null) {
                foreach ($this->collJaPaginaCategoriass as $referrerFK) {
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

        $this->modifiedColumns[JaPaginasTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . JaPaginasTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(JaPaginasTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(JaPaginasTableMap::COL_TITULO)) {
            $modifiedColumns[':p' . $index++]  = 'titulo';
        }
        if ($this->isColumnModified(JaPaginasTableMap::COL_CONTENIDO)) {
            $modifiedColumns[':p' . $index++]  = 'contenido';
        }
        if ($this->isColumnModified(JaPaginasTableMap::COL_IMAGEN)) {
            $modifiedColumns[':p' . $index++]  = 'imagen';
        }
        if ($this->isColumnModified(JaPaginasTableMap::COL_LEERMAS)) {
            $modifiedColumns[':p' . $index++]  = 'leermas';
        }
        if ($this->isColumnModified(JaPaginasTableMap::COL_ESTADO)) {
            $modifiedColumns[':p' . $index++]  = 'estado';
        }
        if ($this->isColumnModified(JaPaginasTableMap::COL_CATEGORIA)) {
            $modifiedColumns[':p' . $index++]  = 'categoria';
        }
        if ($this->isColumnModified(JaPaginasTableMap::COL_TIPO)) {
            $modifiedColumns[':p' . $index++]  = 'tipo';
        }
        if ($this->isColumnModified(JaPaginasTableMap::COL_AUTOR)) {
            $modifiedColumns[':p' . $index++]  = 'autor';
        }
        if ($this->isColumnModified(JaPaginasTableMap::COL_PADRE)) {
            $modifiedColumns[':p' . $index++]  = 'padre';
        }
        if ($this->isColumnModified(JaPaginasTableMap::COL_SLUG)) {
            $modifiedColumns[':p' . $index++]  = 'slug';
        }
        if ($this->isColumnModified(JaPaginasTableMap::COL_META_DESCRIPCION)) {
            $modifiedColumns[':p' . $index++]  = 'meta_descripcion';
        }
        if ($this->isColumnModified(JaPaginasTableMap::COL_META_PALABRAS)) {
            $modifiedColumns[':p' . $index++]  = 'meta_palabras';
        }
        if ($this->isColumnModified(JaPaginasTableMap::COL_META_TITULO)) {
            $modifiedColumns[':p' . $index++]  = 'meta_titulo';
        }
        if ($this->isColumnModified(JaPaginasTableMap::COL_FECHA_CREADO)) {
            $modifiedColumns[':p' . $index++]  = 'fecha_creado';
        }
        if ($this->isColumnModified(JaPaginasTableMap::COL_FECHA_MODIFICADO)) {
            $modifiedColumns[':p' . $index++]  = 'fecha_modificado';
        }
        if ($this->isColumnModified(JaPaginasTableMap::COL_CONFIGURACION)) {
            $modifiedColumns[':p' . $index++]  = 'configuracion';
        }

        $sql = sprintf(
            'INSERT INTO ja_paginas (%s) VALUES (%s)',
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
                    case 'titulo':                        
                        $stmt->bindValue($identifier, $this->titulo, PDO::PARAM_STR);
                        break;
                    case 'contenido':                        
                        $stmt->bindValue($identifier, $this->contenido, PDO::PARAM_STR);
                        break;
                    case 'imagen':                        
                        $stmt->bindValue($identifier, $this->imagen, PDO::PARAM_STR);
                        break;
                    case 'leermas':                        
                        $stmt->bindValue($identifier, $this->leermas, PDO::PARAM_STR);
                        break;
                    case 'estado':                        
                        $stmt->bindValue($identifier, $this->estado, PDO::PARAM_STR);
                        break;
                    case 'categoria':                        
                        $stmt->bindValue($identifier, $this->categoria, PDO::PARAM_INT);
                        break;
                    case 'tipo':                        
                        $stmt->bindValue($identifier, $this->tipo, PDO::PARAM_STR);
                        break;
                    case 'autor':                        
                        $stmt->bindValue($identifier, $this->autor, PDO::PARAM_INT);
                        break;
                    case 'padre':                        
                        $stmt->bindValue($identifier, $this->padre, PDO::PARAM_INT);
                        break;
                    case 'slug':                        
                        $stmt->bindValue($identifier, $this->slug, PDO::PARAM_STR);
                        break;
                    case 'meta_descripcion':                        
                        $stmt->bindValue($identifier, $this->meta_descripcion, PDO::PARAM_STR);
                        break;
                    case 'meta_palabras':                        
                        $stmt->bindValue($identifier, $this->meta_palabras, PDO::PARAM_STR);
                        break;
                    case 'meta_titulo':                        
                        $stmt->bindValue($identifier, $this->meta_titulo, PDO::PARAM_STR);
                        break;
                    case 'fecha_creado':                        
                        $stmt->bindValue($identifier, $this->fecha_creado ? $this->fecha_creado->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
                        break;
                    case 'fecha_modificado':                        
                        $stmt->bindValue($identifier, $this->fecha_modificado ? $this->fecha_modificado->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
                        break;
                    case 'configuracion':                        
                        $stmt->bindValue($identifier, $this->configuracion, PDO::PARAM_STR);
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
        $pos = JaPaginasTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getTitulo();
                break;
            case 2:
                return $this->getContenido();
                break;
            case 3:
                return $this->getImagen();
                break;
            case 4:
                return $this->getLeermas();
                break;
            case 5:
                return $this->getEstado();
                break;
            case 6:
                return $this->getCategoria();
                break;
            case 7:
                return $this->getTipo();
                break;
            case 8:
                return $this->getAutor();
                break;
            case 9:
                return $this->getPadre();
                break;
            case 10:
                return $this->getSlug();
                break;
            case 11:
                return $this->getMetaDescripcion();
                break;
            case 12:
                return $this->getMetaPalabras();
                break;
            case 13:
                return $this->getMetaTitulo();
                break;
            case 14:
                return $this->getFechaCreado();
                break;
            case 15:
                return $this->getFechaModificado();
                break;
            case 16:
                return $this->getConfiguracion();
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

        if (isset($alreadyDumpedObjects['JaPaginas'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['JaPaginas'][$this->hashCode()] = true;
        $keys = JaPaginasTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getTitulo(),
            $keys[2] => $this->getContenido(),
            $keys[3] => $this->getImagen(),
            $keys[4] => $this->getLeermas(),
            $keys[5] => $this->getEstado(),
            $keys[6] => $this->getCategoria(),
            $keys[7] => $this->getTipo(),
            $keys[8] => $this->getAutor(),
            $keys[9] => $this->getPadre(),
            $keys[10] => $this->getSlug(),
            $keys[11] => $this->getMetaDescripcion(),
            $keys[12] => $this->getMetaPalabras(),
            $keys[13] => $this->getMetaTitulo(),
            $keys[14] => $this->getFechaCreado(),
            $keys[15] => $this->getFechaModificado(),
            $keys[16] => $this->getConfiguracion(),
        );
        if ($result[$keys[14]] instanceof \DateTime) {
            $result[$keys[14]] = $result[$keys[14]]->format('c');
        }
        
        if ($result[$keys[15]] instanceof \DateTime) {
            $result[$keys[15]] = $result[$keys[15]]->format('c');
        }
        
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }
        
        if ($includeForeignObjects) {
            if (null !== $this->collJaPaginaCategoriass) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'jaPaginaCategoriass';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'ja_pagina_categoriass';
                        break;
                    default:
                        $key = 'JaPaginaCategoriass';
                }
        
                $result[$key] = $this->collJaPaginaCategoriass->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\JaPaginas
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = JaPaginasTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\JaPaginas
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setTitulo($value);
                break;
            case 2:
                $this->setContenido($value);
                break;
            case 3:
                $this->setImagen($value);
                break;
            case 4:
                $this->setLeermas($value);
                break;
            case 5:
                $this->setEstado($value);
                break;
            case 6:
                $this->setCategoria($value);
                break;
            case 7:
                $this->setTipo($value);
                break;
            case 8:
                $this->setAutor($value);
                break;
            case 9:
                $this->setPadre($value);
                break;
            case 10:
                $this->setSlug($value);
                break;
            case 11:
                $this->setMetaDescripcion($value);
                break;
            case 12:
                $this->setMetaPalabras($value);
                break;
            case 13:
                $this->setMetaTitulo($value);
                break;
            case 14:
                $this->setFechaCreado($value);
                break;
            case 15:
                $this->setFechaModificado($value);
                break;
            case 16:
                $this->setConfiguracion($value);
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
        $keys = JaPaginasTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setTitulo($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setContenido($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setImagen($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setLeermas($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setEstado($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setCategoria($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setTipo($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setAutor($arr[$keys[8]]);
        }
        if (array_key_exists($keys[9], $arr)) {
            $this->setPadre($arr[$keys[9]]);
        }
        if (array_key_exists($keys[10], $arr)) {
            $this->setSlug($arr[$keys[10]]);
        }
        if (array_key_exists($keys[11], $arr)) {
            $this->setMetaDescripcion($arr[$keys[11]]);
        }
        if (array_key_exists($keys[12], $arr)) {
            $this->setMetaPalabras($arr[$keys[12]]);
        }
        if (array_key_exists($keys[13], $arr)) {
            $this->setMetaTitulo($arr[$keys[13]]);
        }
        if (array_key_exists($keys[14], $arr)) {
            $this->setFechaCreado($arr[$keys[14]]);
        }
        if (array_key_exists($keys[15], $arr)) {
            $this->setFechaModificado($arr[$keys[15]]);
        }
        if (array_key_exists($keys[16], $arr)) {
            $this->setConfiguracion($arr[$keys[16]]);
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
     * @return $this|\JaPaginas The current object, for fluid interface
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
        $criteria = new Criteria(JaPaginasTableMap::DATABASE_NAME);

        if ($this->isColumnModified(JaPaginasTableMap::COL_ID)) {
            $criteria->add(JaPaginasTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(JaPaginasTableMap::COL_TITULO)) {
            $criteria->add(JaPaginasTableMap::COL_TITULO, $this->titulo);
        }
        if ($this->isColumnModified(JaPaginasTableMap::COL_CONTENIDO)) {
            $criteria->add(JaPaginasTableMap::COL_CONTENIDO, $this->contenido);
        }
        if ($this->isColumnModified(JaPaginasTableMap::COL_IMAGEN)) {
            $criteria->add(JaPaginasTableMap::COL_IMAGEN, $this->imagen);
        }
        if ($this->isColumnModified(JaPaginasTableMap::COL_LEERMAS)) {
            $criteria->add(JaPaginasTableMap::COL_LEERMAS, $this->leermas);
        }
        if ($this->isColumnModified(JaPaginasTableMap::COL_ESTADO)) {
            $criteria->add(JaPaginasTableMap::COL_ESTADO, $this->estado);
        }
        if ($this->isColumnModified(JaPaginasTableMap::COL_CATEGORIA)) {
            $criteria->add(JaPaginasTableMap::COL_CATEGORIA, $this->categoria);
        }
        if ($this->isColumnModified(JaPaginasTableMap::COL_TIPO)) {
            $criteria->add(JaPaginasTableMap::COL_TIPO, $this->tipo);
        }
        if ($this->isColumnModified(JaPaginasTableMap::COL_AUTOR)) {
            $criteria->add(JaPaginasTableMap::COL_AUTOR, $this->autor);
        }
        if ($this->isColumnModified(JaPaginasTableMap::COL_PADRE)) {
            $criteria->add(JaPaginasTableMap::COL_PADRE, $this->padre);
        }
        if ($this->isColumnModified(JaPaginasTableMap::COL_SLUG)) {
            $criteria->add(JaPaginasTableMap::COL_SLUG, $this->slug);
        }
        if ($this->isColumnModified(JaPaginasTableMap::COL_META_DESCRIPCION)) {
            $criteria->add(JaPaginasTableMap::COL_META_DESCRIPCION, $this->meta_descripcion);
        }
        if ($this->isColumnModified(JaPaginasTableMap::COL_META_PALABRAS)) {
            $criteria->add(JaPaginasTableMap::COL_META_PALABRAS, $this->meta_palabras);
        }
        if ($this->isColumnModified(JaPaginasTableMap::COL_META_TITULO)) {
            $criteria->add(JaPaginasTableMap::COL_META_TITULO, $this->meta_titulo);
        }
        if ($this->isColumnModified(JaPaginasTableMap::COL_FECHA_CREADO)) {
            $criteria->add(JaPaginasTableMap::COL_FECHA_CREADO, $this->fecha_creado);
        }
        if ($this->isColumnModified(JaPaginasTableMap::COL_FECHA_MODIFICADO)) {
            $criteria->add(JaPaginasTableMap::COL_FECHA_MODIFICADO, $this->fecha_modificado);
        }
        if ($this->isColumnModified(JaPaginasTableMap::COL_CONFIGURACION)) {
            $criteria->add(JaPaginasTableMap::COL_CONFIGURACION, $this->configuracion);
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
        $criteria = ChildJaPaginasQuery::create();
        $criteria->add(JaPaginasTableMap::COL_ID, $this->id);

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
     * @param      object $copyObj An object of \JaPaginas (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setTitulo($this->getTitulo());
        $copyObj->setContenido($this->getContenido());
        $copyObj->setImagen($this->getImagen());
        $copyObj->setLeermas($this->getLeermas());
        $copyObj->setEstado($this->getEstado());
        $copyObj->setCategoria($this->getCategoria());
        $copyObj->setTipo($this->getTipo());
        $copyObj->setAutor($this->getAutor());
        $copyObj->setPadre($this->getPadre());
        $copyObj->setSlug($this->getSlug());
        $copyObj->setMetaDescripcion($this->getMetaDescripcion());
        $copyObj->setMetaPalabras($this->getMetaPalabras());
        $copyObj->setMetaTitulo($this->getMetaTitulo());
        $copyObj->setFechaCreado($this->getFechaCreado());
        $copyObj->setFechaModificado($this->getFechaModificado());
        $copyObj->setConfiguracion($this->getConfiguracion());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getJaPaginaCategoriass() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addJaPaginaCategorias($relObj->copy($deepCopy));
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
     * @return \JaPaginas Clone of current object.
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
        if ('JaPaginaCategorias' == $relationName) {
            return $this->initJaPaginaCategoriass();
        }
    }

    /**
     * Clears out the collJaPaginaCategoriass collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addJaPaginaCategoriass()
     */
    public function clearJaPaginaCategoriass()
    {
        $this->collJaPaginaCategoriass = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collJaPaginaCategoriass collection loaded partially.
     */
    public function resetPartialJaPaginaCategoriass($v = true)
    {
        $this->collJaPaginaCategoriassPartial = $v;
    }

    /**
     * Initializes the collJaPaginaCategoriass collection.
     *
     * By default this just sets the collJaPaginaCategoriass collection to an empty array (like clearcollJaPaginaCategoriass());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initJaPaginaCategoriass($overrideExisting = true)
    {
        if (null !== $this->collJaPaginaCategoriass && !$overrideExisting) {
            return;
        }
        $this->collJaPaginaCategoriass = new ObjectCollection();
        $this->collJaPaginaCategoriass->setModel('\JaPaginaCategorias');
    }

    /**
     * Gets an array of ChildJaPaginaCategorias objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildJaPaginas is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildJaPaginaCategorias[] List of ChildJaPaginaCategorias objects
     * @throws PropelException
     */
    public function getJaPaginaCategoriass(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collJaPaginaCategoriassPartial && !$this->isNew();
        if (null === $this->collJaPaginaCategoriass || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collJaPaginaCategoriass) {
                // return empty collection
                $this->initJaPaginaCategoriass();
            } else {
                $collJaPaginaCategoriass = ChildJaPaginaCategoriasQuery::create(null, $criteria)
                    ->filterByJaPaginas($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collJaPaginaCategoriassPartial && count($collJaPaginaCategoriass)) {
                        $this->initJaPaginaCategoriass(false);

                        foreach ($collJaPaginaCategoriass as $obj) {
                            if (false == $this->collJaPaginaCategoriass->contains($obj)) {
                                $this->collJaPaginaCategoriass->append($obj);
                            }
                        }

                        $this->collJaPaginaCategoriassPartial = true;
                    }

                    return $collJaPaginaCategoriass;
                }

                if ($partial && $this->collJaPaginaCategoriass) {
                    foreach ($this->collJaPaginaCategoriass as $obj) {
                        if ($obj->isNew()) {
                            $collJaPaginaCategoriass[] = $obj;
                        }
                    }
                }

                $this->collJaPaginaCategoriass = $collJaPaginaCategoriass;
                $this->collJaPaginaCategoriassPartial = false;
            }
        }

        return $this->collJaPaginaCategoriass;
    }

    /**
     * Sets a collection of ChildJaPaginaCategorias objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $jaPaginaCategoriass A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildJaPaginas The current object (for fluent API support)
     */
    public function setJaPaginaCategoriass(Collection $jaPaginaCategoriass, ConnectionInterface $con = null)
    {
        /** @var ChildJaPaginaCategorias[] $jaPaginaCategoriassToDelete */
        $jaPaginaCategoriassToDelete = $this->getJaPaginaCategoriass(new Criteria(), $con)->diff($jaPaginaCategoriass);

        
        $this->jaPaginaCategoriassScheduledForDeletion = $jaPaginaCategoriassToDelete;

        foreach ($jaPaginaCategoriassToDelete as $jaPaginaCategoriasRemoved) {
            $jaPaginaCategoriasRemoved->setJaPaginas(null);
        }

        $this->collJaPaginaCategoriass = null;
        foreach ($jaPaginaCategoriass as $jaPaginaCategorias) {
            $this->addJaPaginaCategorias($jaPaginaCategorias);
        }

        $this->collJaPaginaCategoriass = $jaPaginaCategoriass;
        $this->collJaPaginaCategoriassPartial = false;

        return $this;
    }

    /**
     * Returns the number of related JaPaginaCategorias objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related JaPaginaCategorias objects.
     * @throws PropelException
     */
    public function countJaPaginaCategoriass(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collJaPaginaCategoriassPartial && !$this->isNew();
        if (null === $this->collJaPaginaCategoriass || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collJaPaginaCategoriass) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getJaPaginaCategoriass());
            }

            $query = ChildJaPaginaCategoriasQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByJaPaginas($this)
                ->count($con);
        }

        return count($this->collJaPaginaCategoriass);
    }

    /**
     * Method called to associate a ChildJaPaginaCategorias object to this object
     * through the ChildJaPaginaCategorias foreign key attribute.
     *
     * @param  ChildJaPaginaCategorias $l ChildJaPaginaCategorias
     * @return $this|\JaPaginas The current object (for fluent API support)
     */
    public function addJaPaginaCategorias(ChildJaPaginaCategorias $l)
    {
        if ($this->collJaPaginaCategoriass === null) {
            $this->initJaPaginaCategoriass();
            $this->collJaPaginaCategoriassPartial = true;
        }

        if (!$this->collJaPaginaCategoriass->contains($l)) {
            $this->doAddJaPaginaCategorias($l);
        }

        return $this;
    }

    /**
     * @param ChildJaPaginaCategorias $jaPaginaCategorias The ChildJaPaginaCategorias object to add.
     */
    protected function doAddJaPaginaCategorias(ChildJaPaginaCategorias $jaPaginaCategorias)
    {
        $this->collJaPaginaCategoriass[]= $jaPaginaCategorias;
        $jaPaginaCategorias->setJaPaginas($this);
    }

    /**
     * @param  ChildJaPaginaCategorias $jaPaginaCategorias The ChildJaPaginaCategorias object to remove.
     * @return $this|ChildJaPaginas The current object (for fluent API support)
     */
    public function removeJaPaginaCategorias(ChildJaPaginaCategorias $jaPaginaCategorias)
    {
        if ($this->getJaPaginaCategoriass()->contains($jaPaginaCategorias)) {
            $pos = $this->collJaPaginaCategoriass->search($jaPaginaCategorias);
            $this->collJaPaginaCategoriass->remove($pos);
            if (null === $this->jaPaginaCategoriassScheduledForDeletion) {
                $this->jaPaginaCategoriassScheduledForDeletion = clone $this->collJaPaginaCategoriass;
                $this->jaPaginaCategoriassScheduledForDeletion->clear();
            }
            $this->jaPaginaCategoriassScheduledForDeletion[]= clone $jaPaginaCategorias;
            $jaPaginaCategorias->setJaPaginas(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this JaPaginas is new, it will return
     * an empty collection; or if this JaPaginas has previously
     * been saved, it will retrieve related JaPaginaCategoriass from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in JaPaginas.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildJaPaginaCategorias[] List of ChildJaPaginaCategorias objects
     */
    public function getJaPaginaCategoriassJoinJaCategorias(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildJaPaginaCategoriasQuery::create(null, $criteria);
        $query->joinWith('JaCategorias', $joinBehavior);

        return $this->getJaPaginaCategoriass($query, $con);
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        $this->id = null;
        $this->titulo = null;
        $this->contenido = null;
        $this->imagen = null;
        $this->leermas = null;
        $this->estado = null;
        $this->categoria = null;
        $this->tipo = null;
        $this->autor = null;
        $this->padre = null;
        $this->slug = null;
        $this->meta_descripcion = null;
        $this->meta_palabras = null;
        $this->meta_titulo = null;
        $this->fecha_creado = null;
        $this->fecha_modificado = null;
        $this->configuracion = null;
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
            if ($this->collJaPaginaCategoriass) {
                foreach ($this->collJaPaginaCategoriass as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collJaPaginaCategoriass = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(JaPaginasTableMap::DEFAULT_STRING_FORMAT);
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
