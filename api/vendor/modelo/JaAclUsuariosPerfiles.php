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

        $perfiles =
            //JaAclUsuariosPerfilesQuery::create()
            //->joinWithJaAclPerfiles()
            //->select(array('usuario_id','ja_acl_perfiles.nombre'))
            //->filterByUsuarioId($id, Criteria::EQUAL)

            JaAclPerfilesQuery::create()
            ->joinJaAclUsuariosPerfiles('up', Criteria::INNER_JOIN)
            ->select(array('up.usuario_id','nombre'))
            ->useJaAclUsuariosPerfilesQuery()
                ->filterByUsuarioId($id, Criteria::EQUAL)
            ->endUse()
            ->find();

        $_perfiles = [];
        foreach ($perfiles as $perfil) {
            $_perfiles[] = array('id'=> $perfil['up.usuario_id'], 'nombre'=> $perfil['nombre']);
        }

        if(Config::$DEBUG){
            $this->log(__FUNCTION__ .' | '.$this->debug->getLastExecutedQuery(), Logger::DEBUG);
        }
        return $perfiles->isEmpty() ? null : $_perfiles; //$perfiles->toArray();
    }
}
