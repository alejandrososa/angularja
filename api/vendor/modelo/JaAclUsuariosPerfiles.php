<?php

use Base\JaAclUsuariosPerfiles as BaseJaAclUsuariosPerfiles;

use Monolog\Logger;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Api\Helper;
use App\Config;

/**
 * Skeleton subclass for representing a row from the 'ja_acl_usuarios_perfiles' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class JaAclUsuariosPerfiles extends BaseJaAclUsuariosPerfiles
{
    private $debug;
    private $helper;

    public function __construct()
    {
        $this->helper = new Helper();
        $this->debug = Propel::getWriteConnection(\Map\JaPaginasTableMap::DATABASE_NAME);
        $this->debug->setLogMethods(array(
            'exec',
            'query',
            'execute', // these first three are the default
            'beginTransaction',
            'commit',
            'rollBack',
            'bindValue'
        ));
        $this->debug->useDebug(Config::$DEBUG_SQL);
    }

    public function getPerfilesUsuario($id){
        if(!is_int($id)){
            return null;
        }

        $perfiles =  JaAclUsuariosPerfilesQuery::create()
            ->addAsColumn('Nombre', 'ja_acl_perfiles.Nombre')
            ->addJoin('ja_acl_usuarios_perfiles.usuario_id', 'ja_usuarios.id', Criteria::INNER_JOIN)
            ->addJoin('ja_acl_usuarios_perfiles.perfil_id', 'ja_acl_perfiles.id', Criteria::INNER_JOIN)
            ->groupBy('Nombre')
            ->find();

        if(Config::$DEBUG){
            $this->log(__FUNCTION__ .' | '.$this->debug->getLastExecutedQuery(), Logger::DEBUG);
        }
        return !empty($perfiles) ? $perfiles->toArray() : null;
    }
}
