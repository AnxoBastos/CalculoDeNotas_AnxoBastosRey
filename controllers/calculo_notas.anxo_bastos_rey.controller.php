<?php
declare(strict_types=1);

if(isset($_POST['enviar'])){
    $data['errores'] = checkForm($_POST);
    $data['input'] = filter_var_array($_POST);
    if(empty(['errores'])){
        $jsonArray = json_decode($_POST['json_notas'], true);
        /**
        $resultado = datosAsignaturas($jsonArray);
        $data['resultado'] = $resultado;
         * 
         */
    }
}

function checkForm(array $post) : array{
    $errores = [];
    if(empty($post['json_notas'])){
        $errores['json_notas'] = 'Este campo es obligatorio';
    }
    else{
        $asignaturas = json_decode($post['json_notas'], true);
        if(json_last_error() !== JSON_ERROR_NONE){
            $errores['json_notas'] = 'El formato no es correcto';
        }
        else{
            $erroresJson = "";
            foreach($asignaturas as $modulo => $alumnos){
                if(empty($modulo)){
                    $erroresJson .= "El nombre del módulo no puede estar vacío<br>";
                }
                if(!is_array($alumnos)){
                    $erroresJson .= "El módulo '".htmlentities($modulo)."' no contiene un array de alumnos<br>";
                }
                else{
                    foreach($alumnos as $nombre => $notas){
                        if(empty($nombre)){
                            $erroresJson .= "El módulo '".htmlentities($modulo)."' tiene un alumno sin nombre<br>";;
                        }
                        foreach($notas as $nota){
                            if(!is_numeric($nota)){
                                $erroresJson .= "El alumno '".htmlentities($nombre)."', en el modulo '".htmlentities($modulo)."', tiene una nota '".htmlentities($nota)."' que no se corresponde a un numero<br>";
                            }
                            else{
                                if($nota < 0 || $nota > 10){
                                    $erroresJson .= "El alumno '".htmlentities($nombre)."', en el modulo '".htmlentities($modulo)."' tiene una nota '".$nota."', que es inferior a 0 o superior a 10<br>";
                                }
                            }
                        }
                    }
                }
            }
            if(!empty($erroresJson)){
                $errores['json_notas'] = $erroresJson;
            }
        }
    }
    return $errores;
}

include 'views/templates/header.php';
include 'views/calculo_notas.anxo_bastos_rey.view.php';
include 'views/templates/footer.php';