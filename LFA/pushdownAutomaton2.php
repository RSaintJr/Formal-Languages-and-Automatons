<?php
function delta($state, $input, $stackTop) {
    $transitions = [
        "q0" => [
            "programa" => ["state" => "q1", "pop" => false, "push" => "X"],
        ],
        "q1" => [
            "id" => ["state" => "q1", "pop" => false, "push" => "X"],
            "(" => ["state" => "q1", "pop" => false, "push" => "X"],
            ":" => ["state" => "q1", "pop" => "X", "push" => null],
            "int" => ["state" => "q1", "pop" => "X", "push" => null],
            ")" => ["state" => "q1", "pop" => "X", "push" => null],
            "tipo" => ["state" => "q1", "pop" => "X", "push" => null],
            ";" => ["state" => "q1", "pop" => "X", "push" => null],
            "if" => ["state" => "q1", "pop" => "X", "push" => null],
            ">" => ["state" => "q1", "pop" => false, "push" => "X"],
            "0" => ["state" => "q1", "pop" => false, "push" => "X"],
            "2" => ["state" => "q1", "pop" => false, "push" => "X"],
            "{" => ["state" => "q1", "pop" => false, "push" => "X"],
            "=" => ["state" => "q1", "pop" => "X", "push" => null],
            "/" => ["state" => "q1", "pop" => "X", "push" => null],
            "}" => ["state" => "q1", "pop" => "X", "push" => null],
            "return" => ["state" => "qf", "pop" => "X", "push" => null],
            "else" => ["state" => "q1", "pop" => "X", "push" => null],

        ],
        "qf" => [
            "id" => ["state" => "qf", "pop" => false, "push" => "X"],
            "(" => ["state" => "qf", "pop" => false, "push" => "X"],
            ":" => ["state" => "qf", "pop" => "X", "push" => null],
            "int" => ["state" => "qf", "pop" => "X", "push" => null],
            ")" => ["state" => "qf", "pop" => "X", "push" => null],
            "tipo" => ["state" => "qf", "pop" => "X", "push" => null],
            ";" => ["state" => "qf", "pop" => "X", "push" => "X"],
            "if" => ["state" => "qf", "pop" => "X", "push" => null],
            ">" => ["state" => "qf", "pop" => false, "push" => "X"],
            "0" => ["state" => "qf", "pop" => false, "push" => "X"],
            "2" => ["state" => "qf", "pop" => false, "push" => "X"],
            "{" => ["state" => "qf", "pop" => false, "push" => "X"],
            "=" => ["state" => "qf", "pop" => "X", "push" => null],
            "/" => ["state" => "qf", "pop" => "X", "push" => null],
            "}" => ["state" => "qf", "pop" => "X", "push" => null],
            "return" => ["state" => "qf", "pop" => "X", "push" => null],
            "else" => ["state" => "qf", "pop" => "X", "push" => null],
        ]
    ];

    if (isset($transitions[$state][$input]) && ($transitions[$state][$input]["pop"] === false || $transitions[$state][$input]["pop"] === $stackTop)) {
        return $transitions[$state][$input];
    }

    return null;
}

function isAccepted($word) {
    $sigma = ["programa", "id", "int", "{", "}", ";", "if", "(", ")", ">", "0", "return", "/", "2", "else", ":", "=", "tipo"];
    $stack = [];
    $state = "q0";

    $string = explode(' ', $word);
    $string = array_filter($string, 'strlen');
    
    for ($i = 0; $i < count($string); $i++) {
        $input = $string[$i];

        if (!in_array($input, $sigma)) return false;

        $stackTop = end($stack);
        $newState = delta($state, $input, $stackTop);
     
        if ($newState === null) return false;

        $state = $newState["state"];
        
        if ($newState["pop"]) array_pop($stack);
        if ($newState["push"] !== null) $stack[] = $newState["push"];
    }

    return $state == "qf" && count($stack) == 0;
}


$word = "programa id ( id : int ) { int id ; if ( id > 0 ) { id = id / 2 ; } else { id = 0 ; } ; return id ; }";
echo isAccepted($word) ? "Aceito\n" : "Rejeitado\n";
$word1 = "programa id ( id : int ) { int id ; return id ; }";
echo isAccepted($word1) ? "Aceito\n" : "Rejeitado\n";
$word2 = "programa id ( id : int ) { if ( id > 0 ) { id = id / 2 ; } return id ; }";
echo isAccepted($word2) ? "Aceito\n" : "Rejeitado\n";
$word3 = "programa id ( id : int ) { if ( id > 0 ) { if ( id < 10 ) { id = 1 ; } else { id = 2 ; } } else { id = 0 ; } return id ; }";
echo isAccepted($word3) ? "Aceito\n" : "Rejeitado\n";
$word4 = "programa return";
echo isAccepted($word4) ? "Aceito\n" : "Rejeitado\n";

?>