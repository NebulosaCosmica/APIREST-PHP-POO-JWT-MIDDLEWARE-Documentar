<?php


// me falta la clase y el objeto Acceso a Datos




class Algo{

    private $nombre;
    private $fechaNac;
    private $edad;
    

    public function __construct($unnombre,$unafechaNac,$unaedad){

        $this->nombre = $unnombre;
        $this->fechaNac = $unafechaNac;
        $this->edad = $unaedad;       

    }

    public function getnombre(){
        return $this->nombre;
    }

    public function setnombre($elnombre){
        $this->nombre = $elnombre;
    }

    public function getfechaNac(){
        return $this->fechaNac;
    }

    public function setemail($lafechaNac){
        $this->fechaNac = $lafechaNac;
    }
    public function getedad(){
        return $this->edad;
    }

    public function setedad($laedad){
        $this->edad = $laedad;
    }    
    
    // trim, que los uso para guardar en archivos de textos
    // me parece que no mejora, el "culpable" es el \r\n del guardar

    public function Mostrar(){
      /*  $salida = trim($this->getnombre()) . "-" . trim($this->getapellido())."-". trim($this->getemail())."-".trim($this->getfoto());
        return $salida;*/
    }   

    public static function Guardar($obj)
	{

        $acceso = AccesoDatos::dameunObjetoAcceso();

        
		$acceso = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$acceso->RetornarConsulta("INSERT into tabla (valorChar,valorDate,valorInt)values(".$obj->getnombre().",".$obj->getfechaNac().",".$obj->getedad().")");
		$consulta->execute();
		return $acceso->RetornarUltimoIdInsertado();

        /* if(!file_exists("archivos")){
            mkdir("archivos");
        }

    $ar = fopen("archivos/alumnos.txt", "a");
		
		
		//ESCRIBO EN EL ARCHIVO
		fwrite($ar, $obj->Mostrar()."\r\n");		
	
		//CIERRO EL ARCHIVO
        fclose($ar);		
        
        echo "Alumno dado de alta";*/
		
    }

    public static function TraerTodosLosAlumnos()
	{
            
		$ListaDeAlumnosLeidos = array();

        //leo todos los alumnos del archivo
        
		$archivo=fopen("archivos/alumnos.txt","r");
		
		while(!feof($archivo))
		{
			$archAux = fgets($archivo);
			$alumnos = explode("-",$archAux);
		                   
          $nombre ="";// alumnos[0]
          $apellido = "";// alumnos [1]
          $email ="";// alumnos[2]
          $foto = "";// alumnos [3]
                   
          
          // hace que el último objeto vacío no entre en la lista

          if($alumnos[0]!= ""){

            $nombre = $alumnos[0];
            $apellido = $alumnos[1];
            $email = $alumnos[2];
            $foto = $alumnos[3];
                       
            $elalumno = new Alumno($nombre,$apellido,$email,$foto);

            $ListaDeAlumnosLeidos[] = $elalumno;
            }
			
		}
		fclose($archivo);
     
		return $ListaDeAlumnosLeidos;
		
    }// traer todos

    public function depurarimagen($lafototmp){


        if(!file_exists("archivos")){
            mkdir("archivos");
        } 

        if(!file_exists("archivos/ImagenesDeAlumnos")){
            mkdir("archivos/ImagenesDeAlumnos");
        }         

        if( !(gettype($lafototmp)=== "string")){
            

            $archivoTmp = $this->getemail() . ".". pathinfo(trim($lafototmp["name"]),PATHINFO_EXTENSION);
    
            $destino = "archivos/ImagenesDeAlumnos/" . $archivoTmp;
        
            //$esImagen = getimagesize($image["tmp_name"]);           
         
            // trim trim trim
            if (!move_uploaded_file(trim($lafototmp["tmp_name"]), $destino)) {
                echo "subida mala, el alumno se queda sin foto de perfil.";
                return false;
            }else{

                return $archivoTmp;

            }

        }else{

            return $lafototmp;

        }

    }


}


?>