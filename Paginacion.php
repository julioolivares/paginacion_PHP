<?php
Class Paginacion
	{
		private $url_paginada;
		private $total_registros;
		private $registros_x_pagina;
		private $enlaces_x_pagina;
		private $numero_paginas;
		private $enlace_grupo;
		private $ultimo_grupo;
		private $grupo_anterior;
		private $grupo_siguiente;
		private $cierre_contenedor_paginacion	= '';
		public  $contenedor_padre_paginacion	= 'ul';
		public  $contenedor_hijo_paginacion		= 'li';
		public  $class_enlace_activo 				  = 'active';
		public  $class_contenedor_paginacion  = 'pagination pagination-lg';
		public  $text_grupo_anterior       		= '<<' ;
		public  $text_grupo_siguiente      		= '>>' ;
		public  $enlaces_paginados 				 		= '';
		public  $text_primera_pagina       		= 'Primera Página';
		public  $text_ultima_pagina        		= 'Última Página'; 
		public 	$limite_inicial_consulta;
		public  $limite_final_consulta;


		public function __construct($config = Array())
			{
				if(count($config) > 0): //inicializar los parameros. 
					$this->url_paginada 								= $config['url_paginada'];
					$total_registros         						= $config['total_registros']; settype($total_registros, 'integer');
					$this->total_registros   					  = $total_registros;
					$enlaces_x_pagina 		  						= $config['enlaces_x_pagina']; settype($enlaces_x_pagina, 'integer');
					$this->enlaces_x_pagina   					= $enlaces_x_pagina;
					$registros_x_pagina 								= $config['registros_x_pagina']; settype($registros_x_pagina, 'integer'); 
					$this->registros_x_pagina 					= $registros_x_pagina;
					$this->enlaces_paginados						= "<".$this->contenedor_padre_paginacion." class='$this->class_contenedor_paginacion'>";
					$this->cierre_contenedor_paginacion = '</'.$this->contenedor_padre_paginacion.'>';
				else://no hacer nada
					exit('No se recibio la configuracion necesaria para crear la paginacion $config[url_paginada], $config[total_registros], $config[registros_x_pagina], $config[enlaces_x_pagina]');
				endif;
 			} //FINAL FUNCION __construct($config = Array())

 		public function CrearPaginacion($pagina)
 			{
 				$this->numero_paginas = ceil($this->total_registros / $this->registros_x_pagina);
 				if(!$this->numero_paginas > 1): //NO CREAR PAGINACION SI NO ES MAYOR DE UNO LA PAGINA
 					return $this->enlaces_paginados;

 				elseif($pagina > $this->numero_paginas): //mostrar error 404
 						show_404();
 				else:	

 					$pagina               				 = ($pagina != NULL) ? $pagina : 1;
 					$this->enlace_grupo    				 = ceil($pagina / $this->enlaces_x_pagina);
 					$this->ultimo_grupo						 = ceil($this->numero_paginas / $this->enlaces_x_pagina);
 					$inicio_grupo  			   			   = (($this->enlace_grupo * $this->enlaces_x_pagina) - ($this->enlaces_x_pagina - 1));
 					$final_grupo				   				 = ($this->enlace_grupo * $this->enlaces_x_pagina);
 					$this->limite_inicial_consulta = $this->registros_x_pagina;
 					$limite_final_consulta				 = floor($pagina * $this->registros_x_pagina) - ($this->registros_x_pagina);
 					settype($limite_final_consulta, 'integer');
 					$this->limite_final_consulta   = $limite_final_consulta;

 					for($inicio_grupo; $inicio_grupo <= $final_grupo; $inicio_grupo++):
 						if($inicio_grupo > $this->numero_paginas): //SI EL LINK A IMPRIMIR ES > QUE EL TOTAL DE PAGINAS DETENER LA PAGINACION 
 							$this->enlaces_paginados .= $this->cierre_contenedor_paginacion;
 							break;
 						else:
 							$class_enlace_activo = ($inicio_grupo == $pagina) ? $this->class_enlace_activo : '';

		 					if(!isset($this->grupo_anterior) && $this->enlace_grupo > 1):
		 						$this->grupo_anterior     = ($inicio_grupo - $this->enlaces_x_pagina);
		 						$this->enlaces_paginados .= "<$this->contenedor_hijo_paginacion><a href='$this->url_paginada/1/".rand(0,9999)."' 
		 																				title='Ir al Principio'>
		 																				$this->text_primera_pagina</a></$this->contenedor_hijo_paginacion>".
		 																				"<$this->contenedor_hijo_paginacion><a href='$this->url_paginada/$this->grupo_anterior/".
		 																				rand(0,9999)."'title='Ver Páginas Anteriores'>
		 																				$this->text_grupo_anterior </a></$this->contenedor_hijo_paginacion>".
		 																				"<$this->contenedor_hijo_paginacion class='$class_enlace_activo'><a href='$this->url_paginada/$inicio_grupo/".rand(0,9999).
		 																				"' title='Ver pagina $inicio_grupo'>$inicio_grupo </a></$this->contenedor_hijo_paginacion>";	

		 					else:
 								$this->enlaces_paginados .= "<$this->contenedor_hijo_paginacion class='$class_enlace_activo'> 
 																						<a href='$this->url_paginada/$inicio_grupo/".rand(0,9999).
 																						"' title='Ver pagina $inicio_grupo'>$inicio_grupo </a></$this->contenedor_hijo_paginacion>";	
		 					endif; //FINAL IF if(!isset($this->grupo_anterior) && $this->enlace_grupo > 1): CREAR ENLACE ANTERIOR Y PRIMERA PAGINA
		 					
		 					if(!isset($this->grupo_siguiente) && $this->enlace_grupo < $this->ultimo_grupo && $inicio_grupo == $final_grupo):
		 						$this->grupo_siguiente    = ($final_grupo + 1);
		 						$this->enlaces_paginados .= "<$this->contenedor_hijo_paginacion><a href='$this->url_paginada/$this->grupo_siguiente/".rand(0,9999)."' 
		 																				title='Ver Páginas Siguientes'>$this->text_grupo_siguiente</a></$this->contenedor_hijo_paginacion>
		 																				<$this->contenedor_hijo_paginacion><a href='$this->url_paginada/$this->numero_paginas/".rand(0,9999)."' 
		 																				title='Ir al Final'>$this->text_ultima_pagina</a></$this->contenedor_hijo_paginacion>
		 																				";	

		 					else:
 						
		 					endif; //FINAL IF if(!isset($this->grupo_siguiente) && ($this->enlace_grupo < $this->ultimo_grupo)):  //CREAR LINK SIGUIENTE GRUPO >>
		 					$this->enlaces_paginados .= ($inicio_grupo == $final_grupo)? $this->cierre_contenedor_paginacion : '';//AGREGAR ETIQUETA DE CIERRE A LA PAGINACION
 						endif;
 					endfor;

 					return $this->enlaces_paginados;

 				endif; //FINAL IF if(!$A->numero_paginas > 1): //NO CREAR PAGINACION SI NO ES MAYOR DE UNO LA PAGINA
 			}	

	}