<?php

namespace App\Models\Base;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Zizaco\Entrust\Traits\EntrustUserTrait;

use App\Models\BaseModel;

use Validator, DB, Cache;

class Tercero extends BaseModel implements AuthenticatableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, CanResetPassword;
    use EntrustUserTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tercero';

    /**
     * The key used by cache store.
     *
     * @var static string
     */
    public static $key_cache_tadministrators = '_technical_administrators';
    public static $key_cache_badvisors = '_business_advisors';
    public static $key_cache_sellers = '_sellers';
    public static $key_cache_technicals = '_technicals';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['tercero_nit', 'tercero_digito', 'tercero_tipo', 'tercero_regimen', 'tercero_persona', 'tercero_nombre1', 'tercero_nombre2', 'tercero_apellido1', 'tercero_apellido2', 'tercero_razonsocial', 'tercero_direccion','tercero_dir_nomenclatura', 'tercero_municipio','tercero_pais', 'tercero_direccion', 'tercero_email', 'tercero_representante', 'tercero_cc_representante', 'tercero_telefono1', 'tercero_telefono2', 'tercero_fax', 'tercero_celular', 'tercero_actividad', 'tercero_cual', 'tercero_coordinador_por','tercero_sucursal','tercero_familia'];

    /**
     * The attributes that are mass boolean assignable.
     *
     * @var array
     */
    protected $boolean = ['tercero_activo', 'tercero_responsable_iva', 'tercero_autoretenedor_cree', 'tercero_gran_contribuyente', 'tercero_autoretenedor_renta', 'tercero_autoretenedor_ica', 'tercero_socio', 'tercero_cliente', 'tercero_acreedor', 'tercero_interno', 'tercero_mandatario', 'tercero_empleado', 'tercero_proveedor', 'tercero_extranjero', 'tercero_afiliado', 'tercero_tecnico', 'tercero_vendedor', 'tercero_coordinador', 'tercero_otro'];

    /**
     * The attributes that are mass nullable fields to null.
     *
     * @var array
     */
    protected $nullable = ['tercero_coordinador_por','tercero_sucursal','tercero_pais'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];
    

    public function isValid($data)
    {
        $rules = [
            'tercero_nit' => 'required|max:15|min:1|unique:tercero',
            'tercero_digito' => 'required',
            'tercero_tipo' => 'required',
            'tercero_regimen' => 'required',
            'tercero_persona' => 'required',
            'tercero_direccion' => 'required',
            'tercero_municipio' => 'required',
            'tercero_actividad' => 'required',
        ];

        if ($this->exists){
            $rules['tercero_nit'] .= ',tercero_nit,' . $this->id;
        }else{
            $rules['tercero_nit'] .= '|required';
        }

        $validator = Validator::make($data, $rules);
        if ($validator->passes())
        {
            if( $this->exists ){
                if( isset($data['tercero_empleado']) || isset($data['tercero_interno']) )  {
                    if( empty($data['tercero_sucursal']) ){
                        $this->errors = trans('validation.required', ['attribute' => 'sucursal de la pestaña empleado']);
                        return false;
                    }
                }

                if( !empty($data['tercero_coordinador_por']) ) {
                    if( !isset($data['tercero_tecnico']) && !isset($data['tercero_vendedor']) ){
                        $this->errors = trans('validation.required', ['attribute' => 'coordinador no es valido, se requiere ser vendedor o tecnico, ']);
                        return false;
                    }
                }

                if( isset($data['tercero_tecnico']) || isset($data['tercero_vendedor']) ){
                    if( empty($data['tercero_coordinador_por']) ){
                        $this->errors = trans('validation.required', ['attribute' => 'coordinador por es requerido cuando es vendedor o tecnico,']);
                        return false;
                    }
                }
            }

            if(!isset($data['empresa_niif'])){
                if($data['tercero_persona'] == 'N') {
                    if(empty($data['tercero_nombre1'])) {
                        $this->errors = trans('validation.required', ['attribute' => '1er. Nombre']);
                        return false;
                    }
                    if(empty($data['tercero_apellido1'])) {
                        $this->errors = trans('validation.required', ['attribute' => '1er. Apellido']);
                        return false;
                    }
                }else{
                    if(empty($data['tercero_razonsocial'])) {
                        $this->errors = trans('validation.required', ['attribute' => 'Razón Social, Comercial o Establecimiento']);
                        return false;
                    }
                }
            }

            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }

    public function isValidPass($data)
    {
        $rules = [
            'username' => 'required|min:4|max:20|unique:tercero',
            'password' => 'min:6|max:15|confirmed'
        ];

        if ($this->exists){
            $rules['username'] .= ',username,' . $this->id;
        }

        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }
    public static function isValidNit($nit)
    {   
        $rules = [
            'tercero_nit' => 'required|max:15|min:1|unique:tercero'
        ];

        $validator = Validator::make($nit, $rules);
        if ($validator->passes()) {
            return true;
        }
        return false;
    }
    public static function getTercero($id)
    {
        $query = Tercero::query();
        $query->select('tercero.*', 'sucursal_nombre', 'actividad_nombre','actividad_codigo', 'actividad_tarifa', DB::raw("CONCAT(municipio_nombre, ' - ', departamento_nombre) as municipio_nombre"), DB::raw("CONCAT(pais_codigo, ' - ', pais_nombre) as pais_nombre"),DB::raw("(CASE WHEN tc.tercero_persona = 'N'
                    THEN CONCAT(tc.tercero_nombre1,' ',tc.tercero_nombre2,' ',tc.tercero_apellido1,' ',tc.tercero_apellido2,
                            (CASE WHEN (tc.tercero_razonsocial IS NOT NULL AND tc.tercero_razonsocial != '') THEN CONCAT(' - ', tc.tercero_razonsocial) ELSE '' END)
                        )
                    ELSE tc.tercero_razonsocial END)
                AS nombre_coordinador"));
        $query->leftJoin('sucursal', 'tercero_sucursal', '=', 'sucursal.id');
        $query->leftJoin('actividad', 'tercero_actividad', '=', 'actividad.id');
        $query->leftJoin('municipio', 'tercero_municipio', '=', 'municipio.id');
        $query->leftJoin('pais', 'tercero_pais', '=', 'pais.id');
        $query->leftJoin('departamento', 'municipio.departamento_codigo', '=', 'departamento.departamento_codigo');
        $query->leftJoin('tercero as tc', 'tercero.tercero_coordinador_por', '=', 'tc.id');
        $query->where('tercero.id', $id);
        return $query->first();
    }

    public function getName()
    {
        return $this->attributes['tercero_razonsocial'] ? $this->attributes['tercero_razonsocial'] : sprintf('%s %s %s %s', $this->attributes['tercero_nombre1'], $this->attributes['tercero_nombre2'] , $this->attributes['tercero_apellido1'], $this->attributes['tercero_apellido2']);
    }

    public static function getTechnicalAdministrators()
    {
        if (Cache::has(self::$key_cache_tadministrators)) {
            return Cache::get(self::$key_cache_tadministrators);
        }

        return Cache::rememberForever(self::$key_cache_tadministrators, function() {
            $query = Tercero::query();
            $query->select('id',
                DB::raw("(CASE WHEN tercero_persona = 'N'
                    THEN CONCAT(tercero_nombre1,' ',tercero_nombre2,' ',tercero_apellido1,' ',tercero_apellido2,
                            (CASE WHEN (tercero_razonsocial IS NOT NULL AND tercero_razonsocial != '') THEN CONCAT(' - ', tercero_razonsocial) ELSE '' END)
                        )
                    ELSE tercero_razonsocial END)
                AS tercero_nombre")
            );
            $query->where('tercero_activo', true);
            $query->where('tercero_coordinador', true);
            $query->orderby('tercero_nombre', 'asc');
            $collection = $query->lists('tercero_nombre', 'id');

            $collection->prepend('', '');
            return $collection;
        });
    }
    public static function getTechnicals()
    {
        if (Cache::has(self::$key_cache_technicals)) {
            return Cache::get(self::$key_cache_technicals);
        }

        return Cache::rememberForever(self::$key_cache_technicals, function() {
            $query = Tercero::query();
            $query->select('id',
                DB::raw("(CASE WHEN tercero_persona = 'N'
                    THEN CONCAT(tercero_nombre1,' ',tercero_nombre2,' ',tercero_apellido1,' ',tercero_apellido2,
                            (CASE WHEN (tercero_razonsocial IS NOT NULL AND tercero_razonsocial != '') THEN CONCAT(' - ', tercero_razonsocial) ELSE '' END)
                        )
                    ELSE tercero_razonsocial END)
                AS tercero_nombre")
            );
            $query->where('tercero_activo', true);
            $query->where('tercero_tecnico', true);
            $query->orderby('tercero_nombre', 'asc');
            $collection = $query->lists('tercero_nombre', 'id');

            $collection->prepend('', '');
            return $collection;
        });
    }
    public static function getSellers(){
        if (Cache::has(self::$key_cache_sellers)) {
            return Cache::get(self::$key_cache_sellers);
        }

        return Cache::rememberForever(self::$key_cache_sellers, function() {
            $query = Tercero::query();
            $query->select('id',
                DB::raw("(CASE WHEN tercero_persona = 'N'
                    THEN CONCAT(tercero_nombre1,' ',tercero_nombre2,' ',tercero_apellido1,' ',tercero_apellido2,
                            (CASE WHEN (tercero_razonsocial IS NOT NULL AND tercero_razonsocial != '') THEN CONCAT(' - ', tercero_razonsocial) ELSE '' END)
                        )
                    ELSE tercero_razonsocial END)
                AS tercero_nombre")
            );
            $query->where('tercero_activo', true);
            $query->where('tercero_vendedor', true);
            $query->orderby('tercero_nombre', 'asc');
            $collection = $query->lists('tercero_nombre', 'id');

            $collection->prepend('', '');
            return $collection;
        });
    }
    public static function getBusinessAdvisors()
    {
        if (Cache::has(self::$key_cache_badvisors)) {
            return Cache::get(self::$key_cache_badvisors);
        }

        return Cache::rememberForever(self::$key_cache_badvisors, function() {
            $query = Tercero::query();
            $query->select('id',
                DB::raw("(CASE WHEN tercero_persona = 'N'
                    THEN CONCAT(tercero_nombre1,' ',tercero_nombre2,' ',tercero_apellido1,' ',tercero_apellido2,
                            (CASE WHEN (tercero_razonsocial IS NOT NULL AND tercero_razonsocial != '') THEN CONCAT(' - ', tercero_razonsocial) ELSE '' END)
                        )
                    ELSE tercero_razonsocial END)
                AS tercero_nombre")
            );
            $query->where('tercero_activo', true);
            $query->orderby('tercero_nombre', 'asc');
            $collection = $query->lists('tercero_nombre', 'id');

            $collection->prepend('', '');
            return $collection;
        });
    }

    public function setTerceroNombre1Attribute($name)
    {
        $this->attributes['tercero_nombre1'] = strtoupper($name);
    }

    public function setTerceroNombre2Attribute($name)
    {
        $this->attributes['tercero_nombre2'] = strtoupper($name);
    }

    public function setTerceroApellido1Attribute($lastname)
    {
        $this->attributes['tercero_apellido1'] = strtoupper($lastname);
    }

    public function setTerceroApellido2Attribute($lastname)
    {
        $this->attributes['tercero_apellido2'] = strtoupper($lastname);
    }

    public function setTerceroRazonsocialAttribute($name)
    {
        $this->attributes['tercero_razonsocial'] = strtoupper($name);
    }

    public function setTerceroDireccionAttribute($name)
    {
        $this->attributes['tercero_direccion'] = strtoupper($name);
    }

    /**
     * Checks role(s) and permission(s).
     *
     * @param string|array $roles       Array of roles or comma separated string
     * @param string|array $permissions Array of permissions or comma separated string.
     * @param array        $options     validate_all (true|false) or return_type (boolean|array|both)
     *
     * @throws \InvalidArgumentException
     *
     * @return array|bool
     */
    public function ability($roles, $permissions, $options = [])
    {
        // Convert string to array if that's what is passed in.
        if (!is_array($roles)) {
            $roles = explode(',', $roles);
        }
        if (!is_array($permissions)) {
            $permissions = explode(',', $permissions);
        }

        // Set up default values and validate options.
        if (!isset($options['validate_all'])) {
            $options['validate_all'] = false;
        } else {
            if ($options['validate_all'] !== true && $options['validate_all'] !== false) {
                throw new InvalidArgumentException();
            }
        }
        if (!isset($options['return_type'])) {
            $options['return_type'] = 'boolean';
        } else {
            if ($options['return_type'] != 'boolean' &&
                $options['return_type'] != 'array' &&
                $options['return_type'] != 'both') {
                throw new InvalidArgumentException();
            }
        }

        // Loop through roles and permissions and check each.
        $checkedRoles = [];
        $checkedPermissions = [];
        foreach ($roles as $role) {
            $checkedRoles[$role] = $this->hasRole($role);
        }
        foreach ($permissions as $permission) {
            $checkedPermissions[$permission] = $this->can($permission, isset($options['module']) ? $options['module'] : null);
        }

        // If validate all and there is a false in either
        // Check that if validate all, then there should not be any false.
        // Check that if not validate all, there must be at least one true.
        if(($options['validate_all'] && !(in_array(false,$checkedRoles) || in_array(false,$checkedPermissions))) ||
            (!$options['validate_all'] && (in_array(true,$checkedRoles) || in_array(true,$checkedPermissions)))) {
            $validateAll = true;
        } else {
            $validateAll = false;
        }

        // dd($this->can('crear', 'ordenes'));

        // Return based on option
        if ($options['return_type'] == 'boolean') {
            return $validateAll;
        } elseif ($options['return_type'] == 'array') {
            return ['roles' => $checkedRoles, 'permissions' => $checkedPermissions];
        } else {
            return [$validateAll, ['roles' => $checkedRoles, 'permissions' => $checkedPermissions]];
        }
    }

    /**
     * Check if user has a permission by its name.
     *
     * @param string|array $permission Permission string or array of permissions.
     * @param bool         $requireAll All permissions in the array are required.
     *
     * @return bool
     */
    public function can($permission, $module, $requireAll = false)
    {
        if (is_array($permission)) {
            foreach ($permission as $permName) {
                $hasPerm = $this->can($permName, $module);

                if ($hasPerm && !$requireAll) {
                    return true;
                } elseif (!$hasPerm && $requireAll) {
                    return false;
                }
            }

            // If we've made it this far and $requireAll is FALSE, then NONE of the perms were found
            // If we've made it this far and $requireAll is TRUE, then ALL of the perms were found.
            // Return the value of $requireAll;
            return $requireAll;
        } else {
            foreach ($this->cachedRoles() as $role) {
                // Validate against the Permission table
                foreach ($role->cachedPermissions($module) as $perm) {
                    if (str_is( $permission, $perm->name) ) {
                        return true;
                    }
                }
            }
        }

        return false;
    }

    public static function getTechnical( $id )
    {
        $query = Tercero::query();
        $query->select('id',
            DB::raw("(CASE WHEN tercero_persona = 'N'
                THEN CONCAT(tercero_nombre1,' ',tercero_nombre2,' ',tercero_apellido1,' ',tercero_apellido2,
                        (CASE WHEN (tercero_razonsocial IS NOT NULL AND tercero_razonsocial != '') THEN CONCAT(' - ', tercero_razonsocial) ELSE '' END)
                    )
                ELSE tercero_razonsocial END)
            AS tercero_nombre")
        );
        $query->where('tercero_activo', true);
        $query->where('tercero_tecnico', true);
        $query->where('tercero.id', $id);
        return $query->first();
    }
}
