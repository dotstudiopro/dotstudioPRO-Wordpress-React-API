<?php
/**
 * Swagger base class.
 */
class WP_REST_Swagger_Controller extends WP_REST_Controller {


	/**
	 * Construct the API handler object.
	 */
	public function __construct() {
		$this->namespace = 'apigenerate';
	}

	/**
	 * Register the meta-related routes.
	 */
	public function register_routes() {
		register_rest_route( $this->namespace, '/swagger', array(
			array(
				'methods'             => WP_REST_Server::READABLE,
				'callback'            => array( $this, 'get_swagger' ),
				'permission_callback' => array( $this, 'get_swagger_permissions_check' ),
				'args'                => $this->get_swagger_params(),
			),


			'schema' => array( $this, 'get_swagger_schema' ),
		) );
	}

	public function get_swagger_params() {
		$new_params = array();
		return $new_params;
	}

	public function get_swagger_permissions_check( $request ) {
		return true;
	}

	function getSiteRoot($path=''){
		global $wp_rewrite;
		$rootURL = site_url();

		if ( $wp_rewrite->using_index_permalinks() ) $rootURL.='/'.$wp_rewrite->index;

		$rootURL.='/'.$path;

		return $rootURL;
	}

	/**
	 * Retrieve custom swagger object.
	 *
	 * @param WP_REST_Request $request
	 * @return WP_REST_Request|WP_Error Meta object data on success, WP_Error otherwise
	 */
	public function get_swagger( $request ) {



		global $wp_rewrite;
//
//		if($wp_rewrite->root!='/'){
//			$basePath = '/'.$wp_rewrite->root;//'/'.$matches[1].'/';
//		}

		$title=wp_title('',0);
		$host=preg_replace('/(^https?:\/\/|\/$)/','',site_url('/'));
		if(empty($title)){
			$title=$host;
		}

		$apiPath =  get_rest_url();

		$basePath = preg_replace('#https?://#', '', $apiPath);
		$basePath = str_replace($host, '', $basePath);
		$basePath = preg_replace('#/$#', '', $basePath);

		$swagger = array(
				'swagger'=>'2.0'
				,'info'=>array(
					'version'=>'1.0'
					,'title'=>$title
				)
				,'host'=>$host
				,'basePath'=>$basePath
				,'schemes'=>array((is_ssl() | force_ssl_admin()) ? 'https' : 'http')
				,'consumes'=>array('multipart/form-data')
				,'produces'=>array('application/json')
				,'paths'=>array()
				,'definitions'=>array(
					'error'=>array(
						'properties'=>array(
							'code'=>array(
								'type'=>'string'
							)
							,'message'=>array(
								'type'=>'string'
							)
							,'data'=>array(
								'type'=>'object'
								,'properties'=>array(
									'status'=>array(
										'type'=>'integer'
									)
								)
							)
						)
					)
				)
				,'securityDefinitions'=>array(
					"cookieAuth"=>array(
						"type"=> "apiKey",
						"name"=> "X-WP-Nonce",
						"in"=> "header",
						"description"=>"Please see http://v2.wp-api.org/guide/authentication/"
					)

				)
			);

		$security = array(
			array('cookieAuth'=>array())
		);


		if(function_exists('rest_oauth1_init')){
			$swagger['securityDefinitions']['oauth']=array(
				'type'=>'oauth2'
				,'x-oauth1'=> true
				,'flow'=> 'accessCode'
				,'authorizationUrl'=> $this->getSiteRoot('oauth1/authorize')
				,'tokenUrl'=>  $this->getSiteRoot('oauth1/request')
				,'x-accessUrl'=>  $this->getSiteRoot('oauth1/access')
				,'scopes'=>array(
				  'basic'=> 'OAuth authentication uses the OAuth 1.0a specification (published as RFC5849)'
					)
			);
			$security[] = 	array('oauth'=>array('basic'));
		}


		if(class_exists('WO_Server')){
			$rootURL = site_url();

			if ( $wp_rewrite->using_index_permalinks() ) $rootURL.='/'.$wp_rewrite->index;

			$swagger['securityDefinitions']['oauth']=array(
				'type'=>'oauth2'
				,'flow'=> 'accessCode'
				,'authorizationUrl'=> $rootURL.'/oauth/authorize'
				,'tokenUrl'=> $rootURL.'/oauth/token'
				,'scopes'=>array(
				  'openid'=> 'openid'
					)
			);
			$security[] = 	array('oauth'=>array('openid'));
		}

		if(class_exists('Application_Passwords') || function_exists('json_basic_auth_handler')){
			$swagger['securityDefinitions']['basicAuth']=array(
				'type'=>'basic'
			);
			$security[] = 	array('basicAuth'=>array(''));
		}


		$restServer = rest_get_server();

		foreach($restServer->get_routes() as $endpointName => $endpoint){

			// don't include self - that's a bit meta
			if($endpointName=='/'.$this->namespace.'/swagger') { continue; }

			$routeopt = $restServer->get_route_options( $endpointName );
			if(!empty($routeopt['schema'][1])){
				$schema = call_user_func(array(
					$routeopt['schema'][0]
					,$routeopt['schema'][1])
				);
				$swagger['definitions'][$schema['title']]=$this->schemaIntoDefinition($schema);
				$outputSchema = array('$ref'=>'#/definitions/'.$schema['title']);
			}else{
				//if there is no schema then it's a safe bet that this API call
				//will not work - move to the next one.
				continue;
			}



			$defaultidParams = array();
			//Replace endpoints var and add to the parameters required
			$endpointName = preg_replace_callback(
				'#\(\?P<(\w+?)>.*?\)#',
				function ($matches) use (&$defaultidParams){
					$defaultidParams[]=array(
							'name'=>$matches[1]
							,'type'=>'string'
							,'in'=>'path'
							,'required'=>true
						);
					return '{'.$matches[1].'}';
				},
				$endpointName
			);
			$endpointName = str_replace(site_url(), '',rest_url($endpointName));
			$endpointName = str_replace($basePath, '',$endpointName);

			if(empty($swagger['paths'][$endpointName])){
				$swagger['paths'][$endpointName] = array();
			}


			foreach($endpoint as $endpointPart){

				foreach($endpointPart['methods'] as $methodName=>$method){
					if(in_array($methodName,array('PUT','PATCH')))continue; //duplicated by post

					$parameters = $defaultidParams;

					//Clean up parameters
					foreach ($endpointPart['args'] as $pname=>$pdetails){

						// Assume that the param doesn't exist
						$exists = false;

						// Go through the default params (path params?) and if we already have one with that name, we merge the description and type, and continue
						for($a=0;$a<count($parameters);$a++){
							if( $parameters[$a]['name'] == $pname ){
								if(!empty($pdetails['description']))$parameters[$a]['description']=$pdetails['description'];
								if(!empty($pdetails['type'])){
									if($pdetails['type']=='array'){
										$parameters[$a]['type']=$pdetails['type'];
										$parameters[$a]['items']=array('type'=>'string');
									}elseif($pdetails['type']=='object'){
										$parameters[$a]['type']='string';

									}elseif($pdetails['type']=='date-time'){
										$parameters[$a]['type']='string';
										$parameters[$a]['format']='date-time';
									}else{
										$parameters[$a]['type']=$pdetails['type'];
									}
								}
								$exists = true;
							}
						}

						// If the param exists, we don't need it again
						if($exists) continue;

						$parameter=array(
							'name'=>$pname
							,'type'=>'string'
							,'in'=>$methodName=='POST'?'formData':'query'
						);
						if(!empty($pdetails['description']))$parameter['description']=$pdetails['description'];
						if(!empty($pdetails['format']))$parameter['format']=$pdetails['format'];
						if(!empty($pdetails['default']))$parameter['default']=$pdetails['default'];
						if(!empty($pdetails['enum']))$parameter['enum']=$pdetails['enum'];
						if(!empty($pdetails['required']))$parameter['required']=$pdetails['required'];
						if(!empty($pdetails['minimum'])){
							$parameter['minimum']=$pdetails['minimum'];
							$parameter['format']='number';
						}
						if(!empty($pdetails['maximum'])){
							$parameter['maximum']=$pdetails['maximum'];
							$parameter['format']='number';
						}
						if(!empty($pdetails['type'])){
							if($pdetails['type']=='array'){
								$parameter['type']=$pdetails['type'];
								$parameter['items']=array('type'=>'string');
							}elseif($pdetails['type']=='object'){
								$parameter['type']='string';

							}elseif($pdetails['type']=='date-time'){
								$parameter['type']='string';
								$parameter['format']='date-time';
							}else{
								$parameter['type']=$pdetails['type'];
							}
						}

						$parameters[]=$parameter;
					}

					//If the endpoint is not grabbing a specific object then
					//assume it's returning a list
					$outputSchemaForMethod = $outputSchema;
					if($methodName=='GET' && !preg_match('/}$/',$endpointName)){
						$outputSchemaForMethod = array(
							'type'=>'array'
							,'items'=>$outputSchemaForMethod
						);
					}

					$responses = array(
						200=>array(
							'description'=> "successful operation"
							,'schema'=>$outputSchemaForMethod
						)
						,'default'=>array(
							'description'=> "error"
							,'schema'=>array('$ref'=>'#/definitions/error')
						)
					);

					if(in_array($methodName,array('POST','PATCH','PUT')) && !preg_match('/}$/',$endpointName)){
						//This are actually 201's in the default API - but joy of joys this is unreliable
						$responses[201] = array(
							'description'=> "successful operation"
							,'schema'=>$outputSchemaForMethod
						);
					}


					$swagger['paths'][$endpointName][strtolower($methodName)] = array(
						'parameters'=>$parameters
						,'security'=>$security
						,'responses'=>$responses

					);

				}
			}
		}

		$response = rest_ensure_response( $swagger );

		return apply_filters( 'rest_prepare_meta_value', $response, $request );
	}

	/**
	 * Turns the schema set up by the endpoint into a swagger definition.
	 *
	 * @param array $schema
	 * @return array Definition
	 */
	private function schemaIntoDefinition($schema){
		if(!empty($schema['$schema']))unset($schema['$schema']);
		if(!empty($schema['title']))unset($schema['title']);
		foreach($schema['properties'] as $name=>&$prop){

			if(!empty($prop['properties'])){
				$prop = $this->schemaIntoDefinition($prop);
			}

			//-- Changes by Richi
			if(!empty($prop['enum'])){
				if($prop['enum'][0] == ""){
					if(count($prop['enum']) > 1){
						array_shift($prop['enum']);
					}else{
						$prop['enum'][0] = "NONE";
					}
				};
			}

			if(!empty($prop['default']) && $prop['default'] == null){
				unset($prop['default']);
			}
//--


			if($prop['type']=='array'){
				$prop['items']=array('type'=>'string');
			}else
			if($prop['type']=='date-time'){
				$prop['type']='string';
				$prop['format']='date-time';
			}
//			else if(!empty($prop['context']) && $prop['format']!='date-time'){
//				//$prop['enum']=$prop['context'];
//
//			}
			if(isset($prop['required']))unset($prop['required']);
			if(isset($prop['readonly']))unset($prop['readonly']);
			if(isset($prop['context']))unset($prop['context']);


		}

		return $schema;
	}

	/**
	 * Get the meta schema, conforming to JSON Schema
	 *
	 * @return array
	 */
	public function get_swagger_schema() {
		$schema = json_decode(file_get_contents(dirname(__FILE__).'/schema.json'),1);
		return $schema;
	}

}
