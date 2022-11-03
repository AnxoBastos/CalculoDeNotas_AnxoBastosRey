<?php
declare(strict_types=1);

if(isset($_POST['enviar'])){
    $data['errores'] = checkForm($_POST);
    $data['input'] = filter_var_array($_POST);
    if(empty($data['errores'])){
        $jsonArray = json_decode($_POST['json_notas'], true);
        $resultado = gestionarAsignaturas($jsonArray);
        $data['resultado'] = $resultado;
    }
}

function gestionarAsignaturas(array $asignaturas) : array{
    $resultado['listaSuspensos'] = array();
    foreach ($asignaturas as $modulo => $alumnos){
        $resultado[$modulo]['media'] = 0;
        $resultado[$modulo]['aprobados'] = 0;
        $resultado[$modulo]['suspensos'] = 0;
        $resultado[$modulo]['max'] = array('nombre' => '', 'nota' => 0);
        $resultado[$modulo]['min'] = array('nombre' => '', 'nota' => 10);
        foreach ($alumnos as $nombre => $notas){
            $media = 0;
            foreach($notas as $nota){
                $media += $nota;
            }
            $media = $media/count($notas);
            if (!isset($resultado['listaSuspensos'][$nombre])) {
                    $resultado['listaSuspensos'][$nombre] = 0;
            }
            if ($media >= 5) {
                $resultado[$modulo]['aprobados']++;
            }
            else{
                $resultado[$modulo]['suspensos']++;
                $resultado['listaSuspensos'][$nombre]++;
            }
            if ($media > $resultado[$modulo]['max']['nota']) {
               $resultado[$modulo]['max']['nombre'] = $nombre;
               $resultado[$modulo]['max']['nota'] = $media; 
            }
            if ($media < $resultado[$modulo]['min']['nota']) {
                $resultado[$modulo]['min']['nombre'] = $nombre;
                $resultado[$modulo]['min']['nota'] = $media; 
            }
            $resultado[$modulo]['media'] += $media;
        }
        $resultado[$modulo]['media'] = $resultado[$modulo]['media']/count($alumnos);
    }
    return $resultado;
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