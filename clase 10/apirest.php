<?php
require_once "vendor/autoload.php";
require_once "entidades/algo.php";
require_once "entidades/AccesoDatos.php";




$app = new \Slim\Slim();

$app->get('/saludar', function() {

    echo "Hola mundo";
});

$app->get('/saludar/:nombre', function($nombre) {

    echo "Hola {$nombre}";
});

$app->get('/saludar/:nombre/:apellido', function($nombre, $apellido) {

    echo "Hola {$nombre}, {$apellido}";

});

$app->get('/opcional/:nombre(/:apellido)', function($nombre, $apellido=NULL) {

	if($apellido != null)
    	echo "Hola {$nombre}, {$apellido}";
	else
		echo "Hola {$nombre}";
});

$app->get('/funciones', 'saludar', function() {

    echo "Hola desde el cuerpo...";
});

function saludar(){

	echo "Hola desde la funcion...";
}

// Si necesitamos acceder a alguna variable global en el framework
// Tenemos que pasarla con use() en la cabecera de la función. Ejemplo: use($app)
$app->get('/cd', function() use($app) {

    $resultados["Mensaje"] = "GET";
// Indicamos el tipo de contenido y condificación que devolvemos desde el framework Slim.
	$app->response->headers->set("Content-type", "application/json");
	$app->response->status(200);
	$app->response->body(json_encode($resultados));
});

// POST: Para crear recursos
$app->post("/cd", function() use($app)
{
	
	// acá tengo que dar de alta un objeto x

	// guardarlo en la base de datos

	// metodo de la lógica

	// luego la clase

	// luego la Base de Datos
	
	// Recuperamos los valores con $app->request->'metodo'("key")
	// 'metodo' -> post, put o delete
	$valor_char = $app->request->post("valorChar");
	$valor_date = $app->request->post("valorDate");
	$valor_int = $app->request->post("valorInt");

	$res = array("Mensaje" => "POST", "v1" => $valor_char, "v2" => $valor_date, "v3" => $valor_int);	
	
// Indicamos el tipo de contenido y condificación que devolvemos desde el framework Slim.
	$app->response->headers->set("Content-type", "application/json");
	$app->response->status(200);
	$app->response->body(json_encode($res));

	// mi resultado

	$alumno = new Algo($valor_char,$valor_date,$valor_int);

	Algo::Guardar($alumno);

});

// PUT: Para editar recursos
$app->put("/cd", function() use($app)
{
	// Recuperamos los valores con $app->request->'metodo'("key")
	// 'metodo' -> post, put o delete
	$valor_char = $app->request->put("valorChar");
	$valor_date = $app->request->put("valorDate");
	$valor_int = $app->request->put("valorInt");
	$id = $app->request->put("id");

	$res = array("Mensaje" => "PUT", "v1" => $valor_char, "v2" => $valor_date, "v3" => $valor_int, "v4" => $id);	
		
// Indicamos el tipo de contenido y condificación que devolvemos desde el framework Slim.
	$app->response->headers->set("Content-type", "application/json");
	$app->response->status(200);
	$app->response->body(json_encode($res));
});

// DELETE: Para eliminar recursos
$app->delete("/cd", function() use($app)
{
	// Recuperamos los valores con $app->request->'metodo'("key")
	// 'metodo' -> post, put o delete
	$id = $app->request->delete("id");

	$res = array("Mensaje" => "DELETE", "v1" => $id);
// Indicamos el tipo de contenido y condificación que devolvemos desde el framework Slim.
	$app->response->headers->set("Content-type", "application/json");
	$app->response->status(200);
	$app->response->body(json_encode($res));
});

// Accedemos por get a /cd/ pasando un id 
// Ruta /cd/id
// Los parámetros en la url se definen con :parametro
// El valor del parámetro :id se pasará a la función de callback como argumento
$app->get('/cd/:id', function($id) use($app) {

	$res = array("Mensaje" => "GET_UNO", "v1" => $id);

// Indicamos el tipo de contenido y condificación que devolvemos desde el framework Slim.
	$app->response->headers->set("Content-type", "application/json");
	$app->response->status(200);
	$app->response->body(json_encode($res));
});

$app->run();