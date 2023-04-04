<?php

$sigma = array('IDs'=>array('[a-z0-9]'),
                'Cons'=>array('[0-9]'),
                'WHILE'=>array('while'),
                'FOR'=>array('for'),
                'IF'=>array('if')
);

function getResultadoFinal($estado, $finais) {
    if (in_array($estado, $finais)) {
        switch ($estado) {
            case 'q1':
                return "Cadeia: IDs";
            case 'q3':
                return "Cadeia: If";
            case 'q4':
                return "Cadeia: Constante";
            case 'q7':
                return "Cadeia: For";
            case 'q12':
                return "Cadeia: While";
        }
    }
    return "Cadeia incorreta";
}

function iniciar($entrada){
    $delta = array(
        'q0' => array('i'=>'q2','[0-9]'=>'q4','w'=>'q8','[a-eghj-vx-z]'=>'q1','[f]'=>'q5'),
        'q1' => array('[a-z0-9]'=>'q1'),
        'q2' => array('[^f]'=>'q1','f'=>'q3'),
        'q3' => array('[a-z0-9]'=>'q1'),
        'q4' => array('[0-9]'=>'q4'),
        'q5' => array('[^o]'=>'q1','o'=>'q6'),
        'q6' => array('[^r]'=>'q1','r'=>'q7'),
        'q7' => array('[a-z0-9]'=>'q1'),
        'q8' => array('[^h]'=>'q1','h'=>'q9'),
        'q9' => array('[^i]'=>'q1','i'=>'q10'),
        'q10' => array('[^l]'=>'q1','l'=>'q11'),
        'q11' => array('[^e]'=>'q1','e'=>'q12'),
        'q12' => array('[a-z0-9]'=>'q1')
    );

    $Q = array('q0','q1','q2','q3','q4','q5','q6','q7','q8','q9','q10','q11','q12');
    $finais = array('q1','q3','q4','q7','q12');
    $estado = 'q0';
    $estadoAtual = '';

    for ($i = 0; $i < strlen($entrada); $i++){

        $entry = $entrada[$i];
        echo $estado;
        
        foreach ($delta[$estado] as $regex => $prox){
            if (preg_match('/^'. $regex . '$/', $entry)){
                $estado = $prox;
                $estadoAtual = $estadoAtual . $entry;
                break;
            }
        }

    }

    echo getResultadoFinal($estado,$finais);
}

$entrada = 'for';

iniciar($entrada);

?>
