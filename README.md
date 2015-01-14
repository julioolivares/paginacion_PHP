# paginacion_PHP
Clase para crear paginaciones de registros personalizadas con un mínimo de código:

Es una completa clase que permite crear patinadores de resultados a consultas de base de datos, e interactuar con los mismos mediante una paremetrizacion inicial simple que solo requiere iniciar mínimo cuatro parámetros $config['url_paginada'], $config['total_registros'], $config['enlaces_x_pagina'], $config['registros_x_pagina'] para crear los enlaces.

*$config['url_paginada']; *(Tipo Cadena)

La url donde se usara la paginación, la misma tiene el siguiente prototipo http://localhost/ver_pagina/1

Donde Ver_pagina es la funcion del controlador que se muestra la vista y recibe como parámetro el número de página que retorna la paginación con la función CrearPaginacion($pagina).

$config['total_registros']; (Tipo Entero ) Correspondiente al total de registros que retorna la consulta a la base de datos.( Num_rows()).

$config['enlaces_x_pagina']; (Tipo Entero ) Corresponde al número de enlaces paginadores a mostrar por pagina

$config['registros_x_pagina']; (Tipo Entero ) Corresponde al número de registros a mostrar por página

Para crear la paginación previamente se debe consultar el total de registros que se mostraran por ejemplo seria realizar un count(*) a la tabla bajo los criterios particulares según el caso, luego tomar ese resultado para pasarlo como parámetro al objeto Paginación: 

$result = Count(‘id’) as cantidad from tabla where cliente = 1 and estado = 1;  
$total_registros = $result->cantidad //es solo un ejemplo que variara según el entorno de BD. 

/*
//Un ejemplo real usando Codeigniter y Msqly: 
$resultado = $this->db->select(“Count(id) as cantidad”)->from(“table”)->where(“cliente = 1 and estado = 1”);  
$fila = $resultado->row();
$total_registros = $row->cantidad; 
*/

$config['url_paginada']   	  =’ http://localhost/sitio/funcion_mostrar_registros’;
$config['total_registros'] 	  = $total_registros;
$config['registros_x_pagina'] = 5;
$config['enlaces_x_pagina']   = 10;

$Paginacion = new Paginacion($config);

$link_paginacion = $paginacion->CrearPaginacion($pagina);




Donde $pagina debe ser el parámetro que recibe la función que retorna los datos por ejemplo: 

Public function ver_pagina($pagina = NULL)
   {
      $resultado = $this->db->select(“Count(id) as cantidad”)->from(“table”)->where(“cliente = 1  and estado = 1”);  
      $fila = $resultado->row();
      $total_registros = $row->cantidad; 
     
      $config['url_paginada']   	  =’ http://localhost/sitio/funcion_mostrar_registros’;
      $config['total_registros'] 	  = $total_registros;
      $config['registros_x_pagina'] = 5;
      $config['enlaces_x_pagina']   = 10;
    
      $Paginacion      = new Paginacion($config);
      $link_paginacion = $paginacion->CrearPaginacion($pagina); //el HTML ya formateado y configurado

//Luego sería ya imprimir el resultado y $link_paginacion
		
   }
